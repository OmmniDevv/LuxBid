<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('id_level') != 1) {
            abort(403, 'Akses ditolak. Hanya administrator yang diizinkan.');
        }
        return $next($request);
    }
}
