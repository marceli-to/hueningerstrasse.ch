@extends('app')
@section('meta_title', 'Vielen Dank')
@section('meta_description', 'Vielen Dank für Ihre Anfrage zur Hüningerstrasse 40 in Basel. Wir setzen uns zeitnah mit Ihnen in Verbindung.')

@section('content')

  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="max-w-3xl" role="status" aria-live="polite" data-reveal>

        <x-headings.h2 class="mb-24">Wir haben Ihre Anfrage erhalten</x-headings.h2>

        <p>
          Vielen Dank für Ihr Interesse an der Hüningerstrasse 40. Wir setzen uns zeitnah mit Ihnen in
          Verbindung und informieren Sie über das weitere Vorgehen.
        </p>
        <p>
          Eine Bestätigung Ihrer Anfrage haben wir Ihnen per E-Mail zugestellt. Sollte diese nicht
          innerhalb weniger Minuten eintreffen, prüfen Sie bitte Ihren Spam-Ordner.
        </p>

        <div class="mt-32 flex flex-wrap gap-16">
          <x-buttons.primary href="{{ route('page.project') }}" title="Zur Startseite">Zur Startseite</x-buttons.primary>
          <x-buttons.primary href="{{ route('page.commercial') }}" title="Gewerbeflächen ansehen">Gewerbeflächen</x-buttons.primary>
        </div>

      </div>
    </x-layout.inner>
  </section>

@endsection
