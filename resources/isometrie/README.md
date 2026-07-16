# Isometrie – Quelle & Generator der interaktiven Etagen-Animation

Die interaktive Isometrie (Angebot Wohnen / Gewerbe) wird aus dem AI-File generiert:

- **`Hueningerstrasse_Isometrie.ai`** – Quelle. Enthält je Etage eine PDF-Ebene
  (OCG): `Umgebung`, `UG`, `EG`, `1. OG`, `2. OG`, `3. OG`.
- **`build_isometrie.py`** – erzeugt daraus
  `resources/views/components/objects/iso.blade.php` (Inline-SVG mit
  `<g class="iso-floor" data-iso-floor="…">` je Etage + Etagen-Labels als Overlay).

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

Danach ggf. die Hub-Höhe (`--iso-lift` in `resources/css/iso.css`) und die
Label-Positionen (`LABELS` in `build_isometrie.py`) nachjustieren.

## Wichtig für neue AI-Versionen
- Etagen als **oberste Ebenen** anlegen, Reihenfolge unten→oben (`ORDER` im Skript).
- Etagen-Beschriftungen im AI sind Outline-Text und gehen bei AI→SVG verloren –
  sie werden vom Skript als `<text>` neu gesetzt (`LABELS`).

## Offen (bewusst später)
- **Farbmarkierung pro Wohnung**: sobald die Wohnungen im AI als eigene benannte
  Formen je Etage vorliegen und der **Mieterspiegel final** ist. Dann pro Form
  `data-iso="<ref>"` setzen; die Verknüpfung zur Liste (`data-object-number`)
  steht in `table.blade.php` bereits bereit.
