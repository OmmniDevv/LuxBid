<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\LelangTrait;
use App\Models\Barang;
use App\Models\GambarBarang;
use App\Models\Lelang;
use App\Models\Petugas;
use App\Models\HistoryLelang;
use App\Services\BarangService;
use App\Services\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AdministratorController extends Controller
{
    use LelangTrait;

    public function __construct(private BarangService $barangService) {}

    public function index()
    {
        $total_barang       = Barang::count();
        $total_lelang_aktif = Lelang::where('status', 'dibuka')->count();
        $total_penawaran    = HistoryLelang::count();
        $total_masyarakat   = DB::table('tb_masyarakat')->count();
        $menunggu_konfirmasi = Lelang::where('status_konfirmasi', 'menunggu_konfirmasi')->count();
        $menunggu_verifikasi = Lelang::where('status_konfirmasi', 'dikonfirmasi')
            ->whereNotNull('bukti_pembayaran')
            ->count();
        $total_pendapatan = Lelang::where('status_konfirmasi', 'dibayar')->sum('harga_akhir');

        $recent_lelang = Lelang::with(['barang', 'petugas'])
            ->orderByDesc('id_lelang')
            ->limit(8)
            ->get();

        return view('administrator.index', compact(
            'total_barang', 'total_lelang_aktif', 'total_penawaran', 'total_masyarakat',
            'menunggu_konfirmasi', 'menunggu_verifikasi', 'total_pendapatan', 'recent_lelang'
        ));
    }

    public function barang()
    {
        $rows_barang = Barang::with('kategori')->orderByDesc('id_barang')->paginate(15);
        $all_gambar  = GambarBarang::whereIn('id_barang', $rows_barang->pluck('id_barang'))
            ->orderBy('urutan')
            ->get()
            ->groupBy('id_barang')
            ->map(fn($g) => $g->keyBy('urutan'));
        $tb_kategori = Cache::remember('kategori.all', 3600, fn() => \App\Models\Kategori::orderBy('nama_kategori')->get());

        return view('administrator.barang', compact('rows_barang', 'all_gambar', 'tb_kategori'));
    }

    public function simpanBarang(Request $request)
    {
        // Clean price format (remove thousand separators)
        if ($request->filled('harga_awal')) {
            $request->merge([
                'harga_awal' => str_replace(['.', ','], '', $request->input('harga_awal'))
            ]);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'tgl'         => 'required|date',
            'harga_awal'  => 'required|numeric|min:0',
            'id_kategori' => 'nullable|exists:tb_kategori,id_kategori',
            'nama_penjual'=> 'nullable|string|max:255',
            'gambar_1'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_2'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_3'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $barang = $this->barangService->store($request->all(), $request);
        ActivityLog::record('create_barang', 'Barang', $barang->id_barang, ['nama' => $barang->nama_barang]);

        return redirect()->route('administrator.barang', ['info' => 'simpan']);
    }

    public function updateBarang(Request $request)
    {
        // Clean price format (remove thousand separators)
        if ($request->filled('harga_awal')) {
            $request->merge([
                'harga_awal' => str_replace(['.', ','], '', $request->input('harga_awal'))
            ]);
        }

        $request->validate([
            'id_barang'   => 'required|exists:tb_barang,id_barang',
            'nama_barang' => 'required|string|max:255',
            'tgl'         => 'required|date',
            'harga_awal'  => 'required|numeric|min:0',
            'id_kategori' => 'nullable|exists:tb_kategori,id_kategori',
            'nama_penjual'=> 'nullable|string|max:255',
            'gambar_1'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_2'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gambar_3'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $this->barangService->update((int) $request->input('id_barang'), $request->all(), $request);
        ActivityLog::record('update_barang', 'Barang', (int) $request->input('id_barang'), ['nama' => $request->input('nama_barang')]);

        return redirect()->route('administrator.barang', ['info' => 'update']);
    }

    public function hapusBarang($id)
    {
        $this->barangService->delete((int) $id);
        ActivityLog::record('delete_barang', 'Barang', (int) $id);

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
        $petugas = Petugas::create([
            'nama_petugas' => $request->input('nama_petugas'),
            'username'     => $request->input('username'),
            'password'     => Hash::make($request->input('password')),
            'id_level'     => $request->input('id_level'),
        ]);
        ActivityLog::record('create_petugas', 'Petugas', $petugas->id_petugas, ['username' => $petugas->username]);

        return redirect()->route('administrator.petugas', ['info' => 'simpan']);
    }

    public function updatePetugas(Request $request)
    {
        Petugas::where('id_petugas', $request->input('id_petugas'))->update([
            'nama_petugas' => $request->input('nama_petugas'),
            'username'     => $request->input('username'),
            'password'     => Hash::make($request->input('password')),
            'id_level'     => $request->input('id_level'),
        ]);
        ActivityLog::record('update_petugas', 'Petugas', (int) $request->input('id_petugas'), ['username' => $request->input('username')]);

        return redirect()->route('administrator.petugas', ['info' => 'update']);
    }

    public function hapusPetugas($id)
    {
        Petugas::where('id_petugas', $id)->delete();
        ActivityLog::record('delete_petugas', 'Petugas', (int) $id);

        return redirect()->route('administrator.petugas', ['info' => 'hapus']);
    }

    public function laporan(Request $request)
    {
        $total_selesai   = Lelang::where('status', 'ditutup')->count();
        $total_aktif     = Lelang::where('status', 'dibuka')->count();
        $total_penawaran = HistoryLelang::count();
        $total_nilai     = Lelang::where('status', 'ditutup')->sum('harga_akhir');

        $query = Lelang::with(['barang', 'petugas', 'pemenang', 'riwayatPemenang.masyarakat'])->orderByDesc('id_lelang');

        // Filter by status_konfirmasi
        if ($request->filled('status_konfirmasi')) {
            $query->where('status_konfirmasi', $request->input('status_konfirmasi'));
        }

        $paginator = $query->paginate(15)->appends($request->except('page'));
        $rows = $this->enrichLelang($paginator->getCollection());
        $paginator->setCollection($rows);

        return view('administrator.laporan', compact('total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'paginator'));
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

    public function updateStatusKonfirmasi(Request $request)
    {
        $request->validate([
            'id_lelang' => 'required|exists:tb_lelang,id_lelang',
            'status_konfirmasi' => 'required|in:menunggu_konfirmasi,dikonfirmasi,dibatalkan,selesai',
        ]);

        $lelang = Lelang::findOrFail($request->input('id_lelang'));

        $lelang->update([
            'status_konfirmasi' => $request->input('status_konfirmasi'),
            'catatan_admin' => $request->input('catatan_admin'),
            'tanggal_konfirmasi' => now(),
        ]);

        ActivityLog::record('update_status_konfirmasi', 'Lelang', $lelang->id_lelang, [
            'status_konfirmasi' => $request->input('status_konfirmasi'),
        ]);

        return redirect()->route('administrator.laporan')->with('success', 'Status konfirmasi berhasil diupdate.');
    }

    public function exportLaporan(Request $request)
    {
        $statusFilter = $request->input('status_konfirmasi');

        ActivityLog::record('export_laporan', 'Lelang', null, [
            'status_filter' => $statusFilter,
        ]);

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LelangExport($statusFilter),
            'laporan_lelang_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    public function fakturPdf($id_lelang)
    {
        $lelang = Lelang::with(['barang', 'pemenang'])->findOrFail($id_lelang);

        $nomor_faktur = $lelang->nomor_faktur
            ?? 'LXB-' . strtoupper(substr(md5($id_lelang . $lelang->id_user), 0, 8));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shared.faktur_pdf', [
            'lelang'       => $lelang,
            'pemenang'     => $lelang->pemenang,
            'barang'       => $lelang->barang,
            'nomor_faktur' => $nomor_faktur,
            'tgl_cetak'    => now()->timezone('Asia/Jakarta')->format('d/m/Y H:i'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('faktur_' . $nomor_faktur . '.pdf');
    }
}
