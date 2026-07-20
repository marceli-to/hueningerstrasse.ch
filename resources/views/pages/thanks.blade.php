@extends('app')
@section('meta_title', 'Vielen Dank')
@section('meta_description', 'Vielen Dank für Ihre Anfrage zur Hüningerstrasse 40 in Basel. Wir melden uns mit weiteren Informationen bei Ihnen.')

@section('content')

  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="max-w-3xl" role="status" aria-live="polite" data-reveal>

        <x-headings.h2 class="mb-24">Vielen Dank, wir haben Ihre Anfrage erhalten</x-headings.h2>

        <p>Sehr geehrte Damen und Herren</p>

        @if (session('inquiry.commercial'))
          <p>
            Danke für Ihr Interesse. Gerne werden wir Sie in den nächsten Tagen bezüglich der freien
            Gewerbeflächen kontaktieren.
          </p>
        @else
          <p>
            Danke für Ihr Interesse. Gerne kontaktieren wir Sie mit weiteren Informationen, sobald der
            offizielle Vermarktungsstart erfolgt.
          </p>
        @endif

        <p>
          Eine Bestätigung Ihrer Anfrage haben wir Ihnen per E-Mail zugestellt. Sollte diese nicht
          innerhalb weniger Minuten eintreffen, prüfen Sie bitte Ihren Spam-Ordner.
        </p>

        <p class="!mb-0">
          Freundliche Grüsse<br>
          Apleona Schweiz AG
        </p>

        <div class="mt-32 flex flex-wrap gap-16">
          <x-buttons.primary href="{{ route('page.project') }}" title="Zur Startseite">Zur Startseite</x-buttons.primary>
          <x-buttons.primary href="{{ route('page.commercial') }}" title="Gewerbeflächen ansehen">Gewerbeflächen</x-buttons.primary>
        </div>

      </div>
    </x-layout.inner>
  </section>

@endsection
