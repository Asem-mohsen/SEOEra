@extends('layout.master')

@section('page-title', 'Dashboard')
@section('main-breadcrumb', 'Admin')
@section('sub-breadcrumb', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-6">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-3">
                            <i class="fas fa-users text-muted fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">Total Users</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="totalUsers">-</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-3">
                            <i class="fas fa-file-alt text-muted fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">Total Posts</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="totalPosts">-</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-3">
                            <i class="fas fa-user-plus text-muted fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">New Users Today</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="newUsers">-</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-3">
                            <i class="fas fa-plus-circle text-muted fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">New Posts Today</h6>
                        <h3 class="mb-0 fw-bold text-dark" id="newPosts">-</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Cards -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fw-bold text-dark">Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light-primary">View All</a>
                </div>
            </div>
            <div class="card-body pt-3">
                <div id="recentUsers" class="min-h-200px">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0 fw-bold text-dark">Recent Posts</h5>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-light-primary">View All</a>
                </div>
            </div>
            <div class="card-body pt-3">
                <div id="recentPosts" class="min-h-200px">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('js')
    @include('admin.scripts.dashboard-scripts')
@endsection