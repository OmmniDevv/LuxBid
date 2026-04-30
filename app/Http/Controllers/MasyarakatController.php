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

        $user->update(['password' => password_hash($request->input('new_password'), PASSWORD_DEFAULT)]);
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
            $top = \Illuminate\Support\Facades\DB::table('history_lelang')
                ->where('id_lelang', $lelang->id_lelang)->orderByDesc('penawaran_harga')->first();
            $lelang->update([
                'status'      => 'ditutup',
                'harga_akhir' => $top ? $top->penawaran_harga : 0,
                'id_user'     => $top ? $top->id_user : 0,
            ]);
            return redirect()->route('masyarakat.penawaran', ['info' => 'ditutup']);
        }

        HistoryLelang::create([
            'id_lelang'       => $request->input('id_lelang'),
            'id_barang'       => $request->input('id_barang'),
            'id_user'         => $request->input('id_user'),
            'penawaran_harga' => $request->input('penawaran_harga'),
        ]);
        // Reset timer on new bid
        $lelang->update(['timer_end' => now()->addMinutes(6)]);

        return redirect()->route('masyarakat.penawaran', ['info' => 'simpan']);
    }

    public function updatePenawaran(Request $request)
    {
        HistoryLelang::where('id_history', $request->input('id_history'))
            ->update(['penawaran_harga' => $request->input('penawaran_harga')]);

        return redirect()->route('masyarakat.penawaran', ['info' => 'update']);
    }

    public function hapusPenawaran(Request $request)
    {
        HistoryLelang::where('id_history', $request->input('id_history'))->delete();

        return redirect()->route('masyarakat.penawaran', ['info' => 'hapus']);
    }
}
