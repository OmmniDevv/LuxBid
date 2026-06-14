<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ResetCodeMail extends Mailable
{
    public function __construct(public string $nama, public string $code) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Kode Verifikasi Reset Password - LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reset_code');
    }
}
