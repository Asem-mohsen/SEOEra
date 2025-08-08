@extends('layout.auth-layout')

@section('title', 'Login')

@section('content')
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-lg-row-fluid">
            <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                <div class="d-flex flex-center flex-column">
                    <h1 class="text-gray-900 fw-bold mb-3">Welcome Back</h1>
                    <p class="text-gray-600 fw-semibold fs-6">Sign in to your account</p>
                </div>
                <div class="w-100 w-lg-400px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form class="form w-100" method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="fv-row mb-8">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Phone Number</label>
                            <input class="form-control bg-transparent" type="text" name="phone" 
                                   value="{{ old('phone') }}" autocomplete="off" required />
                        </div>

                        <div class="fv-row mb-3">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Password</label>
                            <input class="form-control bg-transparent" type="password" name="password" 
                                   autocomplete="off" required />
                        </div>

                        <div class="d-flex flex-wrap justify-content-between mb-8">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" />
                                <span class="form-check-label">Remember me</span>
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Sign In</span>
                            </button>
                        </div>

                        <div class="text-center mt-8">
                            <span class="text-gray-500">Don't have an account?</span>
                            <a href="{{ route('register') }}" class="text-primary fw-bold">Sign up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 