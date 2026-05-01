<?php

namespace App\Console\Commands;

use App\Models\Barang;
use App\Models\GambarBarang;
use App\Models\Lelang;
use Illuminate\Console\Command;

class HapusBarangKadaluarsa extends Command
{
    protected $signature   = 'lelang:hapus-barang-kadaluarsa';
    protected $description = 'Hapus data barang yang lelangnya sudah selesai lebih dari 7 hari';

    public function handle(): void
    {
        $batas = now()->subDays(7)->toDateString();

        // Ambil id_barang dari lelang yang sudah ditutup >= 7 hari lalu dan ada pemenang
        $id_barangs = Lelang::where('status', 'ditutup')
            ->where('harga_akhir', '>', 0)   // ada pemenang
            ->where('tgl_lelang', '<=', $batas)
            ->pluck('id_barang')
            ->unique()
            ->filter(); // buang null

        if ($id_barangs->isEmpty()) {
            $this->info('Tidak ada barang kadaluarsa.');
            return;
        }

        foreach ($id_barangs as $id_barang) {
            // Hapus file foto fisik
            GambarBarang::where('id_barang', $id_barang)->each(function ($g) {
                @unlink(public_path("uploads/barang/{$g->nama_file}"));
            });
            GambarBarang::where('id_barang', $id_barang)->delete();
            Barang::where('id_barang', $id_barang)->delete();
        }

        $this->info("Berhasil menghapus {$id_barangs->count()} barang kadaluarsa.");
    }
}
