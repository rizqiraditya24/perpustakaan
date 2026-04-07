<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'siswa') {
            return $next($request);
        }

        abort(403, 'Akses ditolak.');
    }
}
