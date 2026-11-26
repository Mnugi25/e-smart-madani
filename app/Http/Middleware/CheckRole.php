<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user login dan memiliki role yang sesuai
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        // Jika akses ditolak
        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }
}
