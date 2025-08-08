@extends('layout.master')

@section('page-title', 'Posts Management')
@section('main-breadcrumb', 'Dashboard')
@section('sub-breadcrumb', 'Posts')

@section('toolbar-actions')
<div class="d-flex align-items-center gap-2 gap-lg-3">
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-2"></i>
        Add New Post
    </a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>Posts</h3>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Posts" id="kt_filter_search" />
                </div>
            </div>
        </div>
    </div>
    <div class="card-body py-4">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_posts">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">Title</th>
                        <th class="min-w-125px">Description</th>
                        <th class="min-w-125px">Author</th>
                        <th class="min-w-125px">Contact Phone</th>
                        <th class="min-w-125px">Created</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-start flex-column">
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $post->title }}</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-gray-600 fw-semibold d-block fs-7">{{ Str::limit($post->description, 50) }}</span>
                        </td>
                        <td>
                            <span class="text-gray-600 fw-semibold d-block fs-7">{{ $post->user->name }}</span>
                        </td>
                        <td>
                            <span class="text-gray-600 fw-semibold d-block fs-7">{{ $post->contact_phone }}</span>
                        </td>
                        <td>
                            <span class="text-gray-600 fw-semibold d-block fs-7">{{ $post->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                Actions
                                <i class="ki-duotone ki-down fs-5 m-0"></i>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="menu-link px-3">View</a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="menu-link px-3">Edit</a>
                                </div>
                                <div class="menu-item px-3">
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="menu-link px-3 text-danger border-0 bg-transparent" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No posts found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($posts->hasPages())
        <div class="d-flex flex-stack flex-wrap pt-10">
            <div class="fs-6 fw-semibold text-gray-700">
                Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries
            </div>
            <div class="d-flex justify-content-end">
                {{ $posts->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 