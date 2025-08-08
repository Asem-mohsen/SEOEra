<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    public function test_user_can_register_with_valid_data()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'User registered successfully'
                ])
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'user' => [
                            'id',
                            'name',
                            'email',
                            'phone',
                            'created_at',
                            'updated_at'
                        ],
                        'token'
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890'
        ]);
    }

    public function test_user_cannot_register_with_invalid_email()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'phone' => '+1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_register_with_existing_email()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_user_cannot_register_with_existing_phone()
    {
        User::factory()->create(['phone' => '+1234567890']);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['phone']);
    }

    public function test_user_cannot_register_with_mismatched_passwords()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword'
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['password']);
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'phone' => '+1234567890',
            'password' => Hash::make('password123')
        ]);

        $loginData = [
            'phone' => '+1234567890',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/v1/login', $loginData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Login successful'
                ])
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'user' => [
                            'id',
                            'name',
                            'email',
                            'phone',
                            'created_at',
                            'updated_at'
                        ],
                        'token'
                    ]
                ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'phone' => '+1234567890',
            'password' => Hash::make('password123')
        ]);

        $loginData = [
            'phone' => '+1234567890',
            'password' => 'wrongpassword'
        ];

        $response = $this->postJson('/api/v1/login', $loginData);

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false
                ]);
    }

    public function test_user_cannot_login_with_nonexistent_phone()
    {
        $loginData = [
            'phone' => '+9999999999',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/v1/login', $loginData);

        $response->assertStatus(401)
                ->assertJson([
                    'success' => false
                ]);
    }

    public function test_authenticated_user_can_get_profile()
    {
        $auth = $this->authenticateUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->getJson('/api/v1/me');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    public function test_unauthenticated_user_cannot_get_profile()
    {
        $response = $this->getJson('/api/v1/me');

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_logout()
    {
        $auth = $this->authenticateUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/logout');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Logged out successfully'
                ]);
    }

    public function test_unauthenticated_user_cannot_logout()
    {
        $response = $this->postJson('/api/v1/logout');

        $response->assertStatus(401);
    }
}
