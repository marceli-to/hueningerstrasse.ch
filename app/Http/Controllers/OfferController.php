<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class OfferController extends Controller
{
    public function commercial()
    {
        return view('pages.commercial', $this->data('commercial'));
    }

    public function living()
    {
        return view('pages.living', $this->data('living'));
    }

    /**
     * Build objects + filter options for the given estate list ('living' | 'commercial').
     */
    private function data(string $key): array
    {
        $floors = config('estate.floors');
        $filters = config('estate.filters');

        $objects = collect(config("estate.$key"))
            ->map(function (array $o) use ($floors) {
                $o['floor_label'] = $floors[$o['floor']]['label'] ?? $o['floor'];
                $o['floor_sort'] = $floors[$o['floor']]['sort'] ?? 99;
                return $o;
            })
            ->sortBy(fn ($o) => [$o['floor_sort'], $o['ref']])
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
