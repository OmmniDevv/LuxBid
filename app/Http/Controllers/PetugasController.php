<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\LelangTrait;
use App\Mail\AuctionClosedMail;
use App\Mail\AuctionOpenedMail;
use App\Mail\AuctionWonMail;
use App\Models\Barang;
use App\Models\GambarBarang;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\Petugas;
use App\Models\HistoryLelang;
use App\Services\BarangService;
use App\Services\LelangService;
use App\Services\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class PetugasController extends Controller
{
    use LelangTrait;

    public function __construct(
        private BarangService $barangService,
        private LelangService $lelangService,
    ) {}

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
        $rows_barang = Barang::with('kategori')->orderByDesc('id_barang')->paginate(15);
        $all_gambar  = GambarBarang::whereIn('id_barang', $rows_barang->pluck('id_barang'))
            ->orderBy('urutan')
            ->get()
            ->groupBy('id_barang')
            ->map(fn($g) => $g->keyBy('urutan'));
        $tb_kategori = Cache::remember('kategori.all', 3600, fn() => \App\Models\Kategori::orderBy('nama_kategori')->get());

        return view('petugas.barang', compact('rows_barang', 'all_gambar', 'tb_kategori'));
    }

    public function simpanBarang(Request $request)
    {
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

        return redirect()->route('petugas.barang', ['info' => 'simpan']);
    }

    public function updateBarang(Request $request)
    {
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

        return redirect()->route('petugas.barang', ['info' => 'update']);
    }

    public function hapusBarang($id)
    {
        $id_lelang_list = Lelang::where('id_barang', $id)->pluck('id_lelang');
        HistoryLelang::whereIn('id_lelang', $id_lelang_list)->delete();
        HistoryLelang::where('id_barang', $id)->delete();
        Lelang::where('id_barang', $id)->delete();
        $this->barangService->delete((int) $id);
        ActivityLog::record('delete_barang', 'Barang', (int) $id);

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
        $lelang = Lelang::with('barang')->findOrFail($request->input('id_lelang'));
        $this->lelangService->buka($lelang);
        ActivityLog::record('buka_lelang', 'Lelang', $lelang->id_lelang, ['barang' => $lelang->barang->nama_barang]);

        return redirect()->route('petugas.aktivasi', ['info' => 'update']);
    }

    public function checkTimer()
    {
        $expired = Lelang::with('barang')->where('status', 'dibuka')
            ->whereNotNull('timer_end')
            ->where('timer_end', '<=', now())
            ->get();

        foreach ($expired as $l) {
            $this->lelangService->autoClose($l);
        }

        return response()->json(['closed' => $expired->count()]);
    }

    public function tutupLelang(Request $request)
    {
        $lelang = Lelang::with('barang')->findOrFail($request->input('id_lelang'));
        $this->lelangService->tutup($lelang, (int) $request->input('id_user', 0), (int) $request->input('harga_akhir', 0));
        ActivityLog::record('tutup_lelang', 'Lelang', $lelang->id_lelang, ['harga_akhir' => $request->input('harga_akhir')]);

        return redirect()->route('petugas.aktivasi', ['info' => 'update']);
    }

    public function laporan(Request $request)
    {
        $total_selesai   = Lelang::where('status', 'ditutup')->count();
        $total_aktif     = Lelang::where('status', 'dibuka')->count();
        $total_penawaran = HistoryLelang::count();
        $total_nilai     = Lelang::where('status', 'ditutup')->sum('harga_akhir');

        $query = Lelang::with(['barang', 'petugas', 'pemenang'])->orderByDesc('id_lelang');

        // Filter by status_konfirmasi
        if ($request->filled('status_konfirmasi')) {
            $query->where('status_konfirmasi', $request->input('status_konfirmasi'));
        }

        $paginator = $query->paginate(15)->appends($request->except('page'));
        $rows = $this->enrichLelang($paginator->getCollection());
        $paginator->setCollection($rows);

        return view('petugas.laporan', compact('total_selesai', 'total_aktif', 'total_penawaran', 'total_nilai', 'paginator'));
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

        return redirect()->route('petugas.laporan')->with('success', 'Status konfirmasi berhasil diupdate.');
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
