<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\{ StorePostRequest, UpdatePostRequest };
use App\Models\{ Post, User };
use App\Services\PostService ;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
    ) {}

    /**
     * Display a listing of posts
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse|View
    {
        $perPage = $request->get('per_page', 10);
        $posts = $this->postService->getPublicPosts($perPage);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => collect($posts->items())->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'title' => $post->title,
                        'description' => $post->description,
                        'truncated_description' => $post->truncated_description,
                        'created_at' => $post->created_at->toISOString(),
                    ];
                })->toArray()
            ]);
        }

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created post
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        /** @var User $user */
        $user = auth()->user();

        $this->postService->create($data, $user->id);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified post
     */
    public function show(Post $post): View
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified post
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

         /** @var User $user */
         $user = auth()->user();
        
        $this->postService->update($post, $data, $user->id);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified post
     */
    public function destroy(Post $post)
    {
        $this->postService->delete($post);

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
} 