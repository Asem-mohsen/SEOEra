@extends('layout.master')

@section('page-title', 'Edit Post')
@section('main-breadcrumb', 'Admin')
@section('sub-breadcrumb', 'Edit Post')

@section('toolbar-actions')
<div class="d-flex align-items-center gap-2 gap-lg-3">
    <a href="{{ route('admin.posts.index') }}" class="btn btn-light">
        <i class="ki-duotone ki-arrow-left fs-2"></i>
        Back to Posts
    </a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>Edit Post: {{ $post->title }}</h3>
        </div>
    </div>
    <div class="card-body py-4">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-5">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control form-control-solid @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $post->title) }}" placeholder="Enter post title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="form-label required">Description</label>
                        <textarea class="form-control form-control-solid @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="6" placeholder="Enter post description" required>{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="contact_phone" class="form-label required">Contact Phone</label>
                        <input type="text" class="form-control form-control-solid @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" placeholder="Enter post contact phone" required value="{{ old('contact_phone', $post->contact_phone) }}">
                        @error('contact_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-light btn-active-light-primary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update Post</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 