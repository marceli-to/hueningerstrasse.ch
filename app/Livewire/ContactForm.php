<?php

namespace App\Livewire;

use App\Mail\CommercialInquiry;
use App\Mail\RegistrationConfirmation;
use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    /** @var array<int,string> */
    public array $apartment_sizes = [];

    public string $first_name = '';
    public string $last_name = '';
    public string $street = '';
    public string $zip_city = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';
    public bool $privacy = false;

    public string $turnstileToken = '';

    /** Options offered, as value => label, in display order (column-major, per design). */
    public array $sizes = [
        '1.5' => '1.5-Zimmerwohnung',
        '2.5' => '2.5-Zimmerwohnung',
        '3.5' => '3.5-Zimmerwohnung',
        '4.5' => '4.5-Zimmerwohnung',
        '5.5' => '5.5-Zimmerwohnung',
        'gewerbe' => 'Gewerbefläche',
    ];

    /** @return array<string,mixed> */
    protected function rules(): array
    {
        return [
            'apartment_sizes' => ['required', 'array', 'min:1'],
            'apartment_sizes.*' => ['string', 'in:'.implode(',', array_keys($this->sizes))],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'zip_city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'privacy' => ['accepted'],
        ];
    }

    /** @return array<string,string> */
    protected function messages(): array
    {
        return [
            'apartment_sizes.required' => 'Bitte wählen Sie mindestens eine Option aus.',
            'apartment_sizes.min' => 'Bitte wählen Sie mindestens eine Option aus.',
            'first_name.required' => 'Bitte geben Sie Ihren Vornamen ein.',
            'last_name.required' => 'Bitte geben Sie Ihren Namen ein.',
            'street.required' => 'Bitte geben Sie Ihre Strasse und Nr. ein.',
            'zip_city.required' => 'Bitte geben Sie PLZ und Ort ein.',
            'email.required' => 'Bitte geben Sie Ihre E-Mail-Adresse ein.',
            'email.email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
            'phone.required' => 'Bitte geben Sie Ihre Telefonnummer ein.',
            'message.required' => 'Bitte geben Sie eine Nachricht ein.',
            'privacy.accepted' => 'Bitte akzeptieren Sie die Datenschutzerklärung.',
            'max' => 'Die Eingabe ist zu lang.',
        ];
    }

    /** Inline-Validierung: prüft das einzelne Feld, sobald es geändert/verlassen wird. */
    public function updated(string $property): void
    {
        $this->validateOnly($property);
    }

    public function submit(): void
    {
        $this->validate();

        if (! $this->verifyTurnstile()) {
            $this->addError('turnstileToken', 'Die Spam-Prüfung ist fehlgeschlagen. Bitte versuchen Sie es erneut.');
            $this->dispatch('turnstile:reset');

            return;
        }

        $registration = Registration::create([
            'apartment_sizes' => array_values($this->apartment_sizes),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'street' => $this->street,
            'zip_city' => $this->zip_city,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'message' => $this->message ?: null,
        ]);

        Mail::to($this->email)->send(new RegistrationConfirmation);

        $this->notifyCommercial($registration);

        $this->reset([
            'apartment_sizes', 'first_name', 'last_name', 'street',
            'zip_city', 'email', 'phone', 'message', 'privacy', 'turnstileToken',
        ]);

        // Die Danke-Seite formuliert je nach Interesse unterschiedlich (wie auf Live).
        session()->flash('inquiry.commercial', in_array('gewerbe', $registration->apartment_sizes ?? [], true));

        // Eigene Antwortseite statt Inline-Meldung: hat eine eigene URL, ist damit
        // als Conversion messbar und ein Reload sendet das Formular nicht erneut.
        $this->redirectRoute('page.thanks', navigate: true);
    }

    /**
     * Sofort-Benachrichtigung an die Vermarktung, wenn "Gewerbefläche" angewählt wurde.
     *
     * Scheitert der Versand, wird nur geloggt: Die Anfrage ist bereits gespeichert und
     * erscheint ohnehin in der Wochenliste — der Absender soll deswegen keinen Fehler sehen.
     */
    private function notifyCommercial(Registration $registration): void
    {
        if (! in_array('gewerbe', $registration->apartment_sizes ?? [], true)) {
            return;
        }

        $recipient = config('services.registrations.commercial_email');

        if (blank($recipient)) {
            return;
        }

        try {
            Mail::to(array_map('trim', explode(',', $recipient)))
                ->send(new CommercialInquiry($registration));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function verifyTurnstile(): bool
    {
        $secret = config('services.turnstile.secret_key');

        // No secret configured (e.g. local dev before keys arrive) → skip the check.
        if (blank($secret)) {
            return true;
        }

        if (blank($this->turnstileToken)) {
            return false;
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secret,
            'response' => $this->turnstileToken,
            'remoteip' => request()->ip(),
        ]);

        return $response->json('success') === true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
