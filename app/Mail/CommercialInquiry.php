<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sofort-Benachrichtigung an die Vermarktung, sobald in einer Anfrage
 * "Gewerbefläche" angewählt wurde. Die Anfrage läuft zusätzlich ganz normal
 * in die wöchentliche CSV-Liste.
 */
class CommercialInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Registration $registration) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Gewerbeflächen-Anfrage – '.$this->registration->fullName(),
            replyTo: [$this->registration->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.commercial-inquiry',
            with: ['registration' => $this->registration],
        );
    }
}
