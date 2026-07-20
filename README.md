# Hüningerstrasse 40

Vermarktungs-Website für das Wohn- und Gewerbeprojekt Hüningerstrasse 40, Basel.

**Stack:** Laravel 13 · Livewire 4 · Tailwind CSS v4 · Alpine.js · Vite

---

## Setup

```bash
composer install
npm install
cp .env.example .env        # danach APP_KEY, Mail- und Turnstile-Keys setzen
php artisan key:generate

npm run dev                 # Vite Dev-Server (HMR)
# oder
npm run build               # Produktions-Build
```

Lokale URL (Herd/Valet): `https://hueningerstrasse-basel.local`

Wichtige `.env`-Werte: `APP_NAME`, `APP_URL`, `APP_LOCALE=de_CH`,
`MAIL_*` (Bestätigungsmail), `TURNSTILE_*` (Cloudflare Spam-Schutz, optional).

---

## Projektstruktur (Views)

```
resources/views/
├── app.blade.php              # Root-Layout (@yield content, meta_title, meta_description)
├── pages/                     # Eine Datei pro Route (project, location, commercial, living, contact, imprint, privacy)
├── livewire/contact-form.*    # Kontaktformular (App\Livewire\ContactForm)
└── components/
    ├── layout/                # html, head, body, header, footer, inner (Container), main
    ├── headings/              # h1, h2, h3
    ├── buttons/primary        # DER Button — nie den Style kopieren, immer diese Komponente
    ├── form/                  # input, textarea, checkbox, select  (nur EIN Formular-Ordner!)
    ├── menu/                  # desktop/*, mobile/*
    ├── sections/hero-split    # zweispaltiges Text/Bild-Layout
    ├── gallery/carousel       # Swiper-Slider
    ├── objects/               # Angebots-Tabelle + Filter + Isometrie
    ├── icons/                 # SVG-Icons als Blade-Komponenten (currentColor)
    └── media, links, map, swiper …
```

---

## Styling-Konventionen

> Kurz: **keine hardcodierten Farben, keine kopierten Styles.** Farben kommen aus
> Tokens, wiederkehrende Elemente aus Komponenten.

### Farben — immer über Tokens

Alle Farben sind in [`resources/css/colors.css`](resources/css/colors.css) als
`@theme`-Tokens definiert und stehen als Tailwind-Utilities zur Verfügung
(`text-ink`, `bg-sky`, `hover:bg-bordeaux`, …). **Keine Hex-Werte in Blade/JS.**

| Token | Wert | Verwendung |
|-------|------|-----------|
| `ink` | `#4b4b50` | Text, Überschriften, Rahmen |
| `sky` | `#e0e9eb` | Section-Bänder, Header/Footer |
| `mist` | `#d0dde0` | Isometrie-Gebäude, sanfte Akzente |
| `bordeaux` | `#9b4053` | Buttons, Links, aktive Navigation |
| `error` / `error-bg` / `error-border` | Rottöne | Formular-Validierung |
| `iso-*` | div. | Isometrie-Zustände (siehe colors.css) |
| `state-free/reserved/taken` | Ampel | Verfügbarkeits-Punkte |

Ausnahme: Die rohen Hex-Werte in `components/objects/iso.blade.php` sind
**SVG-Export-Artefakte** aus Illustrator (nicht editieren). Die sichtbaren
Isometrie-Farben werden in [`resources/css/iso.css`](resources/css/iso.css) über
die `iso-*`-Tokens gesetzt.

### Abstände — 1 Einheit = 1 px

[`resources/css/spacing.css`](resources/css/spacing.css) definiert die Spacing-Skala
in 1-px-Schritten: `--spacing-16 = 1rem = 16px`, also **`p-13` = 13 px, `gap-24` = 24 px**.
Das Design ist px-basiert; deshalb Ganzzahl-Utilities statt der Standard-Tailwind-Skala.

### Typografie

- **Body/Fliesstext:** Token-Skala aus [`resources/css/fontsize.css`](resources/css/fontsize.css)
  (`text-lg`, `text-xl`, …).
- **Überschriften, Menü, Button:** nutzen bewusst **feste Pixelwerte** als
  Arbitrary-Values (z. B. `text-[51.9px]`, `tracking-[1.5px]`), weil sie exakt der
  Design-Vorlage folgen. Quelle der Wahrheit sind die Komponenten in
  `components/headings/`, `menu/desktop/item`, `buttons/primary` — Grössen dort ändern,
  nicht pro Seite. `h1` und `h2` sind absichtlich identisch (nur `margin-bottom` unterscheidet sich).
- Schrift: **Bio Sans** (Adobe Fonts / Typekit, geladen in `app.css`).

### Komponenten statt Wiederholung

- Buttons **immer** über `<x-buttons.primary>` (leitet Attribute wie `wire:*` durch) —
  nie den Klassen-String kopieren.
- Container-Breite/Padding über `<x-layout.inner>`.
- Icons als `<x-icons.name>` (nutzen `currentColor`, Grösse per `class="w-… h-…"`).

### Design-Referenz

Die verbindliche Gestaltung liegt als PDF in
[`resources/design/`](resources/design/) (Ansicht + Beschreibung inkl. Font/Farb-Spec).

---

## Formular & Anmeldungen

Die Formular-Logik ist aus dem Vorlage-Projekt
[imwaldacher.ch](https://github.com/marceli-to/imwaldacher.ch) übernommen.

**Es gibt bewusst kein Admin-Backend** — kein Login, keine Übersicht im Browser.
Der Kunde erhält die Anmeldungen ausschliesslich als **wöchentliche E-Mail mit
CSV-Anhang**.

### Ablauf

1. `App\Livewire\ContactForm` validiert und speichert nach `registrations` (SQLite).
2. Der Absender bekommt sofort eine Bestätigungsmail (`App\Mail\RegistrationConfirmation`).
3. Jeden **Montag 08:00** (Europe/Zurich) sammelt `registrations:export-weekly` alle
   noch nicht exportierten Einträge, mailt sie als CSV an
   `REGISTRATIONS_EXPORT_EMAIL` und setzt `exported_at`.

### Daten einsehen

```bash
sqlite3 database/database.sqlite \
  "SELECT created_at, first_name, last_name, email FROM registrations ORDER BY created_at DESC;"

php artisan registrations:export-weekly --all   # alle Einträge sofort per Mail schicken
php artisan registrations:export-weekly         # nur neue (setzt exported_at)
```

Die DB-Datei ist über `database/.gitignore` (`*.sqlite*`) ausgenommen und wird beim
Deploy **nicht** überschrieben.

### ⚠️ Cron auf dem Server einrichten

Der Scheduler-Eintrag in [`routes/console.php`](routes/console.php) allein genügt
nicht — Laravel braucht einen System-Cron, der jede Minute `schedule:run` aufruft.
**Ohne diesen Cron wird nie eine Export-Mail verschickt** und die Anmeldungen bleiben
unbemerkt in der DB liegen.

In Plesk unter *Geplante Aufgaben* anlegen (nur **Live**):

```
* * * * * cd /httpdocs && /opt/php84/bin/php artisan schedule:run >> /dev/null 2>&1
```

Auf Staging bewusst **nicht** einrichten, sonst gehen Testanmeldungen an den Kunden.

Prüfen, ob der Eintrag registriert ist: `php artisan schedule:list`

### Spam-Schutz

Cloudflare Turnstile ist eingebaut, aber **nur aktiv, wenn `TURNSTILE_SITE_KEY` und
`TURNSTILE_SECRET_KEY` in der `.env` gesetzt sind**. Bei leerem Secret gibt
`verifyTurnstile()` stillschweigend `true` zurück — dann ist das Formular
ungeschützt (kein Honeypot, kein Rate-Limiting als Fallback).

---

## Wichtige Befehle

```bash
php artisan test            # Tests
php artisan view:clear      # Blade-Cache leeren (nach Config-Änderungen)
php artisan config:clear    # Config-Cache leeren (nach .env-Änderungen)
npm run build               # Assets für Produktion bauen
php artisan schedule:list   # Prüfen, ob der Wochen-Export registriert ist
```
