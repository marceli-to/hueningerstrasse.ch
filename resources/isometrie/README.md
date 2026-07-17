# Isometrie – Quelle & Generator der interaktiven Etagen-Animation

Die interaktive Isometrie (Angebot Wohnen / Gewerbe) wird aus dem AI-File generiert:

- **`Hueningerstrasse_Isometrie.ai`** – Quelle. Enthält je Etage eine PDF-Ebene
  (OCG): `Umgebung`, `UG`, `EG`, `1. OG`, `2. OG`, `3. OG`.
- **`build_isometrie.py`** – erzeugt daraus
  `resources/views/components/objects/iso.blade.php` (Inline-SVG mit
  `<g class="iso-floor" data-iso-floor="…">` je Etage). Das Skript räumt dabei drei
  Eigenheiten des AI→SVG-Exports auf (Details als Kommentar an der jeweiligen
  Funktion):
  - **IDs je Etage eindeutig machen** – jede Ebene wird einzeln konvertiert und
    bringt `filter-0`, `mask-0` … mit; im gemeinsamen SVG kollidiert das.
  - **Transparenz auspacken** – enthält eine Ebene Transparenz, rastert pdftocairo
    sie zur Bitmap und schiebt die ganze Etage in `<defs>`. Die Vektorgeometrie wird
    wieder direkt gezeichnet, Bitmap und Filter fliegen raus.
  - **Etagen-Beschriftung ersetzen** – die Konturschrift aus dem AI läuft bei der
    Anzeigegrösse zu (Lettern ~10px hoch); sie wird durch echte `<text>`-Schrift an
    gemessener Position ersetzt.

Die Etagen-Animation (Hover Listenzeile → darüberliegende Etagen anheben + Etage
markieren) steckt in `resources/js/modules/iso.js` und `resources/css/iso.css`.

## Neu generieren (wenn sich das AI-File ändert)

Voraussetzungen: `poppler` (für `pdftocairo`) und ein Python-venv mit `pymupdf`.

```bash
brew install poppler
python3 -m venv .venv && .venv/bin/pip install pymupdf
.venv/bin/python resources/isometrie/build_isometrie.py
npm run build
```

Danach ggf. die Hub-Höhe (`--iso-lift` in `resources/css/iso.css`) nachjustieren.

## Wichtig für neue AI-Versionen
- Etagen als **oberste Ebenen** anlegen, Reihenfolge unten→oben (`ORDER` im Skript).
- Die Beschriftung darf im AI liegen bleiben – das Skript entfernt sie und setzt sie
  als `<text>` neu. Es erkennt sie an ihrer **Haarlinien-Kontur** (`stroke-width
  0.01`, `LABEL_PATH` im Skript). Wird die Schrift im AI anders gesetzt (z.B.
  gefüllt), greift die Erkennung nicht und die Labels erscheinen **doppelt** – dann
  entweder `LABEL_PATH` anpassen oder die Beschriftung im AI ganz weglassen.
- Position und Neigung der Labels werden aus dem AI gemessen (Fassadenwinkel 30°,
  `LABEL_SKEW`); verschiebst du sie im AI, wandern sie automatisch mit.
- **Schriftschnitt, -grösse und -farbe gehören ins CSS** (`.iso-label` in
  `resources/css/iso.css`), nicht ins AI – im AI gesetzte Konturschrift ist bei
  dieser Anzeigegrösse nicht lesbar zu bekommen.
- Transparenz im AI (Opazitätsmasken, Effekte wie Schlagschatten/weiche Kante) nach
  Möglichkeit vermeiden. Das Skript fängt sie ab, aber ohne sie bleibt der Export
  schlank und vorhersehbar.

## Offen (bewusst später)
- **Farbmarkierung pro Wohnung**: sobald die Wohnungen im AI als eigene benannte
  Formen je Etage vorliegen und der **Mieterspiegel final** ist. Dann pro Form
  `data-iso="<ref>"` setzen; die Verknüpfung zur Liste (`data-object-number`)
  steht in `table.blade.php` bereits bereit.
