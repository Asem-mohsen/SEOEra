<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }

    /**
     * Get all users
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->userRepository->getAll($perPage);
    }


    /**
     * Update user
     */
    public function update(User $user, array $data): bool
    {
        return $this->userRepository->update($user, $data);
    }

    /**
     * Delete user
     */
    public function delete(User $user): bool
    {
        $user->posts()->delete();
        
        return $this->userRepository->delete($user);
    }

    /**
     * Get users count
     */
    public function getCount(): int
    {
        return $this->userRepository->getCount();
    }

    /**
     * Get today's users count
     */
    public function getTodayCount(): int
    {
        return $this->userRepository->getTodayCount();
    }
} 