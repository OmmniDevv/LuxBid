<?php

namespace App\Http\Middleware;

use App\Models\Masyarakat;
use Closure;
use Illuminate\Http\Request;

class MasyarakatAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (session('status') !== 'login') {
            return redirect()->route('login.masyarakat', ['info' => 'login']);
        }

        $user = Masyarakat::find(session('id_user'));
        if ($user && $user->email && !$user->email_verified_at) {
            session()->forget(['id_user', 'username', 'status']);
            return redirect()->route('login.masyarakat', ['info' => 'belum_verif']);
        }

        return $next($request);
    }
}
