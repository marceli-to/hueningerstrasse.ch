<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class OfferController extends Controller
{
    public function commercial()
    {
        // Gewerbe: feste, kleine Objektliste ohne Filter (eigene Tabellenstruktur).
        return view('pages.commercial', [
            'objects' => collect(config('estate.commercial')),
        ]);
    }

    public function living()
    {
        return view('pages.living', $this->data('living'));
    }

    /**
     * Build objects + filter options for the given estate list ('living').
     */
    private function data(string $key): array
    {
        $floors = config('estate.floors');
        $filters = config('estate.filters');

        // Reihenfolge kommt 1:1 aus config/estate.php und entspricht dem
        // Mieterspiegel (nach Haus: V, HA, HB, HC, darin nach Geschoss/Objekt).
        // Deshalb hier bewusst kein sortBy – sonst landet die Tabelle wieder in
        // alphabetischer Ref-Reihenfolge.
        $objects = collect(config("estate.$key"))
            ->map(function (array $o) use ($floors) {
                $o['floor_label'] = $floors[$o['floor']]['label'] ?? $o['floor'];
                return $o;
            })
            ->values();

        $rooms = $objects->pluck('rooms')->filter()->unique()->sort()->values();

        $usedFloors = $objects->pluck('floor')->unique()
            ->sortBy(fn ($f) => $floors[$f]['sort'] ?? 99)->values();

        $filterOptions = [
            'availability' => $filters['availability'],
            'rooms' => collect(['NULL' => $filters['rooms']['default']])
                ->merge($rooms->mapWithKeys(fn ($r) => [$r => $r . '-Zimmer'])),
            'floors' => collect(['NULL' => $filters['floors']['default']])
                ->merge($usedFloors->mapWithKeys(fn ($f) => [$f => $floors[$f]['label'] ?? $f])),
        ];

        return [
            'objects' => $objects,
            'filterOptions' => $filterOptions,
        ];
    }
}
