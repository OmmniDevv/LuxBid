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

class PetugasController extends Controller
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

        return view('petugas.index', compact(
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

        return view('petugas.barang', compact('rows_barang', 'all_gambar'));
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

        return redirect()->route('petugas.barang', ['info' => 'simpan']);
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

        return redirect()->route('petugas.barang', ['info' => 'update']);
    }

public function hapusBarang(Request $request)
{
    $id_barang = $request->input('id_barang');

    // 1. Hapus history_lelang yang terkait barang ini
    $id_lelang_list = Lelang::where('id_barang', $id_barang)->pluck('id_lelang');
    HistoryLelang::whereIn('id_lelang', $id_lelang_list)->delete();
    HistoryLelang::where('id_barang', $id_barang)->delete();

    // 2. Hapus lelang yang terkait barang ini
    Lelang::where('id_barang', $id_barang)->delete();

    // 3. Hapus gambar (file fisik + record)
    GambarBarang::where('id_barang', $id_barang)->each(function ($g) {
        @unlink(public_path("uploads/barang/{$g->nama_file}"));
    });
    GambarBarang::where('id_barang', $id_barang)->delete();

    // 4. Hapus barang
    Barang::where('id_barang', $id_barang)->delete();

    return redirect()->route('petugas.barang', ['info' => 'hapus']);
}

    public function aktivasi()
    {
        $rows_lelang = $this->enrichLelang(
            Lelang::with(['barang', 'petugas'])->orderByDesc('id_lelang')->get(),
            withUserId: true
        );

        $barang_list     = Barang::orderBy('nama_barang')->get();
        $petugas_session = Petugas::where('username', session('username'))->first();
        $lelang_aktif    = $rows_lelang->where('status', 'dibuka')->values();

        return view('petugas.aktivasi', compact('rows_lelang', 'barang_list', 'petugas_session', 'lelang_aktif'));
    }

    public function simpanLelang(Request $request)
    {
        Lelang::create([
            'id_barang'   => $request->input('id_barang'),
            'tgl_lelang'  => now()->toDateString(),
            'harga_akhir' => 0,
            'id_user'     => 0,
            'id_petugas'  => $request->input('id_petugas'),
            'status'      => 'dibuka',
            'timer_end'   => now()->addMinutes(6),
        ]);

        return redirect()->route('petugas.aktivasi', ['info' => 'simpan']);
    }

    public function bukaLelang(Request $request)
    {
        Lelang::where('id_lelang', $request->input('id_lelang'))
            ->update(['status' => 'dibuka', 'id_user' => 0, 'harga_akhir' => 0, 'timer_end' => now()->addMinutes(6)]);

        return redirect()->route('petugas.aktivasi', ['info' => 'update']);
    }

    public function checkTimer()
    {
        $expired = Lelang::where('status', 'dibuka')
            ->whereNotNull('timer_end')
            ->where('timer_end', '<=', now())
            ->get();

        foreach ($expired as $l) {
            $top = DB::table('history_lelang')
                ->where('id_lelang', $l->id_lelang)
                ->orderByDesc('penawaran_harga')
                ->first();

            $l->update([
                'status'      => 'ditutup',
                'harga_akhir' => $top ? $top->penawaran_harga : 0,
                'id_user'     => $top ? $top->id_user : 0,
            ]);
        }

        return response()->json(['closed' => $expired->count()]);
    }

    public function tutupLelang(Request $request)
    {
        Lelang::where('id_lelang', $request->input('id_lelang'))
            ->update([
                'status'      => 'ditutup',
                'id_user'     => (int) $request->input('id_user', 0),
                'harga_akhir' => (int) $request->input('harga_akhir', 0),
            ]);

        return redirect()->route('petugas.aktivasi', ['info' => 'update']);
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

        return view('petugas.laporan', compact('total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'rows'));
    }

    public function isi()
    {
        $lelang_aktif = $this->enrichLelang(
            Lelang::with('barang')->where('status', 'dibuka')->get()
        );

        return view('petugas.isi', compact('lelang_aktif'));
    }

    public function petugas()
    {
        $tb_petugas = Petugas::with('level')->orderBy('id_level')->get();
        $tb_level   = DB::table('tb_level')->get();

        return view('petugas.petugas', compact('tb_petugas', 'tb_level'));
    }

    public function print()
    {
        $rows = $this->enrichLelang(
            Lelang::with(['barang', 'petugas'])->orderByDesc('id_lelang')->get()
        );

        return view('petugas.print', compact('rows'));
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
        $username = session('username', 'petugas');
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
