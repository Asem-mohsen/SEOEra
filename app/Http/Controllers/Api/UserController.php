<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{StoreUserRequest, UpdateUserRequest};
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * Get all users with pagination
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->getAllPaginated(10);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($users),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }
    /**
     * Get a specific user
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Update a user
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->userRepository->update($user, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => new UserResource($user->fresh())
        ]);
    }

    /**
     * Delete a user
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->delete($user);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
} 