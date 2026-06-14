<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $petugas = Petugas::where('username', $username)->first();

        if ($petugas && Hash::check($password, $petugas->password)) {
            $request->session()->regenerate();
            session([
                'id_petugas' => $petugas->id_petugas,
                'username'   => $username,
                'id_level'   => $petugas->id_level,
            ]);

            if ($petugas->id_level == 1) {
                return redirect()->route('administrator.index');
            }
            return redirect()->route('petugas.index');
        }

        return redirect()->route('login.petugas', ['info' => 'gagal']);
    }

    public function logout()
    {
        session()->forget(['id_petugas', 'username', 'id_level']);
        return redirect()->route('login.petugas', ['info' => 'logout']);
    }
}
