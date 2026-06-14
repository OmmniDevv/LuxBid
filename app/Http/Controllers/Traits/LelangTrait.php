<?php

namespace App\Http\Controllers\Traits;

use App\Models\GambarBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait LelangTrait
{
    /**
     * Tambahkan _harga_tertinggi, _pemenang, dan opsional _id_user_pw ke koleksi lelang.
     */
    protected function enrichLelang($collection, bool $withUserId = false)
    {
        $ids = $collection->pluck('id_lelang')->all();

        // 1 query: max penawaran per lelang
        $maxBid = DB::table('history_lelang')
            ->whereIn('id_lelang', $ids)
            ->select('id_lelang', DB::raw('MAX(penawaran_harga) as max_harga'))
            ->groupBy('id_lelang')
            ->pluck('max_harga', 'id_lelang');

        // 1 query: pemenang (user dengan penawaran tertinggi) per lelang
        $pemenangRows = DB::table('history_lelang')
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->whereIn('history_lelang.id_lelang', $ids)
            ->select(
                'history_lelang.id_lelang',
                'history_lelang.id_user',
                'tb_masyarakat.nama_lengkap',
                DB::raw('MAX(history_lelang.penawaran_harga) as max_harga')
            )
            ->groupBy('history_lelang.id_lelang', 'history_lelang.id_user', 'tb_masyarakat.nama_lengkap')
            ->get()
            ->sortByDesc('max_harga')
            ->keyBy('id_lelang');

        return $collection->map(function ($l) use ($maxBid, $pemenangRows, $withUserId) {
            $l->_harga_tertinggi = $maxBid->get($l->id_lelang);
            $pw = $pemenangRows->get($l->id_lelang);
            $l->_pemenang   = $pw?->nama_lengkap;
            $l->_id_user_pw = $withUserId ? ($pw?->id_user ?? 0) : 0;
            return $l;
        });
    }

    /**
     * Lempar kemenangan ke penawar tertinggi berikutnya.
     * Dipanggil saat pemenang saat ini batalkan atau timeout.
     *
     * @return bool true jika ada penawar pengganti, false jika tidak ada
     */
    protected function lemparKePenawarKedua(\App\Models\Lelang $lelang, string $alasan = 'Pemenang sebelumnya membatalkan'): bool
    {
        // Ambil semua user yang pernah dibatalkan untuk lelang ini
        $userDibatalkan = \App\Models\RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)
            ->where('status', 'dibatalkan')
            ->pluck('id_user')
            ->all();

        // Cari penawar tertinggi berikutnya yang belum pernah jadi pemenang atau sudah dikonfirmasi
        $penawarBerikutnya = \App\Models\HistoryLelang::where('id_lelang', $lelang->id_lelang)
            ->whereNotIn('id_user', $userDibatalkan)
            ->where('id_user', '!=', $lelang->id_user) // exclude pemenang saat ini
            ->orderByDesc('penawaran_harga')
            ->first();

        if (!$penawarBerikutnya) {
            // Tidak ada penawar lagi
            $lelang->update([
                'status_konfirmasi' => 'selesai',
                'catatan_admin' => $alasan . ' - Tidak ada penawar pengganti tersedia'
            ]);

            // Catat riwayat pemenang lama sebagai dibatalkan
            if ($lelang->id_user) {
                $urutan = \App\Models\RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)->count() + 1;
                \App\Models\RiwayatPemenangLelang::create([
                    'id_lelang' => $lelang->id_lelang,
                    'id_user' => $lelang->id_user,
                    'urutan' => $urutan,
                    'status' => 'dibatalkan'
                ]);
            }

            return false;
        }

        // Catat pemenang lama sebagai dibatalkan
        if ($lelang->id_user) {
            $urutan = \App\Models\RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)->count() + 1;
            \App\Models\RiwayatPemenangLelang::create([
                'id_lelang' => $lelang->id_lelang,
                'id_user' => $lelang->id_user,
                'urutan' => $urutan,
                'status' => 'dibatalkan'
            ]);
        }

        // Generate nomor faktur baru
        $nomorFaktur = 'INV-' . $lelang->id_lelang . '-' . now()->format('YmdHis');

        // Update lelang dengan pemenang baru
        $lelang->update([
            'id_user' => $penawarBerikutnya->id_user,
            'harga_akhir' => $penawarBerikutnya->penawaran_harga,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'tanggal_konfirmasi' => null,
            'nomor_faktur' => $nomorFaktur,
            'batas_konfirmasi' => now()->addDays(2),
            'catatan_admin' => $alasan
        ]);

        // Catat pemenang baru sebagai aktif
        $urutanBaru = \App\Models\RiwayatPemenangLelang::where('id_lelang', $lelang->id_lelang)->count() + 1;
        \App\Models\RiwayatPemenangLelang::create([
            'id_lelang' => $lelang->id_lelang,
            'id_user' => $penawarBerikutnya->id_user,
            'urutan' => $urutanBaru,
            'status' => 'aktif'
        ]);

        // Kirim email ke pemenang baru
        $masyarakat = \App\Models\Masyarakat::find($penawarBerikutnya->id_user);
        if ($masyarakat && $masyarakat->email) {
            \Mail::to($masyarakat->email)->queue(new \App\Mail\LelangPemenangMail(
                $lelang,
                $masyarakat->nama_lengkap,
                $nomorFaktur,
                route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang)
            ));
        }

        return true;
    }

}
