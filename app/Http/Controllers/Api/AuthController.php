<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginRequest, RegisterRequest};
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->register($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => new UserResource($result['user']),
                    'token' => $result['token']
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Login with mobile number and password
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->phone, $request->password);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => new UserResource($result['user']),
                    'token' => $result['token']
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()], 401);
        }
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request): JsonResponse
    {
        $user = $this->authService->getCurrentUser();

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Logout current user
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
} 