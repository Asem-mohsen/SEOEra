<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(
        private PostRepository $postRepository
    ) {}

    /**
     * Create a new post
     */
    public function create(array $data, int $userId): Post
    {
        // Validate description length (2KB = 2048 characters)
        if (strlen($data['description']) > 2048) {
            throw new \Exception('Description cannot exceed 2KB');
        }

        $data['user_id'] = $userId;

        return $this->postRepository->create($data);
    }

    /**
     * Get paginated posts for public view
     */
    public function getPublicPosts(int $perPage = 10): LengthAwarePaginator
    {
        return $this->postRepository->getForList($perPage);
    }

    /**
     * Get posts by user
     */
    public function getPostsByUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->postRepository->getByUserId($userId, $perPage);
    }

    /**
     * Get post by ID
     */
    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }

    /**
     * Update post
     */
    public function update(Post $post, array $data, int $userId): bool
    {
        // Validate description length if provided
        if (isset($data['description']) && strlen($data['description']) > 2048) {
            throw new \Exception('Description cannot exceed 2KB');
        }

        $data['user_id'] = $userId;

        return $this->postRepository->update($post, $data);
    }

    /**
     * Delete post
     */
    public function delete(Post $post): bool
    {
        return $this->postRepository->delete($post);
    }
} 