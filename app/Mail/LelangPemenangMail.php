<?php

namespace App\Mail;

use App\Models\Lelang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LelangPemenangMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Lelang $lelang,
        public string $nama_pemenang,
        public string $nomor_faktur,
        public string $link_konfirmasi
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Selamat! Anda Memenangkan Lelang - LuxBid');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.lelang_pemenang');
    }

    public function attachments(): array
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shared.faktur_pdf', [
            'lelang'       => $this->lelang,
            'pemenang'     => $this->lelang->pemenang,
            'barang'       => $this->lelang->barang,
            'nomor_faktur' => $this->nomor_faktur,
            'tgl_cetak'    => now()->timezone('Asia/Jakarta')->format('d/m/Y H:i'),
        ])->setPaper('a4', 'portrait');

        return [
            Attachment::fromData(fn () => $pdf->output(), 'faktur_' . $this->nomor_faktur . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
