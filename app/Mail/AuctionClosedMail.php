<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuctionClosedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $nama_barang,
        public int $penawaran_saya
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Lelang Telah Ditutup - LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.auction_closed');
    }
}
