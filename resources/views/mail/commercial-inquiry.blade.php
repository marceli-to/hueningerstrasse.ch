<x-mail::message>
# Neue Gewerbeflächen-Anfrage

Über das Kontaktformular ist eine Anfrage eingegangen, in der **Gewerbefläche**
angewählt wurde.

**{{ $registration->fullName() }}**
{{ $registration->street }}
{{ $registration->zip_city }}

E-Mail: [{{ $registration->email }}](mailto:{{ $registration->email }})
@if($registration->phone)
Telefon: {{ $registration->phone }}
@endif

Interesse an:
{{ collect($registration->apartment_sizes)->map(fn ($s) => $s === 'gewerbe' ? 'Gewerbefläche' : $s.'-Zimmerwohnung')->implode(', ') }}

@if($registration->message)
**Nachricht:**

{{ $registration->message }}
@endif

<small>Eingegangen am {{ $registration->created_at->timezone('Europe/Zurich')->format('d.m.Y, H:i') }} Uhr.
Diese Anfrage erscheint zusätzlich in der wöchentlichen Gesamtliste.</small>
</x-mail::message>
