<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
        if ($user) {
            $stored = $user->password;
            if (str_starts_with($stored, '$2y$')) {
                if (password_verify($password_raw, $stored)) {
                    $login_ok = true;
                }
            } else {
                // Legacy md5
                if ($stored === md5($password_raw)) {
                    $login_ok = true;
                }
            }
        }

        if ($login_ok) {
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

        Masyarakat::create([
            'nama_lengkap' => $request->input('nama_lengkap'),
            'username'     => $username,
            'password'     => md5($request->input('password')),
            'telp'         => $telp,
        ]);

        return redirect()->route('login.masyarakat', ['info' => 'daftar']);
    }

    public function showLupaPassword()
    {
        return view('auth.lupa_password');
    }

    public function lupaPasswordStep1(Request $request)
    {
        $username = trim($request->input('username'));
        $telp = trim($request->input('telp'));

        $user = Masyarakat::where('username', $username)->where('telp', $telp)->first();
        if ($user) {
            return view('auth.lupa_password', ['step' => 2, 'found_user' => $user]);
        }

        return view('auth.lupa_password', [
            'step' => 1,
            'msg' => 'Username atau nomor telepon tidak ditemukan. Periksa kembali data Anda.',
            'msg_type' => 'warn',
        ]);
    }

    public function lupaPasswordStep2(Request $request)
    {
        $username = trim($request->input('username_hidden'));
        $newpwd = $request->input('new_password');
        $confpwd = $request->input('confirm_password');

        $user = Masyarakat::where('username', $username)->first();

        if (strlen($newpwd) < 6) {
            return view('auth.lupa_password', ['step' => 2, 'found_user' => $user, 'msg' => 'Password minimal 6 karakter.', 'msg_type' => 'warn']);
        }
        if ($newpwd !== $confpwd) {
            return view('auth.lupa_password', ['step' => 2, 'found_user' => $user, 'msg' => 'Konfirmasi password tidak cocok.', 'msg_type' => 'warn']);
        }

        $user->password = password_hash($newpwd, PASSWORD_DEFAULT);
        $user->save();

        return view('auth.lupa_password', ['step' => 3]);
    }

    public function logout()
    {
        session()->forget(['id_user', 'username', 'status']);
        Cookie::queue(Cookie::forget('lelang'));
        return redirect()->route('home', ['info' => 'logout']);
    }
}
