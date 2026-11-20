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
        public function destroy(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json(['message' => 'Tidak bisa menghapus akun sendiri'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'Akun berhasil dihapus']);
    }
        public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role'     => 'sometimes|in:admin,user',
        ]);

        $user = User::create($data);

        return response()->json($user, 201);
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