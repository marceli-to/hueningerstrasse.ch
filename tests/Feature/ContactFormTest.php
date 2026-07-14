<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Mail\RegistrationConfirmation;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_validates_required_fields(): void
    {
        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors([
                'apartment_sizes' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'street' => 'required',
                'zip_city' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'message' => 'required',
                'privacy' => 'accepted',
            ])
            ->assertSet('submitted', false);
    }

    public function test_it_stores_registration_and_sends_confirmation(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('apartment_sizes', ['1.5', 'gewerbe'])
            ->set('first_name', 'Erika')
            ->set('last_name', 'Muster')
            ->set('street', 'Teststrasse 1')
            ->set('zip_city', '4056 Basel')
            ->set('email', 'erika@example.com')
            ->set('phone', '061 000 00 00')
            ->set('message', 'Ich interessiere mich für eine Wohnung.')
            ->set('privacy', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('registrations', [
            'first_name' => 'Erika',
            'last_name' => 'Muster',
            'email' => 'erika@example.com',
            'zip_city' => '4056 Basel',
        ]);

        $this->assertSame(['1.5', 'gewerbe'], Registration::first()->apartment_sizes);

        Mail::assertSent(RegistrationConfirmation::class, fn ($mail) => $mail->hasTo('erika@example.com'));
    }
}
