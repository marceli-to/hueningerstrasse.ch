<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ihre Anfrage – Hüningerstrasse 40, Basel',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.registration-confirmation',
        );
    }
}
