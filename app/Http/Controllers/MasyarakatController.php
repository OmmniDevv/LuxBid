<?php

namespace App\Http\Controllers;

use App\Models\Lelang;
use App\Models\Masyarakat;
use App\Models\HistoryLelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasyarakatController extends Controller
{
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
        $stored = $user->password;
        $pass = $request->input('confirm_password');
        $ok = str_starts_with($stored, '$2y$') ? Hash::check($pass, $stored) : ($stored === md5($pass));
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
        $stored = $user->password;
        $old = $request->input('old_password');
        $ok = str_starts_with($stored, '$2y$') ? Hash::check($old, $stored) : ($stored === md5($old));

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
        if (!$request->hasFile('foto') || !$request->file('foto')->isValid()) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'File tidak valid.')->with('info_type', 'danger');
        }
        $file = $request->file('foto');
        if (!in_array($file->getMimeType(), ['image/jpeg','image/png','image/webp','image/gif'])) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'File harus berupa gambar.')->with('info_type', 'danger');
        }
        if ($file->getSize() > 2 * 1024 * 1024) {
            return redirect()->route('masyarakat.profile')->with('info_profile', 'Ukuran file maksimal 2MB.')->with('info_type', 'danger');
        }

        $user = Masyarakat::find(session('id_user'));
        if ($user->foto) @unlink(public_path('uploads/profile/'.$user->foto));

        $filename = 'profile_'.session('id_user').'_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $filename);
        $user->update(['foto' => $filename]);

        return redirect()->route('masyarakat.profile')->with('info_profile', 'Foto profil berhasil diperbarui.')->with('info_type', 'success');
    }

    public function index()
    {
        $username = session('username');

        $rows = Lelang::with(['barang', 'barang.gambarUtama'])
            ->where('status', 'dibuka')
            ->orderByDesc('id_lelang')
            ->limit(5)
            ->get()
            ->map(function ($l) {
                $l->penawaran_tertinggi = DB::table('history_lelang')->where('id_lelang', $l->id_lelang)->max('penawaran_harga');
                $l->jumlah_penawar = DB::table('history_lelang')->where('id_lelang', $l->id_lelang)->count();
                $l->foto = $l->barang->gambarUtama?->nama_file;
                return $l;
            });

        $jumlah_penawaran = DB::table('history_lelang')
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->where('tb_masyarakat.username', $username)
            ->count();

        $jumlah_aktif = $rows->count();

        return view('masyarakat.index', compact('rows', 'jumlah_penawaran', 'jumlah_aktif'));
    }

    public function penawaran()
    {
        $lelang_aktif = Lelang::with(['barang', 'barang.gambar', 'barang.gambarUtama', 'petugas'])
            ->where('status', 'dibuka')
            ->orderByDesc('id_lelang')
            ->get()
            ->map(function ($l) {
                $l->penawaran_tertinggi = DB::table('history_lelang')->where('id_lelang', $l->id_lelang)->max('penawaran_harga');
                $l->jumlah_penawar = DB::table('history_lelang')->where('id_lelang', $l->id_lelang)->count();
                $l->peserta = DB::table('history_lelang')
                    ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
                    ->where('history_lelang.id_lelang', $l->id_lelang)
                    ->select('tb_masyarakat.nama_lengkap', DB::raw('MAX(history_lelang.penawaran_harga) as penawaran_harga'))
                    ->groupBy('history_lelang.id_user', 'tb_masyarakat.nama_lengkap')
                    ->orderByDesc('penawaran_harga')
                    ->get();
                return $l;
            });

        $username = session('username');
        $mas = Masyarakat::where('username', $username)->first();

        $history = HistoryLelang::with(['barang', 'lelang', 'masyarakat'])
            ->join('tb_masyarakat', 'history_lelang.id_user', '=', 'tb_masyarakat.id_user')
            ->where('tb_masyarakat.username', $username)
            ->select('history_lelang.*')
            ->orderByDesc('id_history')
            ->get();

        return view('masyarakat.penawaran', compact('lelang_aktif', 'mas', 'history'));
    }

    public function simpanPenawaran(Request $request)
    {
        $lelang = Lelang::where('id_lelang', $request->input('id_lelang'))->first();

        // Backend guard: reject if closed or timer expired
        if (!$lelang || $lelang->status !== 'dibuka') {
            return redirect()->route('masyarakat.penawaran', ['info' => 'ditutup']);
        }
        if ($lelang->timer_end && now()->gt($lelang->timer_end)) {
            // Auto-close it now
            $top = DB::table('history_lelang')
                ->where('id_lelang', $lelang->id_lelang)->orderByDesc('penawaran_harga')->first();
            $lelang->update([
                'status'      => 'ditutup',
                'harga_akhir' => $top ? $top->penawaran_harga : 0,
                'id_user'     => $top ? $top->id_user : 0,
            ]);
            return redirect()->route('masyarakat.penawaran', ['info' => 'ditutup']);
        }

        $penawaran_baru = (int) $request->input('penawaran_harga');
        $tertinggi = DB::table('history_lelang')->where('id_lelang', $lelang->id_lelang)->max('penawaran_harga') ?? $lelang->barang->harga_awal;
        if ($penawaran_baru < $tertinggi + 1000) {
            return redirect()->route('masyarakat.penawaran', ['info' => 'min_bid']);
        }

        HistoryLelang::create([
            'id_lelang'       => $request->input('id_lelang'),
            'id_barang'       => $request->input('id_barang'),
            'id_user'         => $request->input('id_user'),
            'penawaran_harga' => $penawaran_baru,
        ]);
        // Reset timer on new bid
        $lelang->update(['timer_end' => now()->addMinutes(6)]);

        return redirect()->route('masyarakat.penawaran', ['info' => 'simpan']);
    }

    public function updatePenawaran(Request $request)
    {
        $id_history    = $request->input('id_history');
        $penawaran_baru = (int) $request->input('penawaran_harga');

        $existing = HistoryLelang::find($id_history);
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
        }

        HistoryLelang::where('id_history', $id_history)
            ->update(['penawaran_harga' => $penawaran_baru]);

        return redirect()->route('masyarakat.penawaran', ['info' => 'update']);
    }

    public function hapusPenawaran(Request $request)
    {
        HistoryLelang::where('id_history', $request->input('id_history'))->delete();

        return redirect()->route('masyarakat.penawaran', ['info' => 'hapus']);
    }

    public function fakturPdf($id_lelang)
    {
        $id_user = session('id_user');

        $lelang = Lelang::with(['barang', 'pemenang'])->findOrFail($id_lelang);

        // Hanya pemenang yang boleh akses
        if ($lelang->status !== 'ditutup' || (int)$lelang->id_user !== (int)$id_user) {
            abort(403, 'Anda bukan pemenang lelang ini.');
        }

        $nomor_faktur = 'LXB-' . strtoupper(substr(md5($id_lelang . $id_user), 0, 8));

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
