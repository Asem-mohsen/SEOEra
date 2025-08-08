<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\{UpdateUserRequest, StoreUserRequest};
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Display a listing of users
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse|View
    {
        $perPage = $request->get('per_page', 10);
        $users = $this->userService->getAll($perPage);

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            Log::info('AJAX request detected for users');
            return response()->json([
                'success' => true,
                'data' => collect($users->items())->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'created_at' => $user->created_at->toISOString(),
                    ];
                })->toArray()
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = bcrypt($data['password']);
        
        $this->userService->create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $this->userService->update($user, $data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        $this->userService->delete($user);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
} 