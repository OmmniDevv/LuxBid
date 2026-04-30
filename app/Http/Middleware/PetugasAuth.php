<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PetugasAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('id_level')) {
            return redirect()->route('login.petugas', ['info' => 'login']);
        }
        return $next($request);
    }
}
