@props([
  'objects' => collect(),
  'title' => '',
])

@php
  $fmt = fn ($v) => rtrim(rtrim(number_format((float) $v, 1, '.', ''), '0'), '.');
@endphp

<div>
  <h3 class="font-bold uppercase tracking-wide text-md md:text-lg text-ink">{{ config('estate.project') }}</h3>
  <p class="text-sm md:text-md text-ink/80 mb-14">{{ $title }}</p>

  <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse min-w-[560px]">
      <thead>
        <tr class="bg-bordeaux text-white text-xs md:text-sm uppercase tracking-wide align-bottom">
          <th class="py-10 px-10 font-bold">Nr.</th>
          <th class="py-10 px-10 font-bold">Etage</th>
          <th class="py-10 px-10 font-bold">Zimmer</th>
          <th class="py-10 px-10 font-bold">Wohnfläche<br>Netto m²</th>
          <th class="py-10 px-10 font-bold">Aussenfläche<br>m²</th>
          <th class="py-10 px-10 font-bold text-right">Grundriss</th>
        </tr>
      </thead>
      <tbody>
        @foreach($objects as $o)
          <tr
            data-filterable
            data-object-state="{{ $o['state'] }}"
            data-object-rooms="{{ $o['rooms'] }}"
            data-object-floor="{{ $o['floor'] }}"
            class="border-b border-ink/15 text-sm md:text-md">
            <td class="py-10 px-10">{{ $o['ref'] }}</td>
            <td class="py-10 px-10">{{ $o['floor_label'] }}</td>
            <td class="py-10 px-10">{{ $o['rooms'] }}</td>
            <td class="py-10 px-10">{{ $fmt($o['surface_living']) }}</td>
            <td class="py-10 px-10">{{ $fmt($o['surface_exterior']) }}</td>
            <td class="py-10 px-10 text-right">
              @if(!empty($o['plan']))
                <a href="{{ $o['plan'] }}" target="_blank" rel="noopener" aria-label="Grundriss {{ $o['ref'] }} herunterladen" class="inline-flex text-bordeaux transition-colors hover:text-ink">
                  <x-icons.arrow-down class="w-16 h-16" />
                </a>
              @else
                <span aria-hidden="true" title="Grundriss folgt" class="inline-flex text-bordeaux/40">
                  <x-icons.arrow-down class="w-16 h-16" />
                </span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
