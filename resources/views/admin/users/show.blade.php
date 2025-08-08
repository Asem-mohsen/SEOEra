@extends('layout.master')

@section('page-title', 'View User')
@section('main-breadcrumb', 'Admin')
@section('sub-breadcrumb', 'View User')

@section('toolbar-actions')
<div class="d-flex align-items-center gap-2 gap-lg-3">
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">
        <i class="ki-duotone ki-arrow-left fs-2"></i>
        Back to Users
    </a>
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
        <i class="ki-duotone ki-pencil fs-2"></i>
        Edit User
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3>User Profile</h3>
                </div>
                <div class="card-toolbar">
                    @if($user->email_verified_at)
                        <span class="badge badge-light-success">Verified</span>
                    @else
                        <span class="badge badge-light-warning">Pending Verification</span>
                    @endif
                </div>
            </div>
            <div class="card-body py-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center mb-5">
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <img src="{{ asset('assets/img/avatar.jpg') }}" alt="User avatar">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-5">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <p class="text-gray-600">{{ $user->name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-5">
                                    <label class="form-label fw-bold">Email</label>
                                    <p class="text-gray-600">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-5">
                                    <label class="form-label fw-bold">Phone</label>
                                    <p class="text-gray-600">{{ $user->phone ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-5">
                                    <label class="form-label fw-bold">Joined Date</label>
                                    <p class="text-gray-600">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-5">
                                    <label class="form-label fw-bold">Last Updated</label>
                                    <p class="text-gray-600">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($user->email_verified_at)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label class="form-label fw-bold">Email Verified</label>
                                        <p class="text-gray-600">{{ $user->email_verified_at->format('F d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($user->posts->count() > 0)
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="card-title">User Posts ({{ $user->posts->count() }})</h3>
            </div>
            <div class="card-body py-4">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>#</th>
                                <th class="min-w-125px">Title</th>
                                <th class="min-w-125px">Created</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach($user->posts->take(5) as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="text-gray-900 fw-bold text-hover-primary">{{ $post->title }}</a>
                                </td>
                                <td>
                                    <span class="text-gray-600 fw-semibold d-block fs-7">{{ $post->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($user->posts->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.posts.index', ['user_id' => $user->id]) }}" class="btn btn-light">View All Posts</a>
                    </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-5">
                    <label class="form-label fw-bold">User ID</label>
                    <p class="text-gray-600">{{ $user->id }}</p>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Email Verification</label>
                    <p class="text-gray-600">
                        @if($user->email_verified_at)
                            <span class="badge badge-light-success">Verified</span>
                        @else
                            <span class="badge badge-light-warning">Pending</span>
                        @endif
                    </p>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Total Posts</label>
                    <p class="text-gray-600">{{ $user->posts->count() }}</p>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                        <i class="ki-duotone ki-pencil fs-2"></i>
                        Edit User
                    </a>
                    
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                            <i class="ki-duotone ki-trash fs-2"></i>
                            Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 