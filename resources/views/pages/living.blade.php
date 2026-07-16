@extends('app')
@section('meta_title', 'Wohnungen')
@section('meta_description', 'Aussergewöhnliche 1.5- bis 5.5-Zimmer-Mietwohnungen mit Loft- und Ateliercharakter an der Hüningerstrasse 40 in Basel – Fertigstellung voraussichtlich Sommer 2027.')

@section('content')

  {{-- Intro split --}}
  <x-sections.hero-split bg="bg-white" align="start">
    <x-headings.h1>Aussergewöhnliche Mietwohnungen mit Industriearchitektur</x-headings.h1>
    <p>
      An der Hüningerstrasse 40 entstehen im Zuge eines umfassenden Umbaus 32 charaktervolle
      Mietwohnungen – von 1.5- bis 5.5-Zimmerwohnungen sowie zwei Wohnateliers. Das Projekt verbindet
      modernes Wohnen mit einem unverwechselbaren Loft- und Ateliercharakter und schafft ein Zuhause mit
      besonderem Flair. Die Fertigstellung der Wohnungen ist <strong>voraussichtlich für Sommer 2027</strong>
      vorgesehen.
    </p>
    <p>
      Die Wohnungen überzeugen mit grosszügigen Raumhöhen, viel Tageslicht und einem modernen
      Ausbaustandard. Durchdachte Grundrisse und der unverwechselbare Loft- und Ateliercharakter schaffen
      ein besonderes Wohngefühl. Dank der vielfältigen Wohnungsgrössen eignen sich die Wohnungen für
      unterschiedliche Lebensentwürfe – vom urbanen Singlehaushalt über Paare bis hin zu Familien.
    </p>
    <p>
      Ein Grossteil der Wohnungen verfügt über eine private Loggia. Der begrünte Innenhof sowie die
      gemeinschaftliche Dachterrasse mit Blick ins Grüne schaffen zusätzliche Aufenthaltsbereiche und laden
      zum Verweilen und Begegnen ein.
    </p>
    <p>
      Im 1. Untergeschoss befinden sich grosszügige Veloparkierungsflächen. Zusätzlich können E-Bike- und
      Cargobike-Stellplätze gemietet werden.
    </p>

    <x-slot:aside>
      <div class="px-24 lg:px-0 lg:sticky lg:top-120 lg:h-[520px]" data-reveal>
        <x-gallery.carousel name="gallery" alt="Mietwohnungen an der Hüningerstrasse 40" :images="[
          '/img/wohnung',
          '/img/gebaeude-02',
          '/img/gebaeude-01',
        ]" />
      </div>
    </x-slot:aside>
  </x-sections.hero-split>

  {{-- Angebot Wohnen --}}
  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div data-reveal>
        <x-headings.h2>Angebot Wohnen</x-headings.h2>
        <x-objects.filter :options="$filterOptions" />
        <x-objects.wrapper :objects="$objects" title="Mietwohnungen" />
      </div>
    </x-layout.inner>
  </section>

@endsection
