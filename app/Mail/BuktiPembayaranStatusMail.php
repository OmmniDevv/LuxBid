<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BuktiPembayaranStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nama,
        public string $nama_barang,
        public string $status,
        public string $catatan,
        public string $link_konfirmasi
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->status === 'dibayar'
            ? 'Bukti Pembayaran Diterima - LuxBid'
            : 'Bukti Pembayaran Ditolak - LuxBid';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.bukti_pembayaran_status');
    }
}
