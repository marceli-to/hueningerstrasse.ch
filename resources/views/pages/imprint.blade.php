@extends('app')
@section('meta_title', 'Impressum')
@section('content')

  <section class="bg-white">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="max-w-2xl" data-reveal>
        <x-headings.h1>Impressum</x-headings.h1>

        <div class="space-y-24">
          <div>
            <x-headings.h3 class="mb-6">Vermarktung</x-headings.h3>
            <p class="!mb-0">
              Apleona Schweiz AG<br>
              Industriestrasse 21<br>
              8304 Wallisellen<br>
              <a href="mailto:mieten@apleona.com" class="text-bordeaux hover:text-ink transition-colors">mieten@apleona.com</a>
            </p>
          </div>

          <div>
            <x-headings.h3 class="mb-6">Konzept &amp; Gestaltung</x-headings.h3>
            <p class="!mb-0">
              Stoz Werbeagentur AG<br>
              Barzloostrasse 2<br>
              8330 Pfäffikon ZH<br>
              <a href="mailto:hello@stoz.ch" class="text-bordeaux hover:text-ink transition-colors">hello@stoz.ch</a><br>
              <a href="https://www.stoz.ch" target="_blank" rel="noopener noreferrer" class="text-bordeaux hover:text-ink transition-colors">www.stoz.ch</a>
            </p>
          </div>

          <div>
            <x-headings.h3 class="mb-6">Programmierung</x-headings.h3>
            <p class="!mb-0">
              Marcel Stadelmann, Zürich<br>
              <a href="https://marceli.to" target="_blank" rel="noopener noreferrer" class="text-bordeaux hover:text-ink transition-colors">marceli.to</a>
            </p>
          </div>
        </div>
      </div>
    </x-layout.inner>
  </section>

@endsection
