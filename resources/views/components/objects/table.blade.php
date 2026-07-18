@props([
  'objects' => collect(),
  'title' => '',
  'variant' => 'living',
])

@php
  $fmt = fn ($v) => rtrim(rtrim(number_format((float) $v, 1, '.', ''), '0'), '.');
@endphp

<div>
  <h3 class="font-bold uppercase tracking-wide text-xl md:text-2xl text-ink">{{ config('estate.project') }}</h3>
  <p class="font-bold text-md md:text-lg text-ink mb-14">{{ $title }}</p>

  <div class="overflow-x-auto">
    @if($variant === 'commercial')
      <table class="text-left border-collapse min-w-[560px]">
        <thead>
          <tr class="bg-bordeaux text-white text-sm md:text-md align-bottom">
            <th class="py-14 pl-16 pr-[50px] font-bold whitespace-nowrap">Objekt</th>
            <th class="py-14 pr-[50px] font-bold whitespace-nowrap">Fläche m²</th>
            <th class="py-14 pr-[50px] font-bold whitespace-nowrap">Lager m²</th>
            <th class="py-14 pl-[50px] pr-16 font-bold text-right whitespace-nowrap">Download</th>
          </tr>
        </thead>
        <tbody>
          @foreach($objects as $o)
            <tr
              data-filterable
              data-object
              data-object-floor="{{ $o['floor'] }}"
              @isset($o['part']) data-object-part="{{ $o['part'] }}" @endisset
              class="border-b border-ink/15 text-sm md:text-md transition-colors hover:bg-ink/5 cursor-default">
              <td class="py-14 pl-16 pr-[50px] whitespace-nowrap">{{ $o['object'] }}</td>
              <td class="py-14 pr-[50px]">{{ $fmt($o['surface']) }}</td>
              <td class="py-14 pr-[50px]">{{ !empty($o['lager']) ? $fmt($o['lager']) : '–' }}</td>
              <td class="py-14 pl-[50px] pr-16 text-right">
                @if(!empty($o['plan']))
                  <a href="{{ $o['plan'] }}" download target="_blank" rel="noopener" aria-label="Vermietungsplan {{ $o['object'] }} herunterladen" class="inline-flex text-bordeaux transition-colors hover:text-ink">
                    <x-icons.arrow-down class="w-16 h-16" />
                  </a>
                @else
                  <span aria-hidden="true" title="Plan folgt" class="inline-flex text-bordeaux/40">
                    <x-icons.arrow-down class="w-16 h-16" />
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
            <th class="py-10 pr-[50px] font-bold">Nr.</th>
            <th class="py-10 pr-[50px] font-bold">Etage</th>
            <th class="py-10 pr-[50px] font-bold">Zimmer</th>
            <th class="py-10 pr-[50px] font-bold">Wohnfläche<br>Netto m²</th>
            <th class="py-10 pr-[50px] font-bold">Aussenfläche<br>m²</th>
            <th class="py-10 font-bold text-right">Grundriss</th>
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
              class="border-b border-ink/15 text-sm md:text-md transition-colors hover:bg-ink/5">
              <td class="py-10 pr-[50px]">{{ $o['ref'] }}</td>
              <td class="py-10 pr-[50px]">{{ $o['floor_label'] }}</td>
              <td class="py-10 pr-[50px]">{{ $o['rooms'] }}</td>
              <td class="py-10 pr-[50px]">{{ $fmt($o['surface_living']) }}</td>
              <td class="py-10 pr-[50px]">{{ $fmt($o['surface_exterior']) }}</td>
              <td class="py-10 text-right">
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
    @endif
  </div>
</div>
