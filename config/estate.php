<?php

/*
|--------------------------------------------------------------------------
| Hüningerstrasse 40 – Objektdaten (Angebot Gewerbe / Wohnen)
|--------------------------------------------------------------------------
|
| 'living' stammt aus dem Mieterspiegel H40_Wohnungen_Hueningerstrasse.xlsx
| (storage/app/private) und ist final. 'commercial' stammt weiterhin aus den
| Vermietungsplaenen. Struktur bleibt gleich; Filter- und Tabellenlogik
| ziehen automatisch nach.
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

    // --- Mietwohnungen (Quelle: H40_Wohnungen_Hueningerstrasse.xlsx, Stand 2026.08.03) ---
    // 34 Einheiten; 'plan' verweist 1:1 auf die Vermietungsplaene vom 2026.07.14
    // unter /public/downloads/Grundrissplaene_Wohnen.
    'living' => [
        ['ref' => 'V.1',     'floor' => 'EG',    'rooms' => '1.5', 'surface_living' =>  42, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.1_2026.07.14.pdf'],
        ['ref' => 'V.2',     'floor' => 'EG',    'rooms' => '2.5', 'surface_living' =>  75, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.2_2026.07.14.pdf'],
        ['ref' => 'V.101',   'floor' => '1.OG',  'rooms' => '2.5', 'surface_living' =>  80, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.101_2026.07.14.pdf'],
        ['ref' => 'V.102',   'floor' => '1.OG',  'rooms' => '2.5', 'surface_living' =>  76, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.102_2026.07.14.pdf'],
        ['ref' => 'V.103',   'floor' => '1.OG',  'rooms' => '3.5', 'surface_living' =>  88, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.103_2026.07.14.pdf'],
        ['ref' => 'V.104',   'floor' => '1.OG',  'rooms' => '4.5', 'surface_living' => 112, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.104_2026.07.14.pdf'],
        ['ref' => 'V.201',   'floor' => '2.OG',  'rooms' => '2.5', 'surface_living' =>  80, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.201_2026.07.14.pdf'],
        ['ref' => 'V.202',   'floor' => '2.OG',  'rooms' => '2.5', 'surface_living' =>  76, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.202_2026.07.14.pdf'],
        ['ref' => 'V.203',   'floor' => '2.OG',  'rooms' => '3.5', 'surface_living' =>  88, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.203_2026.07.14.pdf'],
        ['ref' => 'V.204',   'floor' => '2.OG',  'rooms' => '4.5', 'surface_living' => 112, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.204_2026.07.14.pdf'],
        ['ref' => 'V.301',   'floor' => '3.OG',  'rooms' => '3.5', 'surface_living' =>  78, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.301_2026.07.14.pdf'],
        ['ref' => 'V.302',   'floor' => '3.OG',  'rooms' => '2.5', 'surface_living' =>  68, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.302_2026.07.14.pdf'],
        ['ref' => 'V.303',   'floor' => '3.OG',  'rooms' => '3.5', 'surface_living' =>  88, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.303_2026.07.14.pdf'],
        ['ref' => 'V.304',   'floor' => '3.OG',  'rooms' => '4.5', 'surface_living' => 112, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_V.304_2026.07.14.pdf'],
        ['ref' => 'HA.1',    'floor' => 'EG',    'rooms' => '5.5', 'surface_living' => 122, 'surface_exterior' =>  7, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HA.1_2026.07.14.pdf'],
        ['ref' => 'HA.2',    'floor' => 'EG',    'rooms' => '1.5', 'surface_living' =>  53, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HA.2_2026.07.14.pdf'],
        ['ref' => 'HA.101',  'floor' => '1.OG',  'rooms' => '5.5', 'surface_living' => 126, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HA.101_2026.07.14.pdf'],
        ['ref' => 'HA.102',  'floor' => '1.OG',  'rooms' => '2.5', 'surface_living' =>  71, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HA.102_2026.07.14.pdf'],
        ['ref' => 'HA.201',  'floor' => '2.OG',  'rooms' => '5.5', 'surface_living' => 126, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HA.201_2026.07.14.pdf'],
        ['ref' => 'HA.202',  'floor' => '2.OG',  'rooms' => '2.5', 'surface_living' =>  71, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HA.202_2026.07.14.pdf'],
        ['ref' => 'HB.1',    'floor' => 'EG',    'rooms' => '4.5', 'surface_living' =>  96, 'surface_exterior' =>  7, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HB.1_2026.07.14.pdf'],
        ['ref' => 'HB.2',    'floor' => 'EG',    'rooms' => '3.5', 'surface_living' =>  83, 'surface_exterior' =>  7, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HB.2_2026.07.14.pdf'],
        ['ref' => 'HB.101',  'floor' => '1.OG',  'rooms' => '4.5', 'surface_living' =>  99, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HB.101_2026.07.14.pdf'],
        ['ref' => 'HB.102',  'floor' => '1.OG',  'rooms' => '4.5', 'surface_living' => 102, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HB.102_2026.07.14.pdf'],
        ['ref' => 'HB.201',  'floor' => '2.OG',  'rooms' => '4.5', 'surface_living' =>  99, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HB.201_2026.07.14.pdf'],
        ['ref' => 'HB.202',  'floor' => '2.OG',  'rooms' => '4.5', 'surface_living' => 102, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HB.202_2026.07.14.pdf'],
        ['ref' => 'HC.1',    'floor' => 'EG',    'rooms' => '5.5', 'surface_living' => 121, 'surface_exterior' =>  7, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.1_2026.07.14.pdf'],
        ['ref' => 'HC.2',    'floor' => 'EG',    'rooms' => '3.5', 'surface_living' =>  83, 'surface_exterior' =>  7, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.2_2026.07.14.pdf'],
        ['ref' => 'HC.101',  'floor' => '1.OG',  'rooms' => '2.5', 'surface_living' =>  56, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.101_2026.07.14.pdf'],
        ['ref' => 'HC.102',  'floor' => '1.OG',  'rooms' => '2.5', 'surface_living' =>  66, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.102_2026.07.14.pdf'],
        ['ref' => 'HC.103',  'floor' => '1.OG',  'rooms' => '4.5', 'surface_living' => 102, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.103_2026.07.14.pdf'],
        ['ref' => 'HC.201',  'floor' => '2.OG',  'rooms' => '2.5', 'surface_living' =>  56, 'surface_exterior' =>  0, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.201_2026.07.14.pdf'],
        ['ref' => 'HC.202',  'floor' => '2.OG',  'rooms' => '2.5', 'surface_living' =>  66, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.202_2026.07.14.pdf'],
        ['ref' => 'HC.203',  'floor' => '2.OG',  'rooms' => '4.5', 'surface_living' => 102, 'surface_exterior' =>  5, 'state' => 'free', 'plan' => '/downloads/Grundrissplaene_Wohnen/H40_Vermietungsplan_HC.203_2026.07.14.pdf'],
    ],

    // --- Gewerbeflächen (aus Vermietungsplänen 2026.07.09) ---
    // Eigene Struktur: object | geschoss | surface (m²) | plan (PDF)
    'commercial' => [
        [
            'object'  => 'Gewerbe EG',
            'floor'   => 'EG',         // -> Isometrie data-iso-floor
            'part'    => 'gewerbe',    // -> nur die "Gewerbe"-Gruppe der EG-Etage einfärben
            'surface' => 203,
            'state'   => 'free',
            'plan'    => '/downloads/H40_Vermietungsplan_GewerbeEG_2026.07.09.pdf',
        ],
        [
            'object'  => 'Gewerbe 1. UG',
            'floor'   => 'UG',         // 1. Untergeschoss -> Isometrie data-iso-floor="UG"
            'part'    => 'gewerbe',    // -> nur die "Gewerbe"-Gruppe der UG-Etage
            // Die beiden Flaechen im 1. UG (354 m² + 13 m² Lager) sind zusammengefuehrt.
            'surface' => 367,
            'state'   => 'free',
            'plan'    => '/downloads/H40_Vermietungsplan_Gewerbe1UG_2026.07.09.pdf',
        ],
    ],

];
