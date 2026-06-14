<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationMail;
use App\Mail\ResetCodeMail;
use App\Mail\WelcomeMail;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MasyarakatAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login_masyarakat');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password_raw = $request->input('password');

        $user = Masyarakat::where('username', $username)->first();

        $login_ok = false;
        if ($user && Hash::check($password_raw, $user->password)) {
            $login_ok = true;
        }

        if ($login_ok) {
            $request->session()->regenerate();
            session([
                'id_user'  => $user->id_user,
                'username' => $username,
                'status'   => 'login',
            ]);
            Cookie::queue('lelang', $username, 60 * 24 * 30);
            return redirect()->route('masyarakat.index');
        }

        return redirect()->route('login.masyarakat', ['info' => 'gagal']);
    }

    public function showRegister()
    {
        return view('auth.daftar_masyarakat');
    }

    public function register(Request $request)
    {
        $telp = $request->input('telp');
        if (!preg_match('/^(?:\+62|08)[1-9][0-9]{7,11}$/', $telp)) {
            return redirect()->route('daftar.masyarakat', ['info' => 'telp_invalid']);
        }

        $username = $request->input('username');
        if (Masyarakat::where('username', $username)->exists()) {
            return redirect()->route('daftar.masyarakat', ['info' => 'username_exists']);
        }

        $email = $request->input('email') ?: null;

        // Email wajib diisi untuk verifikasi
        if (!$email) {
            return redirect()->route('daftar.masyarakat', ['info' => 'email_required']);
        }

        if (Masyarakat::where('email', $email)->exists()) {
            return redirect()->route('daftar.masyarakat', ['info' => 'email_exists']);
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user = Masyarakat::create([
            'nama_lengkap'            => $request->input('nama_lengkap'),
            'username'                => $username,
            'password'                => Hash::make($request->input('password')),
            'telp'                    => $telp,
            'email'                   => $email,
            'email_verification_code' => $code,
        ]);

        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user->nama_lengkap, $code));
        } catch (\Exception) {}

        session([
            'verif_id_user'    => $user->id_user,
            'verif_email_hint' => substr($email, 0, 3) . '***@' . explode('@', $email)[1],
        ]);

        return redirect()->route('daftar.verifikasi');
    }

    public function showVerifikasiDaftar()
    {
        if (!session('verif_id_user')) return redirect()->route('daftar.masyarakat');
        return view('auth.verifikasi_email');
    }

    public function prosesVerifikasiDaftar(Request $request)
    {
        $id_user = session('verif_id_user');
        if (!$id_user) return redirect()->route('daftar.masyarakat');

        $user = Masyarakat::find($id_user);
        if (!$user) return redirect()->route('daftar.masyarakat');

        if (trim($request->input('kode')) !== $user->email_verification_code) {
            return back()->with('error', 'Kode verifikasi salah.');
        }

        $user->update([
            'email_verified_at'       => now(),
            'email_verification_code' => null,
        ]);

        session()->forget(['verif_id_user', 'verif_email_hint']);

        try {
            Mail::to($user->email)->send(new WelcomeMail($user->nama_lengkap));
        } catch (\Exception) {}

        return redirect()->route('login.masyarakat', ['info' => 'daftar']);
    }

    public function kirimUlangVerifikasiDaftar()
    {
        $id_user = session('verif_id_user');
        if (!$id_user) return redirect()->route('daftar.masyarakat');

        $user = Masyarakat::find($id_user);
        if (!$user) return redirect()->route('daftar.masyarakat');

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update(['email_verification_code' => $code]);

        try {
            Mail::to($user->email)->send(new EmailVerificationMail($user->nama_lengkap, $code));
        } catch (\Exception) {}

        return back()->with('info', 'Kode baru telah dikirim ke email Anda.');
    }

    public function showLupaPassword()
    {
        return view('auth.lupa_password');
    }

    public function lupaPasswordStep1(Request $request)
    {
        $user = Masyarakat::where('username', trim($request->input('username')))
                          ->where('email', trim($request->input('email')))
                          ->first();

        if (!$user || !$user->email) {
            return back()->with('error', 'Username dan email tidak cocok.');
        }

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        session([
            'reset_code'            => $code,
            'reset_code_expiry'     => now()->addMinutes(10)->timestamp,
            'reset_id_user'         => $user->id_user,
            'reset_email_hint'      => substr($user->email, 0, 3) . '***@' . explode('@', $user->email)[1],
        ]);

        try {
            Mail::to($user->email)->send(new ResetCodeMail($user->nama_lengkap, $code));
        } catch (\Exception) {}

        return redirect()->route('lupa.password.verifikasi');
    }

    public function showVerifikasi()
    {
        if (!session('reset_code')) return redirect()->route('lupa.password');
        return view('auth.lupa_verifikasi');
    }

    public function prosesVerifikasi(Request $request)
    {
        $input   = trim($request->input('kode'));
        $code    = session('reset_code');
        $expiry  = session('reset_code_expiry');

        if (!$code || !$expiry || $input !== $code || now()->timestamp > $expiry) {
            return back()->with('error', 'Kode verifikasi salah atau sudah expired.');
        }

        session()->forget(['reset_code', 'reset_code_expiry']);
        session(['reset_verified' => true]);

        return redirect()->route('lupa.password.selesai');
    }

    public function kirimUlang(Request $request)
    {
        $id_user = session('reset_id_user');
        if (!$id_user) return redirect()->route('lupa.password');

        $user = Masyarakat::find($id_user);
        if (!$user || !$user->email) return redirect()->route('lupa.password');

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        session(['reset_code' => $code, 'reset_code_expiry' => now()->addMinutes(10)->timestamp]);

        try {
            Mail::to($user->email)->send(new ResetCodeMail($user->nama_lengkap, $code));
        } catch (\Exception) {}

        return back()->with('info', 'Kode baru telah dikirim ke email Anda.');
    }

    public function selesai()
    {
        if (!session('reset_verified')) return redirect()->route('lupa.password');

        $user = Masyarakat::find(session('reset_id_user'));
        if (!$user) return redirect()->route('lupa.password');

        $chars    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ($i = 0; $i < 8; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }

        $user->update(['password' => Hash::make($password)]);
        session()->forget(['reset_verified', 'reset_id_user', 'reset_email_hint']);

        return view('auth.lupa_selesai', ['password' => $password]);
    }

    public function logout()
    {
        session()->forget(['id_user', 'username', 'status']);
        Cookie::queue(Cookie::forget('lelang'));
        return redirect()->route('home', ['info' => 'logout']);
    }
}
