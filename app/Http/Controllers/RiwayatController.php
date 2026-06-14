<?php

namespace App\Http\Controllers;

use App\Models\HistoryLelang;
use App\Models\Lelang;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $id_user = session('id_user');

        $riwayat = Lelang::with(['barang.kategori', 'barang.gambarUtama'])
            ->where(function($q) use ($id_user) {
                // Lelang yang pernah diikuti
                $q->whereHas('history', function($h) use ($id_user) {
                    $h->where('id_user', $id_user);
                })
                // Atau lelang yang pernah dimenangkan
                ->orWhere('id_user', $id_user);
            })
            ->orderByDesc('id_lelang')
            ->paginate(20);

        // Enrich dengan detail penawaran user
        $riwayat->getCollection()->transform(function($lelang) use ($id_user) {
            $lelang->_penawaran_saya = HistoryLelang::where('id_lelang', $lelang->id_lelang)
                ->where('id_user', $id_user)
                ->max('penawaran_harga');

            $lelang->_jumlah_penawaran_saya = HistoryLelang::where('id_lelang', $lelang->id_lelang)
                ->where('id_user', $id_user)
                ->count();

            $lelang->_status_saya = $lelang->id_user == $id_user ? 'Menang' : 'Kalah';

            return $lelang;
        });

        return view('masyarakat.riwayat', compact('riwayat'));
    }

    public function detail($id_lelang)
    {
        $id_user = session('id_user');

        $lelang = Lelang::with(['barang.kategori', 'barang.gambar', 'petugas', 'pemenang'])
            ->findOrFail($id_lelang);

        // Cek apakah user pernah ikut lelang ini
        $pernah_ikut = HistoryLelang::where('id_lelang', $id_lelang)
            ->where('id_user', $id_user)
            ->exists();

        if (!$pernah_ikut && $lelang->id_user != $id_user) {
            abort(403, 'Anda tidak memiliki akses ke riwayat lelang ini.');
        }

        // Ambil semua penawaran user
        $penawaran_saya = HistoryLelang::where('id_lelang', $id_lelang)
            ->where('id_user', $id_user)
            ->orderByDesc('penawaran_harga')
            ->get();

        // Ambil timeline lelang
        $timeline = HistoryLelang::with('masyarakat')
            ->where('id_lelang', $id_lelang)
            ->orderByDesc('penawaran_harga')
            ->get();

        return view('masyarakat.riwayat_detail', compact('lelang', 'penawaran_saya', 'timeline'));
    }
}
