#!/usr/bin/env python3
"""
Baut aus dem AI-File die interaktive Isometrie-Blade-Komponente.

Pipeline:
  1. AI (PDF-kompatibel) öffnen, je Etagen-OCG ein Einzel-Layer-PDF speichern (fitz)
  2. jedes Layer-PDF nach SVG wandeln (pdftocairo / poppler)
  3. Layer zu einem SVG mergen: Gebäudeflächen als .iso-face/.iso-top klassifizieren,
     Etagen als <g class="iso-floor" data-iso-floor="…"> in Reihenfolge unten→oben,
     Etagen-Labels als <text>-Overlay (der Outline-Text im AI geht bei AI→SVG verloren)
  4. Ergebnis als resources/views/components/objects/iso.blade.php schreiben

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

# Etagen-Beschriftungen (User-Units, aus dem Original-Render gemessen)
LABELS = {
    "UG":   (630, 1748, "UG"),
    "EG":   (630, 1566, "EG"),
    "1.OG": (630, 1382, "1. OG"),
    "2.OG": (630, 1198, "2. OG"),
    "3.OG": (630, 1014, "3. OG"),
}

def round_nums(s):
    return re.sub(r"-?\d+\.\d+", lambda m: f"{float(m.group()):.1f}", s)

def inner(svg):
    svg = re.sub(r"<\?xml[^>]*\?>", "", svg)
    return re.search(r"<svg\b[^>]*>(.*)</svg>", svg, re.S).group(1).strip()

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
        body = body.replace(f'fill="{FACE}"', 'class="iso-face"')
        body = body.replace(f'fill="{TOP}"',  'class="iso-top"')
        body = round_nums(body)
        if floor is None:
            parts.append(f'  <g class="iso-base">\n{body}\n  </g>')
        else:
            parts.append(f'  <g class="iso-floor" data-iso-floor="{floor}">\n{body}\n  </g>')

    labels = "\n".join(
        f'    <text class="iso-label" data-iso-label="{fk}" x="{x}" y="{y}" '
        f'text-anchor="start" dominant-baseline="central">{t}</text>'
        for fk, (x, y, t) in LABELS.items()
    )
    parts.append('  <g class="iso-labels">\n' + labels + '\n  </g>')

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
