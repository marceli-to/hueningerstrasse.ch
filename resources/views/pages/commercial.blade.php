@extends('app')
@section('meta_title', 'Gewerbe')
@section('meta_description', 'Moderne Gewerbeflächen mit Industriecharme an der Hüningerstrasse 40 in Basel – rund 203 m² im EG und 353 m² im UG, Fertigstellung per Februar 2027.')

@section('content')

  {{-- Intro split --}}
  <section class="bg-white">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="grid lg:grid-cols-2 gap-x-48 xl:gap-x-64 gap-y-32 items-start">

        <div data-reveal>
          <x-headings.h1>Moderne Gewerbeflächen mit Industriecharme</x-headings.h1>
          <p>
            Mitten im dynamischen Volta-Quartier entstehen zwei moderne Gewerbeflächen mit unverwechselbarem
            Industrie- und Ateliercharakter. Die Fertigstellung der Gewerbeflächen ist <strong>per Februar 2027</strong>
            vorgesehen.
          </p>
          <p>
            Die markante Architektur, hohe Decken und grosszügigen Schaufenster schaffen ideale Voraussetzungen
            für kreative Arbeitswelten, innovative Dienstleister, Architekturbüros, Design- und Kreativagenturen,
            Showrooms, Ateliers oder andere moderne Gewerbekonzepte. Die Flächen richten sich insbesondere an
            Unternehmen, die Wert auf Sichtbarkeit, Flexibilität und ein inspirierendes Arbeitsumfeld legen.
          </p>
          <p>
            Die Flächen umfassen rund 203 m² im Erdgeschoss sowie 353 m² im 1. Untergeschoss und können einzeln
            oder als zusammenhängende Gesamtfläche gemietet werden. Eine optionale interne Treppe verbindet die
            beiden Ebenen und schafft zusätzliche Flexibilität für unterschiedlichste Nutzungskonzepte. Das
            Untergeschoss eignet sich zudem ideal als Lager- oder Nebenfläche und ergänzt die Nutzung im
            Erdgeschoss optimal.
          </p>
          <p>
            Die Gewerbeflächen werden im Edelrohbau übergeben und bieten Ihnen die Möglichkeit, den Innenausbau
            ganz nach Ihren individuellen Bedürfnissen zu gestalten. Raumhöhen von rund 3.70 m im Erdgeschoss und
            2.70 m im Untergeschoss sowie grosszügige Schaufensterfronten schaffen ein offenes, helles und
            repräsentatives Ambiente.
          </p>

          {{-- Mögliche Nutzungen --}}
          <div class="mt-32">
            <x-headings.h3 class="mb-16">Mögliche Nutzungen</x-headings.h3>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-40 gap-y-12 !pl-0 !mb-0">
              @php
                $usages = [
                  ['gewerbe-buero', 'Büro'],
                  ['gewerbe-verkauf', 'Verkaufsfläche'],
                  ['gewerbe-praxis', 'Praxis'],
                  ['gewerbe-cafe', 'Café'],
                  ['gewerbe-showroom', 'Showroom'],
                  ['gewerbe-dienstleistung', 'Dienstleistungsbetrieb'],
                  ['gewerbe-atelier', 'Atelier'],
                ];
              @endphp
              @foreach($usages as [$icon, $label])
                <li class="flex items-center gap-14 !mb-0 !list-none">
                  <x-dynamic-component :component="'icons.' . $icon" class="w-22 h-22 text-ink shrink-0" />
                  <span class="font-bold">{{ $label }}</span>
                </li>
              @endforeach
            </ul>
          </div>

          <div class="mt-32">
            <x-buttons.primary href="{{ route('page.contact') }}" title="Jetzt anfragen">
              Jetzt anfragen
              <x-icons.arrow-right class="w-16 h-auto shrink-0 group-hover:translate-x-3 transition-transform" />
            </x-buttons.primary>
          </div>
        </div>

        <div class="lg:sticky lg:top-120 lg:h-[520px]" data-reveal>
          <x-gallery.carousel name="gallery" alt="Gewerbeflächen an der Hüningerstrasse 40" :images="[
            '/img/gewerbe-buero-02',
            '/img/gewerbe-buero-01',
            '/img/gewerbe-cafe',
            '/img/gewerbe-praxis',
            '/img/gewerbe-veloladen',
          ]" />
        </div>

      </div>
    </x-layout.inner>
  </section>

  {{-- Angebot Gewerbe --}}
  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div data-reveal>
        <x-headings.h2>Angebot Gewerbe</x-headings.h2>
        <x-objects.filter :options="$filterOptions" />
        <x-objects.wrapper :objects="$objects" title="Gewerbeflächen" />
      </div>
    </x-layout.inner>
  </section>

@endsection
