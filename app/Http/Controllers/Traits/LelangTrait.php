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
        return $collection->map(function ($l) use ($withUserId) {
            $l->_harga_tertinggi = DB::table('history_lelang')
                ->where('id_lelang', $l->id_lelang)
                ->max('penawaran_harga');

            $l->_pemenang    = null;
            $l->_id_user_pw  = 0;

            if ($l->_harga_tertinggi) {
                $pw = DB::table('history_lelang')
                    ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
                    ->where('history_lelang.penawaran_harga', $l->_harga_tertinggi)
                    ->where('history_lelang.id_lelang', $l->id_lelang)
                    ->select('tb_masyarakat.nama_lengkap', 'history_lelang.id_user')
                    ->first();

                $l->_pemenang   = $pw?->nama_lengkap;
                $l->_id_user_pw = $withUserId ? ($pw?->id_user ?? 0) : 0;
            }

            return $l;
        });
    }

    /**
     * Upload hingga 3 gambar barang ke public/uploads/barang/.
     */
    protected function uploadGambar(Request $request, int $id_barang): void
    {
        $upload_dir = public_path('uploads/barang');
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("gambar_{$i}") && $request->file("gambar_{$i}")->isValid()) {
                $file     = $request->file("gambar_{$i}");
                $ext      = strtolower($file->getClientOriginalExtension());
                $filename = "barang_{$id_barang}_{$i}_" . time() . ".{$ext}";
                $file->move($upload_dir, $filename);
                GambarBarang::create(['id_barang' => $id_barang, 'nama_file' => $filename, 'urutan' => $i]);
            }
        }
    }
}
