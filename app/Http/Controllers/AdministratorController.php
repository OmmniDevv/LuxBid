<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\GambarBarang;
use App\Models\Lelang;
use App\Models\Petugas;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller
{
    public function index()
    {
        $total_barang = Barang::count();
        $total_lelang_aktif = Lelang::where('status', 'dibuka')->count();
        $total_penawaran = HistoryLelang::count();
        $total_masyarakat = DB::table('tb_masyarakat')->count();

        $recent_lelang = Lelang::with('barang')->orderByDesc('id_lelang')->limit(8)->get();

        return view('administrator.index', compact(
            'total_barang', 'total_lelang_aktif', 'total_penawaran', 'total_masyarakat', 'recent_lelang'
        ));
    }

    public function barang()
    {
        $rows_barang = Barang::orderByDesc('id_barang')->get();
        $all_gambar = GambarBarang::whereIn('id_barang', $rows_barang->pluck('id_barang'))
            ->orderBy('urutan')
            ->get()
            ->groupBy('id_barang')
            ->map(fn($g) => $g->keyBy('urutan'));

        return view('administrator.barang', compact('rows_barang', 'all_gambar'));
    }

    public function simpanBarang(Request $request)
    {
        $barang = Barang::create([
            'nama_barang'      => $request->input('nama_barang'),
            'tgl'              => $request->input('tgl'),
            'harga_awal'       => $request->input('harga_awal'),
            'deskripsi_barang' => $request->input('deskripsi_barang', ''),
        ]);

        $this->uploadGambar($request, $barang->id_barang);

        return redirect()->route('administrator.barang', ['info' => 'simpan']);
    }

    public function updateBarang(Request $request)
    {
        $id_barang = $request->input('id_barang');

        Barang::where('id_barang', $id_barang)->update([
            'nama_barang'      => $request->input('nama_barang'),
            'tgl'              => $request->input('tgl'),
            'harga_awal'       => $request->input('harga_awal'),
            'deskripsi_barang' => $request->input('deskripsi_barang', ''),
        ]);

        for ($i = 1; $i <= 3; $i++) {
            if ($request->input("hapus_gambar_{$i}")) {
                $old = GambarBarang::where('id_barang', $id_barang)->where('urutan', $i)->first();
                if ($old) {
                    @unlink(public_path("uploads/barang/{$old->nama_file}"));
                    $old->delete();
                }
            }
            if ($request->hasFile("gambar_{$i}") && $request->file("gambar_{$i}")->isValid()) {
                $file = $request->file("gambar_{$i}");
                $ext = strtolower($file->getClientOriginalExtension());
                $filename = "barang_{$id_barang}_{$i}_" . time() . ".{$ext}";
                $file->move(public_path('uploads/barang'), $filename);

                $existing = GambarBarang::where('id_barang', $id_barang)->where('urutan', $i)->first();
                if ($existing) {
                    @unlink(public_path("uploads/barang/{$existing->nama_file}"));
                    $existing->update(['nama_file' => $filename]);
                } else {
                    GambarBarang::create(['id_barang' => $id_barang, 'nama_file' => $filename, 'urutan' => $i]);
                }
            }
        }

        return redirect()->route('administrator.barang', ['info' => 'update']);
    }

    public function hapusBarang(Request $request)
    {
        $id_barang = $request->input('id_barang');
        GambarBarang::where('id_barang', $id_barang)->each(function ($g) {
            @unlink(public_path("uploads/barang/{$g->nama_file}"));
        });
        GambarBarang::where('id_barang', $id_barang)->delete();
        Barang::where('id_barang', $id_barang)->delete();

        return redirect()->route('administrator.barang', ['info' => 'hapus']);
    }

    public function petugas()
    {
        $tb_petugas = Petugas::with('level')->orderBy('id_level')->get();
        $tb_level = DB::table('tb_level')->get();
        return view('administrator.petugas', compact('tb_petugas', 'tb_level'));
    }

    public function simpanPetugas(Request $request)
    {
        Petugas::create([
            'nama_petugas' => $request->input('nama_petugas'),
            'username'     => $request->input('username'),
            'password'     => $request->input('password'),
            'id_level'     => $request->input('id_level'),
        ]);

        return redirect()->route('administrator.petugas', ['info' => 'simpan']);
    }

    public function updatePetugas(Request $request)
    {
        Petugas::where('id_petugas', $request->input('id_petugas'))->update([
            'nama_petugas' => $request->input('nama_petugas'),
            'username'     => $request->input('username'),
            'password'     => $request->input('password'),
            'id_level'     => $request->input('id_level'),
        ]);

        return redirect()->route('administrator.petugas', ['info' => 'update']);
    }

    public function hapusPetugas(Request $request)
    {
        Petugas::where('id_petugas', $request->input('id_petugas'))->delete();
        return redirect()->route('administrator.petugas', ['info' => 'hapus']);
    }

    public function laporan()
    {
        $total_selesai = Lelang::where('status', 'ditutup')->count();
        $total_aktif = Lelang::where('status', 'dibuka')->count();
        $total_penawaran = HistoryLelang::count();
        $total_nilai = Lelang::where('status', 'ditutup')->sum('harga_akhir');

        $rows = Lelang::with(['barang', 'petugas'])
            ->orderByDesc('id_lelang')
            ->get()
            ->map(function ($l) {
                $l->_harga_tertinggi = DB::table('history_lelang')->where('id_lelang', $l->id_lelang)->max('penawaran_harga');
                $l->_pemenang = null;
                if ($l->_harga_tertinggi) {
                    $pw = DB::table('history_lelang')
                        ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
                        ->where('history_lelang.penawaran_harga', $l->_harga_tertinggi)
                        ->where('history_lelang.id_lelang', $l->id_lelang)
                        ->select('tb_masyarakat.nama_lengkap')
                        ->first();
                    $l->_pemenang = $pw?->nama_lengkap;
                }
                return $l;
            });

        return view('administrator.laporan', compact('total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'rows'));
    }

    public function print()
    {
        $rows = Lelang::with(['barang', 'petugas'])
            ->orderByDesc('id_lelang')
            ->get()
            ->map(function ($l) {
                $l->_harga_tertinggi = DB::table('history_lelang')->where('id_lelang', $l->id_lelang)->max('penawaran_harga');
                $l->_pemenang = null;
                if ($l->_harga_tertinggi) {
                    $pw = DB::table('history_lelang')
                        ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
                        ->where('history_lelang.penawaran_harga', $l->_harga_tertinggi)
                        ->where('history_lelang.id_lelang', $l->id_lelang)
                        ->select('tb_masyarakat.nama_lengkap')
                        ->first();
                    $l->_pemenang = $pw?->nama_lengkap;
                }
                return $l;
            });

        return view('administrator.print', compact('rows'));
    }

    private function uploadGambar(Request $request, int $id_barang): void
    {
        $upload_dir = public_path('uploads/barang');
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("gambar_{$i}") && $request->file("gambar_{$i}")->isValid()) {
                $file = $request->file("gambar_{$i}");
                $ext = strtolower($file->getClientOriginalExtension());
                $filename = "barang_{$id_barang}_{$i}_" . time() . ".{$ext}";
                $file->move($upload_dir, $filename);
                GambarBarang::create(['id_barang' => $id_barang, 'nama_file' => $filename, 'urutan' => $i]);
            }
        }
    }
}
