<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OutbidMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $nama_barang,
        public int $harga_baru
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Penawaran Anda Telah Dilampaui - LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.outbid');
    }
}
