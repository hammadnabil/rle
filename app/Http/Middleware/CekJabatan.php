<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekJabatan
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        if (Auth::user()->jabatan !== $role) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
