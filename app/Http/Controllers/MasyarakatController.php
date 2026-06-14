<?php

namespace App\Http\Controllers;

use App\Mail\OutbidMail;
use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\HistoryLelang;
use App\Services\LelangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MasyarakatController extends Controller
{
    public function __construct(private LelangService $lelangService) {}

    public function profile()
    {
        $user = Masyarakat::find(session('id_user'));
        return view('masyarakat.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $id = session('id_user');
        $user = Masyarakat::find($id);

        // Verify password
        $pass = $request->input('confirm_password');
        $ok = Hash::check($pass, $user->password);
        if (!$ok) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'Password konfirmasi salah.')->with('info_type', 'danger');
        }

        // Unique checks
        $username = $request->input('username');
        $email = $request->input('email');
        $telp = $request->input('telp');

        if (Masyarakat::where('username', $username)->where('id_user', '!=', $id)->exists()) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'Username sudah digunakan.')->with('info_type', 'danger');
        }
        if ($email && Masyarakat::where('email', $email)->where('id_user', '!=', $id)->exists()) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'Email sudah digunakan.')->with('info_type', 'danger');
        }
        if (!preg_match('/^(?:\+62|08)[1-9][0-9]{7,11}$/', $telp)) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'Format nomor telepon tidak valid.')->with('info_type', 'danger');
        }

        $user->update(['nama_lengkap' => $request->input('nama_lengkap'), 'username' => $username, 'email' => $email ?: null, 'telp' => $telp]);
        session(['username' => $username]);

        return redirect()->route('masyarakat.profile')->with('info_profile', 'Profil berhasil diperbarui.')->with('info_type', 'success');
    }

    public function updatePassword(Request $request)
    {
        $user = Masyarakat::find(session('id_user'));
        $old = $request->input('old_password');
        $ok = Hash::check($old, $user->password);

        if (!$ok) {
            return redirect()->route('masyarakat.profile')->with('info_password', 'Password lama salah.')->with('info_type_pw', 'danger');
        }
        if ($request->input('new_password') !== $request->input('confirm_new_password')) {
            return redirect()->route('masyarakat.profile')->with('info_password', 'Konfirmasi password tidak cocok.')->with('info_type_pw', 'danger');
        }
        if (strlen($request->input('new_password')) < 6) {
            return redirect()->route('masyarakat.profile')->with('info_password', 'Password minimal 6 karakter.')->with('info_type_pw', 'danger');
        }

        $user->update(['password' => Hash::make($request->input('new_password'))]);
        return redirect()->route('masyarakat.profile')->with('info_password', 'Password berhasil diubah.')->with('info_type_pw', 'success');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:min_width=100,min_height=100,max_width=5000,max_height=5000',
        ]);

        $file = $request->file('foto');
        $user = Masyarakat::find(session('id_user'));
        if ($user->foto) {
            @unlink(storage_path('app/public/profile/' . $user->foto));
            @unlink(public_path('uploads/profile/' . $user->foto)); // fallback lama
        }

        $filename = \Illuminate\Support\Str::random(40) . '.' . $file->extension();
        $dir = storage_path('app/public/profile');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $file->move($dir, $filename);
        $user->update(['foto' => $filename]);

        return redirect()->route('masyarakat.profile')->with('info_profile', 'Foto profil berhasil diperbarui.')->with('info_type', 'success');
    }

    public function index()
    {
        $username = session('username');

        $rows = Lelang::with(['barang', 'barang.gambarUtama'])
            ->withMax('history', 'penawaran_harga')
            ->withCount('history')
            ->where('status', 'dibuka')
            ->orderByDesc('id_lelang')
            ->limit(5)
            ->get()
            ->map(function ($l) {
                $l->penawaran_tertinggi = $l->history_max_penawaran_harga;
                $l->jumlah_penawar     = $l->history_count;
                $l->foto               = $l->barang->gambarUtama?->nama_file;
                return $l;
            });

        $jumlah_penawaran = DB::table('history_lelang')
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->where('tb_masyarakat.username', $username)
            ->count();

        $jumlah_aktif = $rows->count();

        return view('masyarakat.index', compact('rows', 'jumlah_penawaran', 'jumlah_aktif'));
    }

    public function penawaran(Request $request)
    {
        $search    = $request->input('search', '');
        $harga_min = $request->input('harga_min');
        $harga_max = $request->input('harga_max');
        $kategori  = $request->input('kategori');

        $query = Lelang::with([
            'barang',
            'barang.gambar',
            'barang.gambarUtama',
            'barang.kategori',
            'barang.ratings.masyarakat',
            'petugas'
        ])
            ->withMax('history', 'penawaran_harga')
            ->withCount('history')
            ->where('status', 'dibuka')
            ->whereHas('barang', function ($q) use ($search, $harga_min, $harga_max, $kategori) {
                if ($search)    $q->where('nama_barang', 'like', "%{$search}%");
                if ($harga_min) $q->where('harga_awal', '>=', (int) $harga_min);
                if ($harga_max) $q->where('harga_awal', '<=', (int) $harga_max);
                if ($kategori)  $q->where('id_kategori', $kategori);
            })
            ->orderByDesc('id_lelang')
            ->get();

        // Load semua peserta per lelang dalam 1 query
        $idLelangList = $query->pluck('id_lelang')->all();
        $pesertaByLelang = DB::table('history_lelang')
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->whereIn('history_lelang.id_lelang', $idLelangList)
            ->select('history_lelang.id_lelang', 'tb_masyarakat.nama_lengkap', DB::raw('MAX(history_lelang.penawaran_harga) as penawaran_harga'))
            ->groupBy('history_lelang.id_lelang', 'history_lelang.id_user', 'tb_masyarakat.nama_lengkap')
            ->orderByDesc('penawaran_harga')
            ->get()
            ->groupBy('id_lelang');

        $query = $query->map(function ($l) use ($pesertaByLelang) {
            $l->penawaran_tertinggi = $l->history_max_penawaran_harga;
            $l->jumlah_penawar     = $l->history_count;
            $l->peserta            = $pesertaByLelang->get($l->id_lelang, collect());
            return $l;
        });

        $lelang_aktif = $query;
        $tb_kategori  = Cache::remember('kategori.all', 3600, fn() => \App\Models\Kategori::orderBy('nama_kategori')->get());
        $username     = session('username');
        $mas          = Masyarakat::where('username', $username)->first();

        // Get wishlist user untuk cek status favorit
        $id_user = session('id_user');
        $wishlist_ids = $id_user ? \App\Models\Wishlist::where('id_user', $id_user)->pluck('id_barang')->toArray() : [];

        $history = HistoryLelang::with(['barang', 'lelang', 'masyarakat'])
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->where('tb_masyarakat.username', $username)
            ->select('history_lelang.*')
            ->orderByDesc('id_history')
            ->paginate(10);

        return view('masyarakat.penawaran', compact('lelang_aktif', 'mas', 'history', 'tb_kategori', 'search', 'harga_min', 'harga_max', 'kategori', 'wishlist_ids'));
    }

    public function simpanPenawaran(Request $request)
    {
        $lelang = Lelang::with('barang')->where('id_lelang', $request->input('id_lelang'))->first();

        if (!$lelang || $lelang->status !== 'dibuka') {
            return redirect()->route('masyarakat.penawaran', ['info' => 'ditutup']);
        }
        if ($lelang->timer_end && now()->gt($lelang->timer_end)) {
            $this->lelangService->autoClose($lelang);
            return redirect()->route('masyarakat.penawaran', ['info' => 'ditutup']);
        }

        try {
            $this->lelangService->bid($lelang, (int) $request->input('id_user'), (int) $request->input('id_barang'), (int) $request->input('penawaran_harga'));
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('masyarakat.penawaran', ['info' => $e->getMessage()]);
        }

        return redirect()->route('masyarakat.penawaran', ['info' => 'simpan']);
    }

    public function updatePenawaran(Request $request)
    {
        $id_history    = $request->input('id_history');
        $penawaran_baru = (int) $request->input('penawaran_harga');

        $existing = HistoryLelang::findOrFail($id_history);
        
        // Ownership check
        if ($existing->id_user !== session('id_user')) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($existing) {
            $tertinggi = DB::table('history_lelang')
                ->where('id_lelang', $existing->id_lelang)
                ->where('id_history', '!=', $id_history)
                ->max('penawaran_harga');
            $lelang = Lelang::find($existing->id_lelang);
            $base   = $tertinggi ?? ($lelang?->barang?->harga_awal ?? 0);
            if ($penawaran_baru < $base + 1000) {
                return redirect()->route('masyarakat.penawaran', ['info' => 'min_bid']);
            }
            
            // Validate max bid (20x harga_awal)
            $max_bid = $lelang?->barang?->harga_awal * 20;
            if ($max_bid && $penawaran_baru > $max_bid) {
                return redirect()->route('masyarakat.penawaran', ['info' => 'max_bid'])
                    ->with('error_message', 'Penawaran tidak wajar!');
            }
        }

        HistoryLelang::where('id_history', $id_history)
            ->update(['penawaran_harga' => $penawaran_baru]);

        return redirect()->route('masyarakat.penawaran', ['info' => 'update']);
    }

    public function hapusPenawaran($id)
    {
        $history = HistoryLelang::findOrFail($id);
        
        // Ownership check
        if ($history->id_user !== session('id_user')) {
            abort(403, 'Unauthorized action.');
        }
        
        $history->delete();

        return redirect()->route('masyarakat.penawaran', ['info' => 'hapus']);
    }

    public function fakturPdf($id_lelang)
    {
        $lelang = Lelang::with(['barang', 'pemenang'])->findOrFail($id_lelang);

        // Petugas/admin boleh akses semua faktur
        $id_user    = session('id_user');
        $id_petugas = session('id_petugas');

        if (!$id_petugas) {
            // Hanya pemenang yang boleh akses
            if ($lelang->status !== 'ditutup' || (int)$lelang->id_user !== (int)$id_user) {
                abort(403, 'Anda bukan pemenang lelang ini.');
            }
        }

        $nomor_faktur = $lelang->nomor_faktur
            ?? 'LXB-' . strtoupper(substr(md5($id_lelang . $lelang->id_user), 0, 8));

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('shared.faktur_pdf', [
            'lelang'       => $lelang,
            'pemenang'     => $lelang->pemenang,
            'barang'       => $lelang->barang,
            'nomor_faktur' => $nomor_faktur,
            'tgl_cetak'    => now()->timezone('Asia/Jakarta')->format('d/m/Y H:i'),
        ])->setPaper('a4', 'portrait');

        $filename = 'faktur_' . $nomor_faktur . '.pdf';
        return $pdf->download($filename);
    }
}
