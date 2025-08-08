@extends('layout.auth-layout')

@section('title', 'Register')

@section('content')
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-lg-row-fluid">
            <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
                <div class="d-flex flex-center flex-column">
                    <h1 class="text-gray-900 fw-bold mb-3">Create Account</h1>
                    <p class="text-gray-600 fw-semibold fs-6">Join our community</p>
                </div>
                <div class="w-100 w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form class="form w-100" method="POST" action="{{ route('register') }}">
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
                            <label class="form-label fw-bolder text-gray-900 fs-6">Full Name</label>
                            <input class="form-control bg-transparent" type="text" name="name" 
                                   value="{{ old('name') }}" autocomplete="off" required />
                        </div>

                        <div class="fv-row mb-8">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Email</label>
                            <input class="form-control bg-transparent" type="email" name="email" 
                                   value="{{ old('email') }}" autocomplete="off" required />
                        </div>

                        <div class="fv-row mb-8">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Phone Number</label>
                            <input class="form-control bg-transparent" type="text" name="phone" 
                                   value="{{ old('phone') }}" autocomplete="off" required />
                        </div>

                        <div class="fv-row mb-8">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Password</label>
                            <input class="form-control bg-transparent" type="password" name="password" 
                                   autocomplete="off" required />
                        </div>

                        <div class="fv-row mb-8">
                            <label class="form-label fw-bolder text-gray-900 fs-6">Confirm Password</label>
                            <input class="form-control bg-transparent" type="password" name="password_confirmation" 
                                   autocomplete="off" required />
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Create Account</span>
                            </button>
                        </div>

                        <div class="text-center mt-8">
                            <span class="text-gray-500">Already have an account?</span>
                            <a href="{{ route('login') }}" class="text-primary fw-bold">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 