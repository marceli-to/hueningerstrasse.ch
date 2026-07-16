@extends('app')
@section('meta_description', 'Im Herzen des Volta-Quartiers in Basel entsteht an der Hüningerstrasse 40 nach hochwertigem Umbau ein Wohn- und Gewerbeprojekt mit 32 Mietwohnungen, zwei Wohnateliers und Gewerbeflächen.')

@section('content')

  {{-- Hero --}}
  <x-media.visual image="startbild" alt="Hüningerstrasse 40 – Wohn- und Gewerbeprojekt im Volta-Quartier Basel" />

  {{-- Intro band --}}
  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="max-w-3xl" data-reveal>
        <x-headings.h2>Im Herzen des<br>Volta-Quartiers</x-headings.h2>
        <p class="font-bold uppercase tracking-wide text-md md:text-lg mb-16 md:mb-20">
          Industriecharme trifft auf modernes Wohnen und Arbeiten
        </p>
        <p class="max-w-2xl">
          An der <x-links.styled :href="config('estate.maps_url')" target="_blank" rel="noopener noreferrer">Hüningerstrasse 40</x-links.styled>
          in Basel entsteht nach einem hochwertigen Umbau ein attraktives Wohn- und Gewerbeprojekt mit
          insgesamt 32 Mietwohnungen, zwei Wohnateliers sowie Gewerbeflächen.
        </p>
      </div>
    </x-layout.inner>
  </section>

  {{-- Pures Raumgefühl --}}
  <x-sections.hero-split bg="bg-white" align="center">
    <x-headings.h2>Pures Raumgefühl</x-headings.h2>
    <p>
      Das Projekt vereint den charaktervollen Bestand mit einem modernen Wohn- und Nutzungskonzept.
      Grosszügige Raumhöhen, weitläufige Fensterfronten und viel Tageslicht verleihen den Wohnungen
      und Gewerbeflächen einen unverwechselbaren Loft- und Ateliercharakter und schaffen ein
      aussergewöhnliches Raumgefühl.
    </p>
    <p>
      Das umfassend umgebaute Wohn- und Geschäftshaus wird im Minergie-P-Standard realisiert und
      erfüllt hohe Anforderungen an Nachhaltigkeit und Energieeffizienz. Ergänzt wird das Angebot
      durch grosszügige Veloparkierungsflächen sowie E-Bike- und Cargobike-Stellplätze.
    </p>
    <div class="mt-28">
      <x-buttons.primary href="{{ route('page.commercial') }}" title="Gewerbeflächen">
        Gewerbeflächen
        <x-icons.arrow-right class="w-16 h-auto shrink-0 group-hover:translate-x-3 transition-transform" />
      </x-buttons.primary>
    </div>

    <x-slot:aside>
      <div class="px-24 lg:px-0 lg:h-[520px]" data-reveal>
        <x-gallery.carousel name="gallery" alt="Gewerbe- und Wohnräume an der Hüningerstrasse 40" :images="[
          '/img/gewerbe-buero-01',
          '/img/gebaeude-02',
          '/img/gewerbe-cafe',
        ]" />
      </div>
    </x-slot:aside>
  </x-sections.hero-split>

  {{-- Map --}}
  <x-map />

@endsection
