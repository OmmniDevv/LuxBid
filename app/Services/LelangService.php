<?php

namespace App\Services;

use App\Mail\AuctionClosedMail;
use App\Mail\AuctionOpenedMail;
use App\Mail\AuctionWonMail;
use App\Mail\OutbidMail;
use App\Models\HistoryLelang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LelangService
{
    public function buka(Lelang $lelang): void
    {
        $lelang->update(['status' => 'dibuka', 'id_user' => 0, 'harga_akhir' => 0, 'timer_end' => now()->addMinutes(6)]);

        $penerima = Masyarakat::whereNotNull('email')->get();
        foreach ($penerima as $m) {
            try {
                Mail::to($m->email)->send(new AuctionOpenedMail($m->nama_lengkap, $lelang->barang->nama_barang, $lelang->barang->harga_awal));
            } catch (\Exception) {}
        }
    }

    public function tutup(Lelang $lelang, int $id_pemenang, int $harga_akhir): void
    {
        $nomor_faktur = 'LXB-' . strtoupper(substr(md5($lelang->id_lelang . $id_pemenang . time()), 0, 8));

        $lelang->update([
            'status' => 'ditutup',
            'id_user' => $id_pemenang,
            'harga_akhir' => $harga_akhir,
            'status_konfirmasi' => 'menunggu_konfirmasi',
            'nomor_faktur' => $nomor_faktur,
            'batas_konfirmasi' => now()->addDays(2),
        ]);

        $nama_barang = $lelang->barang->nama_barang;

        $penawar = DB::table('history_lelang')
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->where('history_lelang.id_lelang', $lelang->id_lelang)
            ->whereNotNull('tb_masyarakat.email')
            ->select('tb_masyarakat.id_user', 'tb_masyarakat.email', 'tb_masyarakat.nama_lengkap',
                     DB::raw('MAX(history_lelang.penawaran_harga) as penawaran_saya'))
            ->groupBy('tb_masyarakat.id_user', 'tb_masyarakat.email', 'tb_masyarakat.nama_lengkap')
            ->get();

        // Ambil 2-3 lelang rekomendasi dengan kategori sama yang masih dibuka
        $rekomendasi = [];
        if ($lelang->barang->id_kategori) {
            $rekomendasi = Lelang::with(['barang.kategori'])
                ->where('status', 'dibuka')
                ->whereHas('barang', function($q) use ($lelang) {
                    $q->where('id_kategori', $lelang->barang->id_kategori);
                })
                ->where('id_lelang', '!=', $lelang->id_lelang)
                ->limit(3)
                ->get()
                ->map(fn($l) => [
                    'nama_barang' => $l->barang->nama_barang,
                    'harga_awal' => $l->barang->harga_awal,
                    'kategori' => $l->barang->kategori->nama_kategori ?? 'Umum',
                ])
                ->toArray();
        }

        foreach ($penawar as $p) {
            try {
                if ($p->id_user == $id_pemenang) {
                    $lelang->refresh()->load(['barang', 'pemenang']);
                    $link_konfirmasi = route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang);
                    Mail::to($p->email)->queue(new \App\Mail\LelangPemenangMail($lelang, $p->nama_lengkap, $nomor_faktur, $link_konfirmasi));
                } else {
                    Mail::to($p->email)->queue(new \App\Mail\LelangBerakhirPesertaMail($p->nama_lengkap, $nama_barang, $p->penawaran_saya, $rekomendasi));
                }
            } catch (\Exception) {}
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function bid(Lelang $lelang, int $id_user, int $id_barang, int $penawaran_baru): HistoryLelang
    {
        $tertinggi = DB::table('history_lelang')->where('id_lelang', $lelang->id_lelang)->max('penawaran_harga')
            ?? $lelang->barang->harga_awal;

        if ($penawaran_baru < $tertinggi + 1000) {
            throw new \InvalidArgumentException('min_bid');
        }
        if ($penawaran_baru > $lelang->barang->harga_awal * 20) {
            throw new \InvalidArgumentException('max_bid');
        }

        $history = HistoryLelang::create([
            'id_lelang'       => $lelang->id_lelang,
            'id_barang'       => $id_barang,
            'id_user'         => $id_user,
            'penawaran_harga' => $penawaran_baru,
        ]);

        $lelang->update(['timer_end' => now()->addMinutes(6)]);

        $prev = DB::table('history_lelang')
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->where('history_lelang.id_lelang', $lelang->id_lelang)
            ->where('history_lelang.id_user', '!=', $id_user)
            ->whereNotNull('tb_masyarakat.email')
            ->orderByDesc('history_lelang.penawaran_harga')
            ->select('tb_masyarakat.email', 'tb_masyarakat.nama_lengkap')
            ->first();

        if ($prev) {
            try {
                Mail::to($prev->email)->send(new OutbidMail($prev->nama_lengkap, $lelang->barang->nama_barang, $penawaran_baru));
            } catch (\Exception) {}
        }

        return $history;
    }

    public function autoClose(Lelang $lelang): void
    {
        $top = DB::table('history_lelang')
            ->where('id_lelang', $lelang->id_lelang)
            ->orderByDesc('penawaran_harga')
            ->first();

        if ($top) {
            $nomor_faktur = 'LXB-' . strtoupper(substr(md5($lelang->id_lelang . $top->id_user . time()), 0, 8));

            $lelang->update([
                'status'      => 'ditutup',
                'harga_akhir' => $top->penawaran_harga,
                'id_user'     => $top->id_user,
                'status_konfirmasi' => 'menunggu_konfirmasi',
                'nomor_faktur' => $nomor_faktur,
                'batas_konfirmasi' => now()->addDays(2),
            ]);

            // Kirim email ke pemenang
            $pemenang = \App\Models\Masyarakat::find($top->id_user);
            if ($pemenang && $pemenang->email) {
                try {
                    $lelang->refresh()->load(['barang', 'pemenang']);
                    $link_konfirmasi = route('masyarakat.konfirmasi_kemenangan', $lelang->id_lelang);
                    Mail::to($pemenang->email)->queue(new \App\Mail\LelangPemenangMail($lelang, $pemenang->nama_lengkap, $nomor_faktur, $link_konfirmasi));
                } catch (\Exception) {}
            }
        } else {
            $lelang->update([
                'status'      => 'ditutup',
                'harga_akhir' => 0,
                'id_user'     => 0,
            ]);
        }
    }
}
