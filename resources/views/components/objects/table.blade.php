@props([
  'objects' => collect(),
  'title' => '',
  'variant' => 'living',
])

@php
  // Flächen werden auf ganze m² aufgerundet.
  $fmt = fn ($v) => (string) (int) ceil((float) $v);
@endphp

<div>
  <x-headings.h3 class="mb-10">{{ config('estate.project') }}</x-headings.h3>
  <p class="font-bold text-[18px] md:text-[20px] text-ink mb-20">{{ $title }}</p>

  <div class="overflow-x-auto">
    @if($variant === 'commercial')
      <table class="text-left border-collapse min-w-[560px]">
        <thead>
          <tr class="bg-bordeaux text-white text-sm md:text-md align-bottom">
            <th class="py-14 pl-8 pr-28 font-normal whitespace-nowrap">Objekt</th>
            <th class="py-14 pr-28 font-normal whitespace-nowrap">Fläche netto m<sup>2</sup></th>
            <th class="py-14 pr-28 font-normal whitespace-nowrap">Lager m²</th>
            <th class="py-14 pr-8 font-normal whitespace-nowrap text-center">Grundriss</th>
          </tr>
        </thead>
        <tbody>
          @foreach($objects as $o)
            <tr
              data-filterable
              data-object
              data-object-floor="{{ $o['floor'] }}"
              @isset($o['part']) data-object-part="{{ $o['part'] }}" @endisset
              class="border-b border-ink/15 text-sm md:text-md font-normal transition-colors hover:bg-ink/5 cursor-default">
              <td class="py-14 pl-8 pr-28 whitespace-nowrap">{{ $o['object'] }}</td>
              <td class="py-14 pr-28">{{ $fmt($o['surface']) }}</td>
              <td class="py-14 pr-28">{{ !empty($o['lager']) ? $fmt($o['lager']) : '–' }}</td>
              <td class="py-14 pr-8 text-center">
                @if(!empty($o['plan']))
                  <a href="{{ $o['plan'] }}" download target="_blank" rel="noopener" aria-label="Vermietungsplan {{ $o['object'] }} herunterladen" class="inline-flex text-bordeaux transition-colors hover:text-ink">
                    <x-icons.download class="w-16 h-16" />
                  </a>
                @else
                  <span aria-hidden="true" title="Plan folgt" class="inline-flex text-bordeaux/40">
                    <x-icons.download class="w-16 h-16" />
                  </span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <table class="text-left border-collapse min-w-[560px]">
        <thead>
          <tr class="bg-bordeaux text-white text-sm md:text-md align-bottom">
            <th class="py-10 pl-8 pr-28 font-normal">Nr.</th>
            <th class="py-10 pr-28 font-normal">Etage</th>
            <th class="py-10 pr-28 font-normal">Zimmer</th>
            <th class="py-10 pr-28 font-normal">Wohnfläche<br>Netto m²</th>
            <th class="py-10 pr-28 font-normal">Aussenfläche<br>m²</th>
            <th class="py-10 pr-8 font-normal text-center">Grundriss</th>
          </tr>
        </thead>
        <tbody>
          @foreach($objects as $o)
            <tr
              data-filterable
              data-object
              data-object-number="{{ $o['ref'] }}"
              data-object-state="{{ $o['state'] }}"
              data-object-rooms="{{ $o['rooms'] }}"
              data-object-floor="{{ $o['floor'] }}"
              class="border-b border-ink/15 text-sm md:text-md font-normal transition-colors hover:bg-ink/5">
              <td class="py-10 pl-8 pr-28">{{ $o['ref'] }}</td>
              <td class="py-10 pr-28">{{ $o['floor_label'] }}</td>
              <td class="py-10 pr-28">{{ $o['rooms'] }}</td>
              <td class="py-10 pr-28">{{ $fmt($o['surface_living']) }}</td>
              <td class="py-10 pr-28">{{ $fmt($o['surface_exterior']) }}</td>
              <td class="py-10 pr-8 text-center">
                @if(!empty($o['plan']))
                  <a href="{{ $o['plan'] }}" target="_blank" rel="noopener" aria-label="Grundriss {{ $o['ref'] }} herunterladen" class="inline-flex text-bordeaux transition-colors hover:text-ink">
                    <x-icons.download class="w-16 h-16" />
                  </a>
                @else
                  <span aria-hidden="true" title="Grundriss folgt" class="inline-flex text-bordeaux/40">
                    <x-icons.download class="w-16 h-16" />
                  </span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
