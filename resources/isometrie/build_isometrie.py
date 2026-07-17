#!/usr/bin/env python3
"""
Baut aus dem AI-File die interaktive Isometrie-Blade-Komponente.

Pipeline:
  1. AI (PDF-kompatibel) öffnen, je Etagen-OCG ein Einzel-Layer-PDF speichern (fitz)
  2. jedes Layer-PDF nach SVG wandeln (pdftocairo / poppler)
  3. Layer zu einem SVG mergen: Gebäudeflächen als .iso-face/.iso-top klassifizieren,
     Etagen als <g class="iso-floor" data-iso-floor="…"> in Reihenfolge unten→oben
  4. Ergebnis als resources/views/components/objects/iso.blade.php schreiben

Die Etagen-Beschriftungen kommen seit der AI-Version vom 17.07.2026 als Pfade aus
dem File (Schrift in Pfade umgewandelt) und liegen je in der Ebene ihrer Etage –
sie werden dadurch beim Anheben automatisch mitbewegt. Das frühere <text>-Overlay
entfällt; ein erneutes Setzen würde die Labels doppelt zeichnen.

Voraussetzungen:
  - Python-venv mit pymupdf:   python3 -m venv .venv && .venv/bin/pip install pymupdf
  - poppler (pdftocairo):      brew install poppler
Aufruf:
  .venv/bin/python resources/isometrie/build_isometrie.py
"""
import os, re, subprocess, tempfile
import fitz  # pymupdf

HERE = os.path.dirname(os.path.abspath(__file__))
AI   = os.path.join(HERE, "Hueningerstrasse_Isometrie.ai")
BLADE = os.path.abspath(os.path.join(
    HERE, "..", "views", "components", "objects", "iso.blade.php"))

# OCG-Name im AI -> (Floor-Key wie in config/estate.php, oder None für Basis/Umgebung)
FLOOR_OF = {
    "Umgebung": None,
    "UG": "UG", "EG": "EG",
    "1. OG": "1.OG", "2. OG": "2.OG", "3. OG": "3.OG",
}
# Reihenfolge im Ausgabe-SVG: unten -> oben (darüberliegende Etagen = nachfolgende Geschwister)
ORDER = ["Umgebung", "UG", "EG", "1. OG", "2. OG", "3. OG"]

# Gebäude-Flächenfarben aus dem Export -> CSS-steuerbare Klassen
FACE = "rgb(81.568909%, 86.66687%, 87.843323%)"
TOP  = "rgb(87.843323%, 91.372681%, 92.156982%)"

# Etagen-Beschriftung: im AI ist sie Konturschrift (in Pfade umgewandelt). Bei der
# Anzeigegrösse der Isometrie sind die Lettern ~10px hoch – die Konturen laufen dann
# zu und die Schrift wirkt klobig, egal bei welcher Strichstärke. Sie wird darum aus
# dem Export entfernt und als echte <text>-Schrift gesetzt (Schnitt/Grösse via CSS).
# Die Pfade sind eindeutig an ihrer Haarlinien-Kontur erkennbar.
LABEL_PATH  = r'<path[^>]*stroke-width="0\.01"[^>]*/>'
LABEL_TEXT  = {"UG": "UG", "EG": "EG", "1.OG": "1. OG", "2.OG": "2. OG", "3.OG": "3. OG"}
# Fassadenwinkel 30° (aus den Gebäudekanten gemessen) -> Text liegt in der Fassade
LABEL_SKEW  = "0.866, 0.5, 0, 1"

def round_nums(s):
    """Koordinaten auf eine Nachkommastelle kürzen (spart ~30% Dateigrösse).
    Linienstärken bleiben ausgenommen: eine im AI bewusst dünn gesetzte Linie
    (0.01) würde sonst zu 0.0 gerundet und wäre im SVG unsichtbar."""
    widths = []
    def stash(m):
        widths.append(m.group(0))
        return f"\x00{len(widths) - 1}\x00"
    s = re.sub(r'stroke-width="[^"]*"', stash, s)
    s = re.sub(r"-?\d+\.\d+", lambda m: f"{float(m.group()):.1f}", s)
    return re.sub(r"\x00(\d+)\x00", lambda m: widths[int(m.group(1))], s)

def fix_hairlines(s):
    """Linienbreite exakt 0 ist in PDF die 'dünnste darstellbare Linie', in SVG
    dagegen unsichtbar. pdftocairo überträgt die 0 wörtlich; solche Linien wären
    im Browser weg. non-scaling-stroke = konstant 1px und entspricht der PDF-
    Bedeutung.

    Nur echte Nullen anfassen: eine im AI bewusst dünn gesetzte Linie (z.B. 0.01)
    ist eine Gestaltungsentscheidung und darf nicht auf 1px aufgeblasen werden.
    Muss deshalb VOR round_nums() laufen – das Runden auf eine Nachkommastelle
    würde 0.01 sonst zu 0.0 machen und hier fälschlich als 'echte Null' gelten."""
    return re.sub(r'stroke-width="0(?:\.0+)?"',
                  'stroke-width="1" vector-effect="non-scaling-stroke"', s)

def inner(svg):
    svg = re.sub(r"<\?xml[^>]*\?>", "", svg)
    return re.search(r"<svg\b[^>]*>(.*)</svg>", svg, re.S).group(1).strip()

def group_content(body, start):
    """Inhalt des <g>, das bei start beginnt (verschachtelte <g> korrekt zählen)."""
    i = body.index(">", start) + 1
    depth, j = 1, i
    for m in re.finditer(r"<(/?)g\b[^>]*?(/?)>", body[i:]):
        if m.group(2):          # <g .../> – selbstschliessend
            continue
        depth += -1 if m.group(1) else 1
        if depth == 0:
            return body[i:i + m.start()]
    raise ValueError("kein schliessendes </g> gefunden")

def unwrap_compositing(body, prefix):
    """Enthält eine AI-Ebene Transparenz, kann pdftocairo das in SVG nicht abbilden:
    Es rastert die transparente Gruppe zu einer Bitmap und komponiert sie per Filter
    über die restliche Geometrie – die komplette Etage landet dabei in <defs> und
    wird nur noch als Filter-Ergebnis gezeichnet.

    Folgen: die Etagen-Beschriftung ist ein Pixelbild (unscharf), ihr Hintergrund ist
    in der Bitmap eingebacken (bleibt beim Umfärben der Etage hellblau stehen).

    Darum die Vektorgeometrie (compositing-group-2) direkt zeichnen und Bitmap wie
    Filter verwerfen. Der Versatz translate(415,340) der Gruppe wird von der
    Filterhülle translate(-415,-340) aufgehoben – beim Auspacken selbst kompensieren."""
    key = f'<g id="{prefix}-compositing-group-2"'
    if key not in body:
        return body
    inner = group_content(body, body.index(key))
    return f'<g transform="translate(-415, -340)">\n{inner}\n</g>'

def path_bbox(tag):
    """Bounding-Box eines <path> in Zeichenkoordinaten (eigenes matrix() eingerechnet)."""
    d = re.search(r'\sd="([^"]*)"', tag)
    if not d:
        return None
    n = [float(v) for v in re.findall(r"-?\d+(?:\.\d+)?", d.group(1))]
    if len(n) < 2:
        return None
    xs, ys = n[0::2], n[1::2]
    m = re.search(r'transform="matrix\(([^)]*)\)"', tag)
    if m:
        a, b, c, dd, e, f = [float(v) for v in m.group(1).split(",")]
        xs, ys = ([a * x + c * y + e for x, y in zip(xs, ys)],
                  [b * x + dd * y + f for x, y in zip(xs, ys)])
    return min(xs), min(ys), max(xs), max(ys)

def replace_label(body, floor):
    """Konturschrift-Pfade der Etagenbeschriftung entfernen und durch <text> ersetzen.

    Der Textursprung wird aus der Bounding-Box aller Label-Pfade gerechnet, nicht aus
    dem Glyphen-Transform: pdftocairo setzt je Kontur ein eigenes matrix(), dessen
    Ursprung nicht zuverlässig auf der Grundlinie liegt. Die Zeile liegt in der
    Fassadenebene (30°), fällt über ihre Breite also um breite*sin(30) ab – daraus
    ergibt sich die Grundlinie am linken Rand."""
    paths = re.findall(LABEL_PATH, body)
    if not paths:
        return body, None
    xs, ys = [], []
    for p in paths:
        b = path_bbox(p)
        if b:
            xs += [b[0], b[2]]
            ys += [b[1], b[3]]
        body = body.replace(p, "")
    if not xs:
        return body, None
    x0, x1, y1 = min(xs), max(xs), max(ys)
    baseline = y1 - 0.5 * (x1 - x0) / 0.866
    label = (f'<text class="iso-label" transform="matrix({LABEL_SKEW}, {x0:.1f}, {baseline:.1f})">'
             f'{LABEL_TEXT[floor]}</text>')
    return body, label

def namespace_ids(body, prefix):
    """Jede Etage wird einzeln konvertiert; enthält das AI Transparenz-Effekte,
    liefert pdftocairo je Layer <defs> mit denselben IDs (filter-0, mask-0, …).
    Im gemeinsamen SVG gewännen sonst die IDs der ersten Etage und würden die
    übrigen ausblenden – darum je Etage eindeutig machen."""
    for i in set(re.findall(r'id="([^"]+)"', body)):
        e = re.escape(i)
        body = re.sub(rf'id="{e}"',        f'id="{prefix}-{i}"',        body)
        body = re.sub(rf'url\(#{e}\)',     f'url(#{prefix}-{i})',       body)
        body = re.sub(rf'href="#{e}"',     f'href="#{prefix}-{i}"',     body)
    return body

def main():
    doc = fitz.open(AI)
    ocgs = {info["name"]: xref for xref, info in doc.get_ocgs().items()}
    allx = list(ocgs.values())

    with tempfile.TemporaryDirectory() as tmp:
        svg_by_name = {}
        for name in ORDER:
            x = ocgs[name]
            d = fitz.open(AI)
            d.set_layer(-1, on=[x], off=[o for o in allx if o != x])
            pdf = os.path.join(tmp, f"{x}.pdf")
            svg = os.path.join(tmp, f"{x}.svg")
            d.save(pdf, garbage=3); d.close()
            subprocess.run(["pdftocairo", "-svg", pdf, svg], check=True)
            svg_by_name[name] = open(svg).read()

    parts = []
    for name in ORDER:
        floor = FLOOR_OF[name]
        body = inner(svg_by_name[name])
        prefix = (floor or "base").replace(".", "").lower()
        body = namespace_ids(body, prefix)
        body = unwrap_compositing(body, prefix)
        body = body.replace(f'fill="{FACE}"', 'class="iso-face"')
        body = body.replace(f'fill="{TOP}"',  'class="iso-top"')
        label = None
        if floor is not None:
            body, label = replace_label(body, floor)
        body = fix_hairlines(body)
        body = round_nums(body)
        if floor is None:
            parts.append(f'  <g class="iso-base">\n{body}\n  </g>')
        else:
            # Das Label liegt in der Etagen-Gruppe und wird darum mit angehoben.
            parts.append(f'  <g class="iso-floor" data-iso-floor="{floor}">\n{body}\n'
                         f'    {label or ""}\n  </g>')

    svg = (
        '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" '
        'viewBox="0 0 4150 3400" class="iso-svg {{ $class ?? \'\' }}" role="img" '
        'aria-label="Isometrie Hüningerstrasse 40 – Etagen UG bis 3. OG">\n'
        + "\n".join(parts) + "\n</svg>\n"
    )
    header = (
        "{{-- Interaktive Isometrie – generiert aus resources/isometrie/Hueningerstrasse_Isometrie.ai\n"
        "     via resources/isometrie/build_isometrie.py. NICHT von Hand editieren; bei Änderungen\n"
        "     am AI-File das Skript erneut laufen lassen. Etagen = <g data-iso-floor>. --}}\n"
    )
    open(BLADE, "w").write(header + svg)
    print("geschrieben:", BLADE, f"({len(svg)//1024} KB, {svg.count('data-iso-floor')} Etagen)")

if __name__ == "__main__":
    main()
