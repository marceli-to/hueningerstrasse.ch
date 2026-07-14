<x-mail::message>
# Neue Anfragen – Hüningerstrasse 40

Zeitraum: **{{ $period }}**

@if($registrations->isEmpty())
Im gewählten Zeitraum sind keine neuen Anfragen eingegangen.
@else
Es sind **{{ $registrations->count() }}** neue Anfrage(n) eingegangen. Die vollständige Liste
finden Sie in der beigefügten CSV-Datei.

@foreach($registrations as $r)
- **{{ $r->fullName() }}** — {{ $r->email }}{{ $r->phone ? ', '.$r->phone : '' }}
  ({{ collect($r->apartment_sizes)->map(fn ($s) => $s === 'gewerbe' ? 'Gewerbefläche' : $s.'-Zi.')->implode(', ') }})
@endforeach
@endif

Freundliche Grüsse<br>
{{ config('app.name') }}
</x-mail::message>
