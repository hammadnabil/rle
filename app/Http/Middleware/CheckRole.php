<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Mengecek apakah pengguna memiliki role yang sesuai
        if (Auth::check() && Auth::user()->jabatan === $role) {
            return $next($request);
        }

        // Jika tidak sesuai, redirect ke halaman login atau halaman lain
        return redirect()->route('login');
    }
}
