<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\{StorePostRequest, UpdatePostRequest};
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
    ) {}

    /**
     * Get paginated list of posts
     */
    public function index(Request $request): JsonResponse
    {
        $posts = $this->postService->getPublicPosts(10);

        return response()->json([
            'success' => true,
            'data' => PostResource::collection($posts),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);
    }

    /**
     * Create a new post
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        try {
            $user = Auth::user();

            $post = $this->postService->create($request->validated(), $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => new PostResource($post)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get a specific post
     */
    public function show(Post $post): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new PostResource($post)
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $this->postService->update($post, $request->validated(), $post->user_id);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => new PostResource($post)
        ]);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->postService->delete($post);

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
} 