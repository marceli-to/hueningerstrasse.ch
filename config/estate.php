<?php

/*
|--------------------------------------------------------------------------
| Hüningerstrasse 40 – Objektdaten (Angebot Gewerbe / Wohnen)
|--------------------------------------------------------------------------
|
| ACHTUNG / PLATZHALTER:
| Die Tabellenwerte unten stammen 1:1 aus dem Design-PDF und sind laut
| Vorgabe NICHT final ("Tabelle Werte hier stimmen nicht, bitte
| Mieterspiegel beachten"). Sobald der definitive Mieterspiegel vorliegt,
| werden die 'living'- und 'commercial'-Arrays hier ersetzt. Struktur
| bleibt gleich; die Filter- und Tabellenlogik zieht automatisch nach.
|
| state: free | reserved | taken  (steuert nur den Verfügbarkeits-Filter)
| plan:  Pfad zu einem Grundriss-PDF in /public/downloads oder null
|
*/

return [

    'project' => 'Hüningerstrasse 40',
    'address' => 'Hüningerstrasse 40, 4056 Basel',
    'maps_url' => 'https://www.google.com/maps/search/?api=1&query=H%C3%BCningerstrasse+40+4056+Basel',

    'floors' => [
        // key => [label, sort]
        'UG'   => ['label' => 'UG',    'sort' => 0],
        'EG'   => ['label' => 'EG',    'sort' => 1],
        '1.OG' => ['label' => '1. OG', 'sort' => 2],
        '2.OG' => ['label' => '2. OG', 'sort' => 3],
        '3.OG' => ['label' => '3. OG', 'sort' => 4],
    ],

    'filters' => [
        'availability' => [
            'NULL'     => 'Alle Wohnungen',
            'free'     => 'Verfügbar',
            'reserved' => 'Reserviert',
            'taken'    => 'Vermietet',
        ],
        'rooms'  => ['default' => 'Alle Zimmer'],
        'floors' => ['default' => 'Alle Etagen'],
    ],

    // --- Mietwohnungen (Platzhalter aus Design-PDF) ---
    'living' => [
        ['ref' => 'A.00.1', 'floor' => 'EG',   'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => '1.OG', 'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'A.00.2', 'floor' => 'EG',   'rooms' => '4.5', 'surface_living' => 102.5, 'surface_exterior' => 10.0, 'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => '1.OG', 'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'C.01.2', 'floor' => '1.OG', 'rooms' => '5.5', 'surface_living' => 118.0, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => '2.OG', 'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'A.00.2', 'floor' => '2.OG', 'rooms' => '5.5', 'surface_living' => 118.0, 'surface_exterior' => 10.0, 'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => '3.OG', 'rooms' => '5.5', 'surface_living' => 130.5, 'surface_exterior' => 13.4, 'state' => 'free', 'plan' => null],
        ['ref' => 'C.01.2', 'floor' => 'EG',   'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => 'EG',   'rooms' => '4.5', 'surface_living' => 102.5, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'A.00.2', 'floor' => '1.OG', 'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 10.0, 'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => '1.OG', 'rooms' => '5.5', 'surface_living' => 118.0, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'C.01.2', 'floor' => '2.OG', 'rooms' => '4.5', 'surface_living' => 103.5, 'surface_exterior' => 13.4, 'state' => 'free', 'plan' => null],
        ['ref' => 'B.01.1', 'floor' => '2.OG', 'rooms' => '5.5', 'surface_living' => 118.0, 'surface_exterior' => 7.4,  'state' => 'free', 'plan' => null],
        ['ref' => 'C.01.2', 'floor' => '3.OG', 'rooms' => '5.5', 'surface_living' => 130.5, 'surface_exterior' => 10.0, 'state' => 'free', 'plan' => null],
    ],

    // --- Gewerbeflächen (aus Vermietungsplänen 2026.07.09) ---
    // Eigene Struktur: object | geschoss | surface (m²) | lager (m² oder null) | plan (PDF)
    'commercial' => [
        [
            'object'  => 'Gewerbe EG',
            'floor'   => 'EG',         // -> Isometrie data-iso-floor
            'part'    => 'gewerbe',    // -> nur die "Gewerbe"-Gruppe der EG-Etage einfärben
            'surface' => 203.7,
            'lager'   => null,
            'state'   => 'free',
            'plan'    => '/downloads/H40_Vermietungsplan_GewerbeEG_2026.07.09.pdf',
        ],
        [
            'object'  => 'Gewerbe 1. UG',
            'floor'   => 'UG',         // 1. Untergeschoss -> Isometrie data-iso-floor="UG"
            'part'    => 'gewerbe',    // -> nur die "Gewerbe"-Gruppe der UG-Etage
            'surface' => 354.1,
            'lager'   => 13.2,
            'state'   => 'free',
            'plan'    => '/downloads/H40_Vermietungsplan_Gewerbe1UG_2026.07.09.pdf',
        ],
    ],

];
