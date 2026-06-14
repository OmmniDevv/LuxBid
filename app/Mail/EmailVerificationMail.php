<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EmailVerificationMail extends Mailable
{
    public function __construct(public string $nama, public string $code) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Verifikasi Email Akun LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.email_verification');
    }
}
