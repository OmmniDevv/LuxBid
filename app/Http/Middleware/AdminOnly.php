<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('id_level') != 1) {
            return redirect()->route('administrator.index');
        }
        return $next($request);
    }
}
