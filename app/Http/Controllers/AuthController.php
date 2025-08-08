<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\{LoginRequest, RegisterRequest};
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        try {
            $result = $this->authService->login($data['phone'],$data['password']);

            Auth::login($result['user']);

            return redirect()->intended('/admin/dashboard')->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle register request
     */
    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->authService->register($request->validated());

            Auth::login($result['user']);

            return redirect()->intended('/admin/dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully!');
    }
} 