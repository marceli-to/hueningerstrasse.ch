@extends('app')
@section('meta_description', 'Im Herzen des Volta-Quartiers in Basel entsteht an der Hüningerstrasse 40 nach hochwertigem Umbau ein Wohn- und Gewerbeprojekt mit 32 Mietwohnungen, zwei Wohnateliers und Gewerbeflächen.')

@section('content')

  {{-- Hero --}}
  <x-media.visual image="startbild" alt="Hüningerstrasse 40 – Wohn- und Gewerbeprojekt im Volta-Quartier Basel" />

  {{-- Intro band --}}
  <section class="bg-sky">
    <x-layout.inner class="pt-26 md:pt-36 lg:pt-41 pb-32 md:pb-45 lg:pb-51">
      <div class="max-w-4xl" data-reveal>
        <x-headings.h2 class="mb-24! md:mb-36!">Im Herzen des Volta-Quartiers</x-headings.h2>
        <x-headings.h3>Industriecharme trifft auf modernes Wohnen und Arbeiten</x-headings.h3>
        <p class="max-w-4xl">
          An der <x-links.styled :href="config('estate.maps_url')" target="_blank" rel="noopener noreferrer">Hüningerstrasse 40</x-links.styled>
          in Basel entsteht nach einem hochwertigen Umbau ein attraktives Wohn- und Gewerbeprojekt mit
          insgesamt 32 Mietwohnungen, zwei Wohnateliers sowie Gewerbeflächen.
        </p>
      </div>
    </x-layout.inner>
  </section>

  {{-- Pures Raumgefühl --}}
  <x-sections.hero-split bg="bg-white" align="start">
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
    <div class="mt-56">
      <x-buttons.primary href="{{ route('page.commercial') }}" title="Gewerbeflächen">
        Gewerbeflächen
      </x-buttons.primary>
    </div>

    <x-slot:aside>
      <div class="px-24 lg:px-0" data-reveal>
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
