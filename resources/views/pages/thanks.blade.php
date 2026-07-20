@extends('app')
@section('meta_title', 'Vielen Dank')
@section('meta_description', 'Vielen Dank für Ihre Anfrage zur Hüningerstrasse 40 in Basel. Wir melden uns mit weiteren Informationen bei Ihnen.')

@section('content')

  <section class="bg-sky">
    <x-layout.inner class="py-40 md:py-56 lg:py-64">
      <div class="max-w-3xl" role="status" aria-live="polite" data-reveal>

        <x-headings.h2 class="mb-24">Vielen Dank, wir haben Ihre Anfrage erhalten</x-headings.h2>

        @if (session('inquiry.commercial'))
          <p>
            Die Gewerbeflächen sind bereits in Vermarktung. Wir melden uns in den nächsten Tagen mit
            weiteren Informationen bei Ihnen.
          </p>
        @else
          <p>
            Der offizielle Vermarktungsstart der Mietwohnungen erfolgt zu einem späteren Zeitpunkt.
            Wir informieren Sie rechtzeitig darüber sowie über weitere Neuigkeiten zum Projekt.
          </p>
        @endif

        <p class="!mb-0">
          Eine Bestätigung Ihrer Anfrage haben wir Ihnen per E-Mail zugestellt.
        </p>

      </div>
    </x-layout.inner>
  </section>

@endsection
