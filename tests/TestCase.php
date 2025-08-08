<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Generate JWT token for a user
     */
    protected function generateToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }

    /**
     * Authenticate a user and return the token
     */
    protected function authenticateUser(User $user = null): array
    {
        $user = $user ?? User::factory()->create();
        $token = $this->generateToken($user);
        
        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
