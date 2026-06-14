<?php

namespace App\Console\Commands;

use App\Models\Lelang;
use App\Models\RiwayatPemenangLelang;
use App\Models\HistoryLelang;
use App\Models\Masyarakat;
use App\Mail\LelangPemenangMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProsesBatasKonfirmasi extends Command
{
    protected $signature   = 'lelang:proses-batas-konfirmasi';
    protected $description = 'Auto-cancel lelang yang melewati batas konfirmasi dan lempar ke penawar berikutnya';

    public function handle(): void
    {
        $lelangTimeout = Lelang::where('status_konfirmasi', 'menunggu_konfirmasi')
            ->whereNotNull('batas_konfirmasi')
            ->where('batas_konfirmasi', '<=', now())
            ->get();

        if ($lelangTimeout->isEmpty()) {
            $this->info('Tidak ada lelang yang melewati batas konfirmasi.');
            return;
        }

        $processed = 0;
        foreach ($lelangTimeout as $lelang) {
            // Catat pemenang lama sebagai dibatalkan
            if ($lelang->id_user) {
                $urutan = RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)->count() + 1;
                RiwayatPemenangLelang::create([
                    'id_lelang' => $lelang->id_lelang,
                    'id_user' => $lelang->id_user,
                    'urutan' => $urutan,
                    'status' => 'dibatalkan'
                ]);
            }

            // Cari penawar berikutnya
            $this->lemparKePenawarKedua($lelang, 'Dibatalkan otomatis - melewati batas konfirmasi');
            $processed++;
        }

        $this->info("Berhasil memproses {$processed} lelang yang timeout.");
    }

    private function lemparKePenawarKedua(Lelang $lelang, string $alasan): bool
    {
        $userDibatalkan = RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)
            ->where('status', 'dibatalkan')
            ->pluck('id_user')
            ->all();

        $penawarBerikutnya = HistoryLelang::where('id_lelang', $lelang->id_lelang)
            ->whereNotIn('id_user', $userDibatalkan)
            ->where('id_user', '!=', $lelang->id_user)
            ->orderByDesc('penawaran_harga')
            ->first();

        if (!$penawarBerikutnya) {
            $lelang->update([
                'status_konfirmasi' => 'selesai',
                'catatan_admin' => $alasan . ' - Tidak ada penawar pengganti tersedia'
            ]);
            return false;
        }

        $nomorFaktur = 'INV-' . $lelang->id_lelang . '-' . now()->format('YmdHis');

        $lelang->update([
            'id_user' => $penawarBerikutnya->id_user,
            'harga_akhir' => $penawarBerikutnya->penawaran_harga,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'tanggal_konfirmasi' => null,
            'nomor_faktur' => $nomorFaktur,
            'batas_konfirmasi' => now()->addDays(2),
            'catatan_admin' => $alasan
        ]);

        $urutanBaru = RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)->count() + 1;
        RiwayatPemenangLelang::create([
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $penawarBerikutnya->id_user,
            'urutan' => $urutanBaru,
            'status' => 'aktif'
        ]);

        $masyarakat = Masyarakat::find($penawarBerikutnya->id_user);
        if ($masyarakat && $masyarakat->email) {
            Mail::to($masyarakat->email)->queue(new LelangPemenangMail(
                $lelang,
                $masyarakat->nama_lengkap,
                $nomorFaktur,
                route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang)
            ));
        }

        return true;
    }
}
