<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    public function test_can_get_users_list()
    {
        $auth = $this->authenticateUser();

        User::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->getJson('/api/v1/users');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'phone',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'pagination' => [
                        'current_page',
                        'last_page',
                        'per_page',
                        'total'
                    ]
                ]);
    }

    public function test_can_create_user_with_valid_data()
    {
        $auth = $this->authenticateUser();

        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1234567891',
            'password' => 'password123'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/users', $userData);

        $response->assertStatus(201)
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

        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1234567891'
        ]);
    }

    public function test_cannot_create_user_with_existing_email()
    {
        $auth = $this->authenticateUser();

        User::factory()->create(['email' => 'jane@example.com']);

        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1234567891',
            'password' => 'password123'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/users', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_cannot_create_user_with_existing_phone()
    {
        $auth = $this->authenticateUser();

        User::factory()->create(['phone' => '+1234567891']);

        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+1234567891',
            'password' => 'password123'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/users', $userData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['phone']);
    }

    public function test_can_get_specific_user()
    {
        $auth = $this->authenticateUser();

        $targetUser = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->getJson("/api/v1/users/{$targetUser->id}");

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

    public function test_cannot_get_nonexistent_user()
    {
        $auth = $this->authenticateUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->getJson('/api/v1/users/999');

        $response->assertStatus(404);
    }

    public function test_can_update_user_with_valid_data()
    {
        $auth = $this->authenticateUser();

        $targetUser = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '+1234567892'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->putJson("/api/v1/users/{$targetUser->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User updated successfully'
                ])
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '+1234567892'
        ]);
    }

    public function test_cannot_update_user_with_existing_email()
    {
        $auth = $this->authenticateUser();

        $targetUser = User::factory()->create();
        $existingUser = User::factory()->create(['email' => 'existing@example.com']);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'existing@example.com',
            'phone' => '+1234567892'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->putJson("/api/v1/users/{$targetUser->id}", $updateData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_can_delete_user()
    {
        $auth = $this->authenticateUser();

        $targetUser = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->deleteJson("/api/v1/users/{$targetUser->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ]);

        $this->assertDatabaseMissing('users', [
            'id' => $targetUser->id
        ]);
    }

    public function test_cannot_delete_nonexistent_user()
    {
        $auth = $this->authenticateUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->deleteJson('/api/v1/users/999');

        $response->assertStatus(404);
    }

    public function test_unauthenticated_user_cannot_access_user_endpoints()
    {
        // Test index
        $response = $this->getJson('/api/v1/users');
        $response->assertStatus(401);

        // Test store
        $response = $this->postJson('/api/v1/users', []);
        $response->assertStatus(401);

        // Test show
        $response = $this->getJson('/api/v1/users/1');
        $response->assertStatus(401);

        // Test update
        $response = $this->putJson('/api/v1/users/1', []);
        $response->assertStatus(401);

        // Test delete
        $response = $this->deleteJson('/api/v1/users/1');
        $response->assertStatus(401);
    }
}
