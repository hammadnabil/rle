<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function profil()
{
    $user = Auth::user();
    return view('pegawai.profil', compact('user'));
}

}
