<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MasyarakatAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (session('status') !== 'login') {
            return redirect()->route('login.masyarakat', ['info' => 'login']);
        }
        return $next($request);
    }
}
