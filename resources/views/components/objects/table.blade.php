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
  {{-- Ohne title-Prop entfaellt der komplette Kopf (Projektname + Untertitel)
       und die Tabelle folgt direkt auf die Sektionsueberschrift. --}}
  @if($title !== '')
    <x-headings.h3 class="mb-10">{{ config('estate.project') }}</x-headings.h3>
    <p class="font-bold text-[18px] md:text-[20px] text-ink mb-20">{{ $title }}</p>
  @endif

  {{-- contain-paint zusaetzlich zum Scrollen: overflow-x-auto laesst die Tabelle
       zwar korrekt im Container scrollen und klippt sie auch, trotzdem schlaegt
       ihre volle Breite bis hinauf zu <html> in scrollWidth durch (bei 375px
       Viewport 424 statt 375). Sichtbar verschoben ist dabei nichts und die
       Seite laesst sich in Chrome auch nicht seitlich scrollen, andere Browser
       leiten daraus aber eine zu breite Seite ab. contain:paint kappt diese
       Weitergabe – overflow:hidden auf dem Scroller genuegt dafuer nicht. --}}
  <div class="overflow-x-auto contain-paint">
    @if($variant === 'commercial')
      {{-- Drei Spalten passen auch auf schmale Viewports, daher keine Mindestbreite. --}}
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-bordeaux text-white text-sm md:text-md align-bottom">
            {{-- w-full auf der Flaechenspalte: sie nimmt den Rest, Grundriss schrumpft auf
                 seinen Inhalt. So bleibt die Tabelle immer genau 100% breit. Objekt bekommt
                 40%, damit die Flaeche weiter rechts steht (auf schmalen Viewports faellt
                 die Prozentbreite automatisch auf die Inhaltsbreite zurueck). --}}
            <th class="w-2/5 py-14 pl-8 pr-28 font-normal whitespace-nowrap">Objekt</th>
            <th class="w-full py-14 pr-28 font-normal whitespace-nowrap">Fläche netto m<sup>2</sup></th>
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
      <table class="min-w-full text-left border-collapse">
        <thead>
          {{-- whitespace-nowrap haelt die Titel zusammen, die Spalten wachsen auf
               ihre Inhaltsbreite; unter den Inhalt kann die Tabelle also nie
               schrumpfen. min-w-full sorgt fuer die Gegenrichtung: bleibt Platz
               uebrig, fuellt sie ihn aus statt links zu kleben. Reicht der Platz
               nicht, scrollt der Wrapper horizontal. --}}
          <tr class="bg-bordeaux text-white text-xs md:text-md align-top">
            <th class="py-10 pl-8 pr-10 md:pr-20 font-normal whitespace-nowrap">Nr.</th>
            <th class="py-10 pr-10 md:pr-20 font-normal whitespace-nowrap">Etage</th>
            {{-- Unter md gekürzt, damit die Tabelle auf dem Telefon schmaler wird. --}}
            <th class="py-10 pr-10 md:pr-20 font-normal whitespace-nowrap">
              <span class="md:hidden">Zi.</span><span class="hidden md:inline">Zimmer</span>
            </th>
            {{-- Einheit unter md auf eine zweite Zeile, das spart Spaltenbreite.
                 <br> bricht auch bei whitespace-nowrap. --}}
            <th class="py-10 pr-10 md:pr-20 font-normal whitespace-nowrap">
              <span class="md:hidden">Fl. netto<br>m²</span><span class="hidden md:inline">Fläche netto m²</span>
            </th>
            <th class="py-10 pr-10 md:pr-20 font-normal whitespace-nowrap">
              <span class="md:hidden">Aussen<br>m²</span><span class="hidden md:inline">Aussen m²</span>
            </th>
            {{-- Unter md auf zwei Zeilen getrennt, wie die beiden Flaechenspalten
                 daneben: "Grundriss" war der breiteste Inhalt dieser Spalte und
                 bestimmte damit ihre Breite, obwohl darunter nur ein Icon steht. --}}
            <th class="py-10 pr-10 md:pr-20 font-normal text-center whitespace-nowrap">
              <span class="md:hidden">Grund-<br>riss</span><span class="hidden md:inline">Grundriss</span>
            </th>
            {{-- Letzte Spalte ohne Innenabstand und rechtsbuendig: sie ist durch
                 min-w-full breiter als ihr Inhalt, sonst bliebe rechts Luft.
                 Der Titel entfaellt optisch, bleibt fuer Screenreader aber
                 stehen – eine leere Kopfzelle waere sonst nicht zuzuordnen. --}}
            <th class="py-10 font-normal whitespace-nowrap text-right">
              <span class="sr-only">Vormerken</span>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($objects as $o)
            <tr
              data-filterable
              data-object
              data-object-number="{{ $o['ref'] }}"
              {{-- Die Nummer ist zugleich der Name der Flaeche im Illustrator-SVG
                   (V.1 -> <g id="V1" data-iso-part="V.1">), daher faerbt iso.js
                   beim Hover genau diese Wohnung ein statt der ganzen Etage. --}}
              data-object-part="{{ $o['part'] ?? $o['ref'] }}"
              data-object-state="{{ $o['state'] }}"
              data-object-rooms="{{ $o['rooms'] }}"
              data-object-floor="{{ $o['floor'] }}"
              class="border-b border-ink/15 text-xs md:text-md font-normal transition-colors hover:bg-ink/5">
              <td class="py-10 pl-8 pr-10 md:pr-20">{{ $o['ref'] }}</td>
              <td class="py-10 pr-10 md:pr-20">{{ $o['floor_label'] }}</td>
              <td class="py-10 pr-10 md:pr-20">{{ $o['rooms'] }}</td>
              <td class="py-10 pr-10 md:pr-20">{{ $fmt($o['surface_living']) }}</td>
              {{-- Wohnungen ohne Aussenflaeche: Zelle bleibt leer statt "0". --}}
              <td class="py-10 pr-10 md:pr-20">{{ (float) $o['surface_exterior'] > 0 ? $fmt($o['surface_exterior']) : '' }}</td>
              <td class="py-10 pr-10 md:pr-20 text-center">
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
              <td class="py-6 text-right">
                {{-- Gleicher Button wie sonst im Projekt, nur auf Tabellenmass
                     heruntergesetzt (der Standard ist auf 23px Text ausgelegt). --}}
                <x-buttons.primary
                  href="{{ route('page.contact') }}"
                  title="Wohnung {{ $o['ref'] }} vormerken"
                  class="text-[12px]! md:text-[13px]! font-normal! md:font-bold! pt-6! pb-7! px-10! whitespace-nowrap">
                  Vormerken
                </x-buttons.primary>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
