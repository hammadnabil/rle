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

<<<<<<< HEAD

=======
>>>>>>> 8a2b179eec3fa9275020975fde913fad522605c5
}
