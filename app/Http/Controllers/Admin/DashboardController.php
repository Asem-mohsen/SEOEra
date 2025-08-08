<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private PostRepository $postRepository
    ) {}

    /**
     * Show admin dashboard
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Get dashboard statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_users' => $this->userRepository->getCount(),
            'total_posts' => $this->postRepository->getCount(),
            'new_users' => $this->userRepository->getTodayCount(),
            'new_posts' => $this->postRepository->getTodayCount(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
} 