<?php

namespace App\Exports;

use App\Models\Lelang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LelangExport implements FromCollection, WithHeadings, WithMapping
{
    protected $status_filter;

    public function __construct($status_filter = null)
    {
        $this->status_filter = $status_filter;
    }

    public function collection()
    {
        $query = Lelang::with(['barang', 'pemenang']);

        if ($this->status_filter) {
            if ($this->status_filter === 'dikonfirmasi') {
                $query->where('status_konfirmasi', 'dikonfirmasi');
            } elseif ($this->status_filter === 'dibayar') {
                $query->where('status_konfirmasi', 'dibayar');
            } elseif ($this->status_filter === 'menunggu') {
                $query->where('status_konfirmasi', 'menunggu_konfirmasi');
            }
        }

        return $query->where('status', 'ditutup')->orderByDesc('id_lelang')->get();
    }

    public function headings(): array
    {
        return [
            'ID Lelang',
            'Nama Barang',
            'Tanggal Lelang',
            'Harga Awal',
            'Harga Akhir',
            'Pemenang',
            'No. Faktur',
            'Status Konfirmasi',
            'Tanggal Konfirmasi',
            'Bukti Pembayaran',
            'Tanggal Bayar',
        ];
    }

    public function map($lelang): array
    {
        return [
            $lelang->id_lelang,
            $lelang->barang->nama_barang ?? '-',
            $lelang->tgl_lelang,
            $lelang->barang->harga_awal ?? 0,
            $lelang->harga_akhir ?? 0,
            $lelang->pemenang->nama_lengkap ?? '-',
            $lelang->nomor_faktur ?? '-',
            $lelang->status_konfirmasi ?? '-',
            $lelang->tanggal_konfirmasi ? $lelang->tanggal_konfirmasi->format('Y-m-d H:i:s') : '-',
            $lelang->bukti_pembayaran ? 'Ada' : 'Belum',
            $lelang->tanggal_bayar ? $lelang->tanggal_bayar->format('Y-m-d H:i:s') : '-',
        ];
    }
}
