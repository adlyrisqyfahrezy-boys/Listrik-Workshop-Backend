<?php

namespace Tests\Feature;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JwtApiProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_protected_resources_reject_requests_without_token(): void
    {
        foreach (['lokasi', 'ruang', 'perangkat', 'meteran'] as $resource) {
            $this->getJson("/{$resource}")
                ->assertUnauthorized()
                ->assertJson(['message' => 'Token tidak ada']);
        }
    }

    public function test_protected_resources_reject_invalid_and_expired_tokens(): void
    {
        $user = User::factory()->create();

        $this->getJson('/lokasi', $this->bearer('invalid.token.value'))
            ->assertUnauthorized()
            ->assertJson(['message' => 'Token tidak valid atau kedaluwarsa']);

        $this->getJson('/lokasi', $this->bearer($this->tokenFor($user, time() - 1)))
            ->assertUnauthorized()
            ->assertJson(['message' => 'Token tidak valid atau kedaluwarsa']);
    }

    public function test_protected_resources_are_accessible_with_valid_token(): void
    {
        $user = User::factory()->create();
        $headers = $this->bearer($this->tokenFor($user));

        foreach (['lokasi', 'ruang', 'perangkat', 'meteran'] as $resource) {
            $this->getJson("/{$resource}", $headers)
                ->assertOk("GET /{$resource} dengan token valid harus menghasilkan 200");
        }
    }

    public function test_login_remains_accessible_without_jwt(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $this->postJson('/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ])->assertOk()->assertJsonStructure(['access_token', 'token_type', 'user']);
    }

    public function test_register_remains_accessible_without_jwt(): void
    {
        $this->postJson('/register', [
            'name' => 'User Baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertCreated()->assertJsonStructure(['access_token', 'token_type', 'user']);
    }

    public function test_me_route_uses_registered_jwt_alias(): void
    {
        $user = User::factory()->create();

        $this->getJson('/me', $this->bearer($this->tokenFor($user)))
            ->assertOk()
            ->assertJsonPath('id', $user->id);
    }

    private function tokenFor(User $user, ?int $expiresAt = null): string
    {
        $payload = [
            'iss' => config('app.url'),
            'sub' => $user->id,
            'iat' => time(),
            'exp' => $expiresAt ?? time() + 60 * 60,
        ];

        return JWT::encode($payload, config('app.jwt_secret'), 'HS256');
    }

    /**
     * @return array<string, string>
     */
    private function bearer(string $token): array
    {
        return ['Authorization' => "Bearer {$token}"];
    }
}
