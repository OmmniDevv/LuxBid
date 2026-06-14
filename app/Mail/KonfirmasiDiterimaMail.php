<?php

namespace App\Mail;

use App\Models\Lelang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KonfirmasiDiterimaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lelang $lelang,
        public string $nama_pemenang
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Konfirmasi Kemenangan Diterima - LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.konfirmasi_diterima');
    }
}
