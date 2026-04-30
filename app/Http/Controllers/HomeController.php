<?php

namespace App\Http\Controllers;

use App\Models\Lelang;
use App\Models\GambarBarang;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $lelang_aktif = Lelang::with(['barang', 'barang.gambarUtama'])
            ->where('status', 'dibuka')
            ->orderByDesc('id_lelang')
            ->get()
            ->map(function ($l) {
                $l->penawaran_tertinggi = DB::table('history_lelang')
                    ->where('id_lelang', $l->id_lelang)
                    ->max('penawaran_harga');
                $l->jumlah_penawar = DB::table('history_lelang')
                    ->where('id_lelang', $l->id_lelang)
                    ->count();
                $l->foto = $l->barang->gambarUtama?->nama_file;
                return $l;
            });

        $is_logged_in = session('status') === 'login';

        return view('home', compact('lelang_aktif', 'is_logged_in'));
    }
}
