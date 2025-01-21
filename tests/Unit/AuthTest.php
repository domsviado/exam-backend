<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function it_can_login_with_valid_credentials()
    // {
    //     $user = User::factory()->create([
    //         'email' => 'test@example.com',
    //         'password' => Hash::make('password'),
    //     ]);

    //     $response = $this->postJson('/api/auth/login', [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ]);
    //     $response->assertStatus(200)
    //         ->assertJsonStructure([
    //             'success',
    //             'message',
    //             'data' => [
    //                 'token',
    //             ],
    //         ]);
    // }

    /** @test */
    public function it_returns_error_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    /** @test */
    public function it_returns_error_when_email_is_missing()
    {
        $response = $this->postJson('/api/auth/login', [
            'password' => 'password123',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_returns_error_when_password_is_missing()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
}
