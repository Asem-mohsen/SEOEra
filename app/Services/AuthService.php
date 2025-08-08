<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * Register a new user
     */
    public function register(array $data): array
    {
        // Check if user already exists
        if ($this->userRepository->findByEmail($data['email'])) {
            throw new \Exception('Email already exists');
        }

        if ($this->userRepository->findByPhone($data['phone'])) {
            throw new \Exception('Phone number already exists');
        }

        if ($this->userRepository->findByName($data['name'])) {
            throw new \Exception('Name already exists');
        }

        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Create user
        $user = $this->userRepository->create($data);

        // Generate token
        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Login with mobile number and password
     */
    public function login(string $phone, string $password): array
    {
        $user = $this->userRepository->findByPhone($phone);

        if (!$user || !Hash::check($password, $user->password)) {
            throw new \Exception('Invalid credentials');
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }


    /**
     * Get current authenticated user
     */
    public function getCurrentUser()
    {
        return Auth::user();
    }

    /**
     * Logout current user
     */
    public function logout(): bool
    {
        Auth::logout();
        return true;
    }
} 