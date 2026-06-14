<?php

namespace App\Console\Commands;

use App\Mail\LelangAkanDitutupMail;
use App\Models\Lelang;
use App\Models\Wishlist;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotifikasiLelangAkanDitutup extends Command
{
    protected $signature   = 'lelang:notifikasi-akan-ditutup';
    protected $description = 'Kirim notifikasi ke user yang memfavoritkan lelang yang akan ditutup dalam 1 jam';

    public function handle(): void
    {
        $waktu_mulai = now();
        $waktu_akhir = now()->addHour();

        $lelang_mendekati = Lelang::with(['barang'])
            ->where('status', 'dibuka')
            ->whereNotNull('timer_end')
            ->whereBetween('timer_end', [$waktu_mulai, $waktu_akhir])
            ->get();

        if ($lelang_mendekati->isEmpty()) {
            $this->info('Tidak ada lelang yang akan ditutup dalam 1 jam ke depan.');
            return;
        }

        $notif_terkirim = 0;

        foreach ($lelang_mendekati as $lelang) {
            $wishlist_belum_notif = Wishlist::with('masyarakat')
                ->where('id_barang', $lelang->id_barang)
                ->where('notif_h1_terkirim', false)
                ->get();

            if ($wishlist_belum_notif->isEmpty()) {
                continue;
            }

            $harga_tertinggi = DB::table('history_lelang')
                ->where('id_lelang', $lelang->id_lelang)
                ->max('penawaran_harga') ?? $lelang->barang->harga_awal;

            $sisa_menit = now()->diffInMinutes($lelang->timer_end);
            $sisa_waktu = $sisa_menit . ' menit';

            $link_lelang = url('/') . '/#lelang-' . $lelang->id_lelang;

            foreach ($wishlist_belum_notif as $wishlist) {
                if (!$wishlist->masyarakat || !$wishlist->masyarakat->email) {
                    continue;
                }

                try {
                    Mail::to($wishlist->masyarakat->email)->queue(
                        new LelangAkanDitutupMail(
                            $wishlist->masyarakat->nama_lengkap,
                            $lelang->barang->nama_barang,
                            $harga_tertinggi,
                            $sisa_waktu,
                            $link_lelang
                        )
                    );

                    $wishlist->update(['notif_h1_terkirim' => true]);
                    $notif_terkirim++;
                } catch (\Exception $e) {
                    $this->error("Gagal kirim notifikasi ke {$wishlist->masyarakat->email}: {$e->getMessage()}");
                }
            }
        }

        $this->info("Berhasil mengirim {$notif_terkirim} notifikasi lelang akan ditutup.");
    }
}
