@extends('app')
@section('meta_title', 'Kontakt')
@section('meta_description', 'Interesse an einer Wohnung oder Gewerbefläche an der Hüningerstrasse 40 in Basel? Hinterlegen Sie Ihre Kontaktdaten über unser Kontaktformular.')

@section('content')

  {{-- Intro --}}
  <section class="bg-white">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="grid md:grid-cols-2 gap-x-48 xl:gap-x-64 gap-y-32 max-w-6xl" data-reveal>

        <div>
          <x-headings.h3 class="mb-14">Interesse an einer Gewerbefläche?</x-headings.h3>
          <p class="!mb-0">
            Gerne können Sie <strong>bereits heute</strong> das Kontaktformular ausfüllen. Wir setzen uns
            anschliessend mit Ihnen in Verbindung und informieren Sie über das weitere Vorgehen.
          </p>
        </div>

        <div>
          <x-headings.h3 class="mb-14">Interesse an einer Wohnung?</x-headings.h3>
          <p>
            Der offizielle Vermarktungsstart der Mietwohnungen ist voraussichtlich per <strong>Ende 2026</strong>
            geplant.
          </p>
          <p class="!mb-0">
            Möchten Sie den Vermarktungsstart nicht verpassen? Hinterlegen Sie bereits heute Ihre Kontaktdaten
            über das Kontaktformular und teilen Sie uns Ihre gewünschte Wohnung mit. Gerne informieren wir Sie
            rechtzeitig über den Vermarktungsstart sowie über weitere Neuigkeiten rund um das Projekt.
          </p>
        </div>

      </div>
    </x-layout.inner>
  </section>

  {{-- Kontaktformular --}}
  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <livewire:contact-form />
    </x-layout.inner>
  </section>

@endsection
