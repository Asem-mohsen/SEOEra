<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository
{
    public function __construct(
        private Post $model
    ) {}

    /**
     * Create a new post
     */
    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    /**
     * Find post by ID
     */
    public function findById(int $id): ?Post
    {
        return $this->model->with('user')->find($id);
    }

    /**
     * Get posts by user ID
     */
    public function getByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }


    /**
     * Update post
     */
    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    /**
     * Delete post
     */
    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    /**
     * Get posts count
     */
    public function getCount(): int
    {
        return $this->model->count();
    }

    /**
     * Get posts created today
     */
    public function getTodayCount(): int
    {
        return $this->model->whereDate('created_at', today())->count();
    }

    /**
     * Get posts for list view (with truncated descriptions)
     */
    public function getForList(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('user:id,name')
            ->select('id', 'title', 'description', 'user_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
} 