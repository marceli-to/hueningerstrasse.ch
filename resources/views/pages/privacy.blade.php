@extends('app')
@section('meta_title', 'Datenschutz')
@section('content')

  <section class="bg-white">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="max-w-2xl" data-reveal>
        <x-headings.h1>Datenschutz</x-headings.h1>

        <p>
          Der Schutz Ihrer persönlichen Daten ist uns ein wichtiges Anliegen. Nachfolgend informieren wir Sie
          über die Bearbeitung von Personendaten im Zusammenhang mit dieser Website.
        </p>

        <x-headings.h3 class="mt-24 mb-8">Kontaktformular</x-headings.h3>
        <p>
          Wenn Sie uns über das Kontaktformular eine Anfrage zukommen lassen, werden Ihre Angaben zwecks
          Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben
          wir nicht ohne Ihre Einwilligung weiter.
        </p>

        <p class="text-sm text-ink/70">
          {{-- TODO: vollständige Datenschutzerklärung (Verantwortliche Stelle, Rechtsgrundlagen,
               Aufbewahrung, Rechte der betroffenen Personen, Cookies/Analytics) durch die Bauherrschaft
               bzw. deren Rechtsberatung ergänzen. --}}
          Diese Datenschutzerklärung wird vor dem Livegang vervollständigt.
        </p>
      </div>
    </x-layout.inner>
  </section>

@endsection
