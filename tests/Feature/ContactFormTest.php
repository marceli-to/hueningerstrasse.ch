<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Mail\CommercialInquiry;
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
            ->assertNoRedirect();
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
            ->assertRedirect(route('page.thanks'));

        $this->assertDatabaseHas('registrations', [
            'first_name' => 'Erika',
            'last_name' => 'Muster',
            'email' => 'erika@example.com',
            'zip_city' => '4056 Basel',
        ]);

        $this->assertSame(['1.5', 'gewerbe'], Registration::first()->apartment_sizes);

        Mail::assertSent(RegistrationConfirmation::class, fn ($mail) => $mail->hasTo('erika@example.com'));
    }

    public function test_it_notifies_the_agency_when_commercial_space_is_selected(): void
    {
        Mail::fake();
        config(['services.registrations.commercial_email' => 'alessia.lavacca@apleona.com']);

        $this->submitForm(['3.5', 'gewerbe']);

        Mail::assertSent(CommercialInquiry::class, function ($mail) {
            return $mail->hasTo('alessia.lavacca@apleona.com')
                && $mail->registration->email === 'erika@example.com';
        });
    }

    public function test_it_does_not_notify_the_agency_without_commercial_space(): void
    {
        Mail::fake();
        config(['services.registrations.commercial_email' => 'alessia.lavacca@apleona.com']);

        $this->submitForm(['3.5']);

        Mail::assertNotSent(CommercialInquiry::class);
    }

    public function test_it_skips_the_commercial_notification_without_a_recipient(): void
    {
        Mail::fake();
        config(['services.registrations.commercial_email' => null]);

        $this->submitForm(['gewerbe']);

        Mail::assertNotSent(CommercialInquiry::class);
        $this->assertDatabaseCount('registrations', 1);
    }


    public function test_the_thanks_page_is_reachable(): void
    {
        $this->get(route('page.thanks'))
            ->assertOk()
            ->assertSee('Vielen Dank, wir haben Ihre Anfrage erhalten');
    }


    public function test_the_thanks_page_wording_depends_on_the_interest(): void
    {
        Mail::fake();

        // Mit Gewerbefläche -> Gewerbe-Formulierung
        $this->submitForm(['gewerbe']);
        $this->get(route('page.thanks'))
            ->assertOk()
            ->assertSee('bezüglich der freien', false)
            ->assertDontSee('Vermarktungsstart');
    }

    public function test_the_thanks_page_falls_back_without_flash_data(): void
    {
        $this->get(route('page.thanks'))
            ->assertOk()
            ->assertSee('Vielen Dank, wir haben Ihre Anfrage erhalten')
            ->assertSee('Vermarktungsstart');
    }

    /** @param  array<int,string>  $sizes */
    private function submitForm(array $sizes): void
    {
        Livewire::test(ContactForm::class)
            ->set('apartment_sizes', $sizes)
            ->set('first_name', 'Erika')
            ->set('last_name', 'Muster')
            ->set('street', 'Teststrasse 1')
            ->set('zip_city', '4056 Basel')
            ->set('email', 'erika@example.com')
            ->set('phone', '061 000 00 00')
            ->set('message', 'Ich interessiere mich für eine Gewerbefläche.')
            ->set('privacy', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect(route('page.thanks'));
    }
}
