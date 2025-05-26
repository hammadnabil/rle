<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AtasanController extends Controller
{
    public function listUser()
{
    $users = User::orderBy('name')->get();
    return view('atasan.user.index', compact('users'));
}

public function detailUser(User $user)
{
    return view('atasan.user.detail', compact('user'));
}
}
