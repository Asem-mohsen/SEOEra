<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function __construct(
        private User $model
    ) {}

    /**
     * Create a new user
     */
    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Find user by phone
     */
    public function findByPhone(string $phone): ?User
    {
        return $this->model->where('phone', $phone)->first();
    }

    /**
     * Find user by name
     */
    public function findByName(string $name): ?User
    {
        return $this->model->where('name', $name)->first();
    }

    /**
     * Get all users with pagination
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('posts')->paginate($perPage);
    }

    /**
     * Get all users
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Update user
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Delete user
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Get users count
     */
    public function getCount(): int
    {
        return $this->model->count();
    }

    /**
     * Get users created today
     */
    public function getTodayCount(): int
    {
        return $this->model->whereDate('created_at', today())->count();
    }
} 