<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\LelangTrait;
use App\Models\Barang;
use App\Models\GambarBarang;
use App\Models\Lelang;
use App\Models\Petugas;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller
{
    use LelangTrait;

    public function index()
    {
        $total_barang       = Barang::count();
        $total_lelang_aktif = Lelang::where('status', 'dibuka')->count();
        $total_penawaran    = HistoryLelang::count();
        $total_masyarakat   = DB::table('tb_masyarakat')->count();

        $recent_lelang = Lelang::with(['barang', 'petugas'])
            ->orderByDesc('id_lelang')
            ->limit(8)
            ->get();

        return view('administrator.index', compact(
            'total_barang', 'total_lelang_aktif', 'total_penawaran', 'total_masyarakat', 'recent_lelang'
        ));
    }

    public function barang()
    {
        $rows_barang = Barang::orderByDesc('id_barang')->get();
        $all_gambar  = GambarBarang::whereIn('id_barang', $rows_barang->pluck('id_barang'))
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
            'nama_penjual'     => $request->input('nama_penjual', ''),
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
            'nama_penjual'     => $request->input('nama_penjual', ''),
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
                $file     = $request->file("gambar_{$i}");
                $ext      = strtolower($file->getClientOriginalExtension());
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
        $tb_level   = DB::table('tb_level')->get();

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
        $total_selesai   = Lelang::where('status', 'ditutup')->count();
        $total_aktif     = Lelang::where('status', 'dibuka')->count();
        $total_penawaran = HistoryLelang::count();
        $total_nilai     = Lelang::where('status', 'ditutup')->sum('harga_akhir');

        $rows = $this->enrichLelang(
            Lelang::with(['barang', 'petugas'])->orderByDesc('id_lelang')->get()
        );

        return view('administrator.laporan', compact('total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'rows'));
    }

    public function print()
    {
        $rows = $this->enrichLelang(
            Lelang::with(['barang', 'petugas'])->orderByDesc('id_lelang')->get()
        );

        return view('administrator.print', compact('rows'));
    }

    public function laporanPdf(Request $request)
    {
        $total_selesai   = Lelang::where('status', 'ditutup')->count();
        $total_aktif     = Lelang::where('status', 'dibuka')->count();
        $total_penawaran = HistoryLelang::count();
        $total_nilai     = Lelang::where('status', 'ditutup')->sum('harga_akhir');

        $rows     = $this->enrichLelang(
            Lelang::with(['barang', 'petugas'])->orderByDesc('id_lelang')->get()
        );
        $mode     = $request->query('mode', 'print');
        $username = session('username', 'administrator');
        $now      = now()->timezone('Asia/Jakarta');

        if ($mode === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shared.laporan_pdf_doc', compact(
                'rows', 'total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'username'
            ))->setPaper('a4', 'landscape');

            $filename = 'laporan_' . $username . '_' . $now->format('Y-m-d') . '_' . $now->format('H-i') . '.pdf';
            return $pdf->download($filename);
        }

        return view('shared.laporan_pdf', compact(
            'rows', 'total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'mode', 'username'
        ));
    }
}
