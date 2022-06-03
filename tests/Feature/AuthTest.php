<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checks that token is returns when send valid users credentials
     *
     * @return void
     */
    public function test_login_auth_valid_credentials() {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => '12345',
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * Checks that token is missing when send invalid user credentials
     * @return void
     */
    public function test_login_auth_invalid_credentials() {
        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => "invaliduser@gmail.com",
            'password' => '12345',
        ]);
        $response->assertStatus(401);
    }

    /**
     * Checks logs the user out with Bearer token
     *
     * @return void
     */
    public function test_logout_auth() {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['email' => $user->email]);

        $response = $this->json('POST', '/api/v1/auth/login', [
            'email' => $user->email,
            'password' => '12345',
        ]);
        $response->assertJsonStructure(['access_token']);

        $content = json_decode($response->getContent());
        $response = $this->withHeader('Authorization', "Bearer {$content->access_token}")->json('POST', '/api/v1/auth/logout', [
            'email' => $user->email
        ]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }
}
