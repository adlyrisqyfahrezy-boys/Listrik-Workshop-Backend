<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::orderBy('id')->get());
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate(['is_active' => 'required|boolean']);

        if ($request->user()->id === $user->id && ! $data['is_active']) {
            return response()->json(['message' => 'Tidak bisa menonaktifkan akun sendiri'], 422);
        }

        $user->update($data);

        return response()->json($user);
    }
}