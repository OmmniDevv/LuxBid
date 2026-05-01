<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

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
            'email'        => $request->input('email') ?: null,
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
        if (!$user) {
            return view('auth.lupa_password', [
                'step'     => 1,
                'msg'      => 'Username atau nomor telepon tidak ditemukan. Periksa kembali data Anda.',
                'msg_type' => 'warn',
            ]);
        }

        $newPassword = $this->generatePassword();
        $user->password = password_hash($newPassword, PASSWORD_DEFAULT);
        $user->save();

        return view('auth.lupa_password', ['step' => 3, 'new_password' => $newPassword]);
    }

    private function generatePassword(): string
    {
        $upper   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower   = 'abcdefghijklmnopqrstuvwxyz';
        $digits  = '0123456789';
        $symbols = '!@#$%^&*';
        $all     = $upper . $lower . $digits . $symbols;

        // Pastikan minimal 1 dari tiap kategori
        $pwd  = $upper[random_int(0, strlen($upper) - 1)];
        $pwd .= $lower[random_int(0, strlen($lower) - 1)];
        $pwd .= $digits[random_int(0, strlen($digits) - 1)];
        $pwd .= $symbols[random_int(0, strlen($symbols) - 1)];

        for ($i = 4; $i < 12; $i++) {
            $pwd .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($pwd);
    }

    public function logout()
    {
        session()->forget(['id_user', 'username', 'status']);
        Cookie::queue(Cookie::forget('lelang'));
        return redirect()->route('home', ['info' => 'logout']);
    }
}
