<?php

namespace App\Livewire;

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
    public bool $submitted = false;

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

    public function submit(): void
    {
        $this->validate();

        if (! $this->verifyTurnstile()) {
            $this->addError('turnstileToken', 'Die Spam-Prüfung ist fehlgeschlagen. Bitte versuchen Sie es erneut.');
            $this->dispatch('turnstile:reset');

            return;
        }

        Registration::create([
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

        $this->reset([
            'apartment_sizes', 'first_name', 'last_name', 'street',
            'zip_city', 'email', 'phone', 'message', 'privacy', 'turnstileToken',
        ]);

        $this->submitted = true;
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
