#!/usr/bin/env python3
"""
Baut die interaktive Isometrie-Blade-Komponente aus einem *direkten* Illustrator-
SVG-Export (nicht dem PDF->pdftocairo-Weg). Vorteil: Illustrator-SVG erhält die
Objektnamen als id/data-name -> Etagen (UG/EG/…) und benannte Flächen (Gewerbe,
Wohnungen V1/HA1/…) bleiben adressierbar.

Was das Script macht:
  1. Face/Top-Klassen aus dem <style> ermitteln (fill #d0dde0 / #e0e9eb)
  2. <svg>-Root auf die Komponenten-Signatur setzen (class="iso-svg {{ $class }}")
  3. Etagen-Gruppen (id UG/EG/_x31_._OG…) -> class="iso-floor" data-iso-floor="…"
     Umgebung -> class="iso-base"
  4. Gewerbe-Gruppen (id Gewerbe / Gewerbe1) -> data-iso-part="gewerbe"
  5. Flächen mit Face-/Top-Farbe zusätzlich iso-face / iso-top klassifizieren
     (robust gegen wechselnde st-Nummern beim Re-Export)
  6. Etagen-Labels: eingebettete PNG-Bitmaps (scale(.48)) entfernen und je Etage
     durch <text class="iso-label"> ersetzen (Vektor, Schnitt/Grösse via CSS) –
     wie in Commit de701dd bewusst eingeführt.

Aufruf:  python3 resources/isometrie/build_from_svg.py
Quelle:  resources/isometrie/Hueningerstrasse_Isometrie.svg
Ziel:    resources/views/components/objects/iso.blade.php
"""
import os, re

HERE  = os.path.dirname(os.path.abspath(__file__))
SVG   = os.path.join(HERE, "Hueningerstrasse_Isometrie.svg")
BLADE = os.path.abspath(os.path.join(HERE, "..", "views", "components", "objects", "iso.blade.php"))

FLOOR_MAP = {"UG": "UG", "EG": "EG", "_x31_._OG": "1.OG", "_x32_._OG": "2.OG", "_x33_._OG": "3.OG"}

# Etagen-Labels in Root-Koordinaten (stimmen mit dem SVG-Koordinatensystem überein).
LABELS = {
    "UG":   '<text class="iso-label" transform="matrix(0.866, 0.5, 0, 1, 643.9, 1875.9)">UG</text>',
    "EG":   '<text class="iso-label" transform="matrix(0.866, 0.5, 0, 1, 648.3, 1695.1)">EG</text>',
    "1.OG": '<text class="iso-label" transform="matrix(0.866, 0.5, 0, 1, 645.2, 1508.5)">1. OG</text>',
    "2.OG": '<text class="iso-label" transform="matrix(0.866, 0.5, 0, 1, 650.4, 1327.2)">2. OG</text>',
    "3.OG": '<text class="iso-label" transform="matrix(0.866, 0.5, 0, 1, 653.8, 1165.6)">3. OG</text>',
}

ROOT_TAG = ('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" '
            'viewBox="0 0 4150 3400" class="iso-svg {{ $class ?? \'\' }}" role="img" '
            'aria-label="Isometrie Hüningerstrasse 40 – Etagen UG bis 3. OG">')

HEADER = ("{{-- Interaktive Isometrie – generiert aus resources/isometrie/"
          "Hueningerstrasse_Isometrie.svg\n     via resources/isometrie/build_from_svg.py. "
          "NICHT von Hand editieren; bei Änderungen\n     das SVG neu exportieren und das "
          "Skript erneut laufen lassen. Etagen = <g data-iso-floor>,\n     benannte Flächen "
          "(Gewerbe, Wohnungen) = id/data-name aus Illustrator. --}}\n")


def find_matching_close(s, open_end):
    """Ab Position open_end (direkt nach dem <g …>) den passenden </g> finden."""
    depth = 1
    i = open_end
    for m in re.finditer(r"<(/?)g\b", s[open_end:]):
        if m.group(1):
            depth -= 1
        else:
            depth += 1
        if depth == 0:
            return open_end + m.start()
    raise RuntimeError("kein passender </g>")


def main():
    s = open(SVG, encoding="utf-8").read()

    # 0. XML-Prolog entfernen: inline im HTML funktionslos, und bei
    #    short_open_tag=On liest PHP das "<?" als Code-Öffner -> Parse-Error.
    s = re.sub(r"^\s*<\?xml[^>]*\?>\s*", "", s)

    # 1. Face/Top-Klassen aus <style>
    style = re.search(r"<style>(.*?)</style>", s, re.S).group(1)
    face, top = set(), set()
    for m in re.finditer(r"([^{}]+)\{([^}]*)\}", style):
        fill = re.search(r"fill:\s*(#[0-9a-fA-F]+)", m.group(2))
        if not fill:
            continue
        classes = re.findall(r"\.(st\d+)", m.group(1))
        c = fill.group(1).lower()
        if c == "#d0dde0":
            face.update(classes)
        elif c == "#e0e9eb":
            top.update(classes)

    # 2. Root-Tag
    s = re.sub(r"<svg\b[^>]*>", ROOT_TAG.replace("\\", "\\\\"), s, count=1)

    # 3. Etagen + Basis
    for gid, key in FLOOR_MAP.items():
        s = s.replace(f'<g id="{gid}">',
                      f'<g class="iso-floor" data-iso-floor="{key}" id="{gid}">', 1)
    s = s.replace('<g id="Umgebung">', '<g class="iso-base" id="Umgebung">', 1)

    # 4. Gewerbe -> Teilobjekt
    s = s.replace('<g id="Gewerbe">', '<g id="Gewerbe" data-iso-part="gewerbe">', 1)
    s = s.replace('<g id="Gewerbe1" data-name="Gewerbe">',
                  '<g id="Gewerbe1" data-name="Gewerbe" data-iso-part="gewerbe">', 1)

    # 5. iso-face / iso-top ergänzen
    def add_iso(m):
        cls = m.group(1)
        names = set(cls.split())
        if names & face:
            return f'class="{cls} iso-face"'
        if names & top:
            return f'class="{cls} iso-top"'
        return m.group(0)
    s = re.sub(r'class="([^"]*)"', add_iso, s)

    # 6a. Bitmap-Labels entfernen
    s = re.sub(r"<image\b[^>]*scale\(\.48\)[^>]*/>", "", s)

    # 6b. Vektor-Labels je Etage vor deren </g> einsetzen
    for key, label in LABELS.items():
        marker = f'data-iso-floor="{key}"'
        gi = s.find(marker)
        open_end = s.find(">", gi) + 1
        close = find_matching_close(s, open_end)
        s = s[:close] + "    " + label + "\n  " + s[close:]

    out = HEADER + s
    open(BLADE, "w", encoding="utf-8").write(out)
    print("geschrieben:", BLADE)
    print("face-classes:", sorted(face), " top-classes:", sorted(top))
    print("data-iso-part=gewerbe:", out.count('data-iso-part="gewerbe"'),
          " iso-face:", out.count("iso-face"), " iso-top:", out.count("iso-top"),
          " labels:", out.count('class="iso-label"'))


if __name__ == "__main__":
    main()
