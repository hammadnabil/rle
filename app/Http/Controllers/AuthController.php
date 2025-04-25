<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        if ($role === 'pegawai') {
            if (Auth::guard('pegawai')->attempt($credentials)) {
                return redirect()->intended('/pegawai/dashboard');
            }
        }

        if ($role === 'atasan') {
            if (Auth::guard('atasan')->attempt($credentials)) {
                return redirect()->intended('/atasan/dashboard');
            }
        }

        return back()->withErrors(['login' => 'Email atau password salah untuk role yang dipilih.']);
    }

    public function logout(Request $request)
{
    if (Auth::guard('pegawai')->check()) {
        Auth::guard('pegawai')->logout();
    } elseif (Auth::guard('atasan')->check()) {
        Auth::guard('atasan')->logout();
    }

    return redirect()->route('login');
}

}

