<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private function makeToken(User $user): string
    {
        $payload = [
            'iss' => config('app.url'),
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ];
        return JWT::encode($payload, config('app.jwt_secret'), 'HS256');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create($data);

        return response()->json([
            'access_token' => $this->makeToken($user),
            'token_type'   => 'bearer',
            'user'         => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        if (! $user->is_active) {
            return response()->json(['message' => 'Akun dinonaktifkan'], 403);
        }

        return response()->json([
            'access_token' => $this->makeToken($user),
            'token_type'   => 'bearer',
            'user'         => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function refresh(Request $request)
    {
        return response()->json([
            'access_token' => $this->makeToken($request->user()),
            'token_type'   => 'bearer',
            'user'         => $request->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'Password lama salah'], 422);
        }

        $user->update(['password' => $data['password']]);

        return response()->json(['message' => 'Password berhasil diubah']);
    }
}