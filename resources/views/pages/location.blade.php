@extends('app')
@section('meta_title', 'Lage')
@section('meta_description', 'Die Hüningerstrasse 40 liegt im Basler Quartier St. Johann, direkt beim Voltaplatz – bestens erschlossen und mitten im lebendigen Volta-Quartier.')

@section('content')

  <x-sections.hero-split bg="bg-white" align="start">
    <x-headings.h1>Lage</x-headings.h1>
    <p>
      Die <x-links.styled :href="config('estate.maps_url')" target="_blank" rel="noopener noreferrer">Hüningerstrasse 40</x-links.styled>
      befindet sich im beliebten Basler Quartier St. Johann, direkt beim Voltaplatz. Das Quartier
      überzeugt mit einer ausgezeichneten Infrastruktur und vereint Wohnen, Arbeiten und Freizeit auf
      ideale Weise.
    </p>
    <p>
      Einkaufsmöglichkeiten, Restaurants, Cafés sowie zahlreiche Dienstleistungsangebote befinden sich
      in unmittelbarer Nähe und sind bequem zu Fuss erreichbar. Die nahegelegenen Grünanlagen sowie die
      Rheinufer laden auch zu erholsamen Spaziergängen und sportlichen Aktivitäten ein.
    </p>
    <p>
      Dank der optimalen Anbindung an den öffentlichen Verkehr erreichen Sie die Basler Innenstadt sowie
      den Bahnhof Basel SBB in wenigen Minuten. Auch der Autobahnanschluss ist schnell erreichbar und
      sorgt für eine hervorragende Erschliessung der umliegenden Regionen.
    </p>
    <p>
      Die Nähe zum Novartis Campus sowie die lebendige Quartierstruktur machen die Liegenschaft zu einem
      attraktiven Standort für modernes Wohnen und vielseitige Gewerbenutzungen.
    </p>

    <div class="mt-28">
      <p class="font-bold uppercase tracking-wide text-bordeaux text-md mb-2">Adresse</p>
      <p>
        <x-links.styled :href="config('estate.maps_url')" target="_blank" rel="noopener noreferrer" class="text-ink transition-colors hover:text-bordeaux">
          Hüningerstrasse 40, 4056 Basel
        </x-links.styled>
      </p>
    </div>

    <x-slot:aside>
      <div class="px-24 lg:px-0 lg:pt-8" data-reveal>
        <picture class="block w-full">
          <source srcset="/img/landschaft.webp" type="image/webp">
          <img src="/img/landschaft.jpg" alt="Basel – Altstadt und Rheinufer" class="w-full aspect-[4/3] object-cover" />
        </picture>
      </div>
    </x-slot:aside>
  </x-sections.hero-split>

  <x-map />

@endsection
