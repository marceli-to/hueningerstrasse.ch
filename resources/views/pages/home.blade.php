@extends('app')
@section('content')
<x-layout.section class="bg-white !p-0">
  <x-swiper>
    <x-swiper.slide :image="'hueningerstrasse-40-visualisierung-1'" :alt="''" />
    <x-swiper.slide :image="'hueningerstrasse-40-visualisierung-2'" :alt="''" />
  </x-swiper>
</x-layout.section>

<x-layout.section class="bg-forest text-white">
  <x-layout.inner>
    <div class="max-w-2xl">
      <h1 class="text-white">Wohnen in Basel</h1>
      <h2 class="text-white">Wiedervermietung nach Sanierung</h2>
      <p>An der <a href="https://maps.app.goo.gl/UTYMjqVEVAry8BaU9" target="_blank" title="Auf Googlemaps anzeigen" class="underline hover:no-underline underline-offset-4 decoration-1">Hüningerstrasse 40</a> in 4056 Basel entstehen nach umfassender Sanierung per Herbst 2025 moderne 1.5- bis 5.5-Zimmerwohnungen mit industriellen Charakter sowie Gewerbeflächen. Die Liegenschaft befindet sich in unmittelbarer Nähe zum Bahnhof Basel St. Johann.</p>
      <p><strong>Interessiert?</strong><br>Gerne senden wir Ihnen weitere Informationen, sobald die Vermietung startet. Bitte füllen Sie dazu das Kontaktformular aus.</p>
    </div>
  </x-layout.inner>
</x-layout.section>

<x-layout.section class="bg-silver">
  <x-layout.inner>
    <h1>Kontaktformular</h1>
    @livewire('create-inquiry')
  </x-layout.inner>
</x-layout.section>

@endsection