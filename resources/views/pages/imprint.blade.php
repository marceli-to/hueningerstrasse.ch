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
              Kornhausgasse 7<br>
              4051 Basel<br>
              <a href="mailto:mieten@apleona.com" class="text-bordeaux hover:text-ink transition-colors">mieten@apleona.com</a>
            </p>
          </div>

          <div>
            <x-headings.h3 class="mb-6">Konzept &amp; Gestaltung</x-headings.h3>
            <p class="!mb-0">
              <a href="https://stoz.ch" target="_blank" rel="noopener noreferrer" class="text-bordeaux hover:text-ink transition-colors">stoz</a>
            </p>
          </div>

          <p class="text-sm text-ink/70 !mb-0">
            {{-- TODO: definitive Impressumsangaben (Rechtsträger, Haftung, Bildnachweise) ergänzen. --}}
            Angaben ohne Gewähr. Alle Visualisierungen sind unverbindlich.
          </p>
        </div>
      </div>
    </x-layout.inner>
  </section>

@endsection
