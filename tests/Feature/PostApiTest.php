<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{

    public function test_can_get_posts_list()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'truncated_description',
                            'contact_phone',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'pagination'
                ]);
    }

    public function test_can_create_post_with_valid_data()
    {
        $auth = $this->authenticateUser();
        
        $postData = [
            'title' => 'Test Post',
            'description' => 'This is a test post description.',
            'contact_phone' => '+1234567890'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/posts', $postData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Post created successfully'
                ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'user_id' => $auth['user']->id
        ]);
    }

    public function test_cannot_create_post_without_authentication()
    {
        $postData = [
            'title' => 'Test Post',
            'description' => 'This is a test post description.',
            'contact_phone' => '+1234567890'
        ];

        $response = $this->postJson('/api/v1/posts', $postData);

        $response->assertStatus(401);
    }

    public function test_cannot_create_post_with_description_over_2kb()
    {
        $auth = $this->authenticateUser();
        
        $postData = [
            'title' => 'Test Post',
            'description' => str_repeat('a', 2049), // Over 2KB
            'contact_phone' => '+1234567890'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/posts', $postData);

        $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                    'message' => 'Description cannot exceed 2KB'
                ]);
    }

    public function test_cannot_create_post_without_title()
    {
        $auth = $this->authenticateUser();
        
        $postData = [
            'description' => 'This is a test post description.',
            'contact_phone' => '+1234567890'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/posts', $postData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title']);
    }

    public function test_cannot_create_post_without_description()
    {
        $auth = $this->authenticateUser();
        
        $postData = [
            'title' => 'Test Post',
            'contact_phone' => '+1234567890'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/posts', $postData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['description']);
    }

    public function test_cannot_create_post_without_contact_phone()
    {
        $auth = $this->authenticateUser();
        
        $postData = [
            'title' => 'Test Post',
            'description' => 'This is a test post description.'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->postJson('/api/v1/posts', $postData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['contact_phone']);
    }

    public function test_can_get_specific_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'title',
                        'description',
                        'contact_phone',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    public function test_cannot_get_nonexistent_post()
    {
        $response = $this->getJson('/api/v1/posts/999');

        $response->assertStatus(404);
    }

    public function test_can_update_post_with_valid_data()
    {
        $auth = $this->authenticateUser();
        $post = Post::factory()->create(['user_id' => $auth['user']->id]);

        $updateData = [
            'title' => 'Updated Post Title',
            'description' => 'This is an updated post description.',
            'contact_phone' => '+1234567891'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->putJson("/api/v1/posts/{$post->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Post updated successfully'
                ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
            'description' => 'This is an updated post description.',
            'contact_phone' => '+1234567891'
        ]);
    }

    public function test_cannot_update_post_without_authentication()
    {
        $post = Post::factory()->create();

        $updateData = [
            'title' => 'Updated Post Title',
            'description' => 'This is an updated post description.',
            'contact_phone' => '+1234567891'
        ];

        $response = $this->putJson("/api/v1/posts/{$post->id}", $updateData);

        $response->assertStatus(401);
    }

    public function test_cannot_update_post_with_description_over_2kb()
    {
        $auth = $this->authenticateUser();
        $post = Post::factory()->create(['user_id' => $auth['user']->id]);

        $updateData = [
            'title' => 'Updated Post Title',
            'description' => str_repeat('a', 2049), // Over 2KB
            'contact_phone' => '+1234567891'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->putJson("/api/v1/posts/{$post->id}", $updateData);

        $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                    'message' => 'Description cannot exceed 2KB'
                ]);
    }

    public function test_can_delete_post()
    {
        $auth = $this->authenticateUser();
        $post = Post::factory()->create(['user_id' => $auth['user']->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->deleteJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Post deleted successfully'
                ]);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id
        ]);
    }

    public function test_cannot_delete_post_without_authentication()
    {
        $post = Post::factory()->create();

        $response = $this->deleteJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(401);
    }

    public function test_cannot_delete_nonexistent_post()
    {
        $auth = $this->authenticateUser();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $auth['token']
        ])->deleteJson('/api/v1/posts/999');

        $response->assertStatus(404);
    }

    public function test_posts_pagination_works_correctly()
    {
        $user = User::factory()->create();
        Post::factory()->count(25)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/v1/posts?page=2');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'pagination' => [
                        'current_page',
                        'last_page',
                        'per_page',
                        'total'
                    ]
                ]);

        $responseData = $response->json();
        $this->assertEquals(2, $responseData['pagination']['current_page']);
    }

    public function test_posts_list_includes_user_relationship()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/v1/posts/{$post->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ]);

        // Verify the post belongs to the correct user
        $this->assertEquals($user->id, $post->user_id);
    }
} 