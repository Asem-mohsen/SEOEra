@extends('layout.master')

@section('page-title', 'View Post')
@section('main-breadcrumb', 'Admin')
@section('sub-breadcrumb', 'View Post')

@section('toolbar-actions')
<div class="d-flex align-items-center gap-2 gap-lg-3">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-light">
        <i class="ki-duotone ki-arrow-left fs-2"></i>
        Back to Posts
    </a>
    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">
        <i class="ki-duotone ki-pencil fs-2"></i>
        Edit Post
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3>{{ $post->title }}</h3>
                </div>
                <div class="card-toolbar">
                    <span class="badge badge-light-{{ $post->status == 'published' ? 'success' : ($post->status == 'draft' ? 'warning' : 'danger') }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body py-4">
                <div class="mb-5">
                    <h5 class="text-gray-900 fw-bold mb-3">Description</h5>
                    <p class="text-gray-600 fs-6">{{ $post->description }}</p>
                </div>

                <div class="mb-5">
                    <h5 class="text-gray-900 fw-bold mb-3">Content Phone</h5>
                    <div class="text-gray-600 fs-6">
                        <a href="tel:{{ $post->contact_phone }}" class="btn btn-primary">
                            {{ $post->contact_phone }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Post Information</h3>
            </div>
            <div class="card-body">
                <div class="mb-5">
                    <label class="form-label fw-bold">Author</label>
                    <p class="text-gray-600">{{ $post->user->name }}</p>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="text-gray-600">{{ $post->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Updated At</label>
                    <p class="text-gray-600">{{ $post->updated_at->format('F d, Y \a\t g:i A') }}</p>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">Post ID</label>
                    <p class="text-gray-600">{{ $post->id }}</p>
                </div>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h3 class="card-title">Actions</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary">
                        <i class="ki-duotone ki-pencil fs-2"></i>
                        Edit Post
                    </a>
                    
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this post? This action cannot be undone.')">
                            <i class="ki-duotone ki-trash fs-2"></i>
                            Delete Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 