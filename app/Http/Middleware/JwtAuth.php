<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (! $token) {
            return response()->json(['message' => 'Token tidak ada'], 401);
        }

        try {
            $payload = JWT::decode($token, new Key(config('app.jwt_secret'), 'HS256'));
            $user = User::find($payload->sub);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Token tidak valid atau kedaluwarsa'], 401);
        }

        if (! $user) {
            return response()->json(['message' => 'User tidak ditemukan'], 401);
        }

        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
