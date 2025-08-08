@extends('layout.master')

@section('page-title', 'Edit User')
@section('main-breadcrumb', 'Admin')
@section('sub-breadcrumb', 'Edit User')

@section('toolbar-actions')
<div class="d-flex align-items-center gap-2 gap-lg-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
        <i class="ki-duotone ki-arrow-left fs-2"></i>
        Back to Users
    </a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>Edit User: {{ $user->name }}</h3>
        </div>
    </div>
    <div class="card-body py-4">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-5">
                                <label for="name" class="form-label required">Full Name</label>
                                <input type="text" class="form-control form-control-solid @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="email" class="form-label required">Email</label>
                                <input type="email" class="form-control form-control-solid @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control form-control-solid @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control form-control-solid @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter new password (leave blank to keep current)">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave blank to keep current password</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-5">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control form-control-solid @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-5">
                                <label for="email_verified_at" class="form-label">Email Verification</label>
                                <select class="form-select form-select-solid @error('email_verified_at') is-invalid @enderror" 
                                        id="email_verified_at" name="email_verified_at">
                                    <option value="">Not Verified</option>
                                    <option value="{{ now() }}" {{ old('email_verified_at', $user->email_verified_at) ? 'selected' : '' }}>Verified</option>
                                </select>
                                @error('email_verified_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Set email verification status</div>
                            </div>

                            <div class="mb-5">
                                <label for="status" class="form-label">Account Status</label>
                                <select class="form-select form-select-solid @error('status') is-invalid @enderror" 
                                        id="status" name="status">
                                    <option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $user->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ old('status', $user->status ?? 'active') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-active-light-primary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update User</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 