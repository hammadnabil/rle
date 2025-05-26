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

    public function autocomplete(Request $request)
{
    if ($request->has('q')) {
        $search = $request->q;

        $users = User::select('id', 'name as text')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    return response()->json([]);
}




}
