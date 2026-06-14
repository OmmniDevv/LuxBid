<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LelangAkanDitutupMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $nama_barang,
        public int $harga_tertinggi,
        public string $sisa_waktu,
        public string $link_lelang
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Lelang Favorit Anda Akan Ditutup - LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.lelang_akan_ditutup');
    }
}
