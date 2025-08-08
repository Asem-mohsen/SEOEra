@extends('layout.master')

@section('page-title', 'Users Management')
@section('main-breadcrumb', 'Dashboard')
@section('sub-breadcrumb', 'Users')

@section('toolbar-actions')
<div class="d-flex align-items-center gap-2 gap-lg-3">
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="ki-duotone ki-plus fs-2"></i>
        Add New User
    </a>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <h3>Users</h3>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search Users" id="kt_filter_search" />
                </div>
            </div>
        </div>
    </div>
    <div class="card-body py-4">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th class="min-w-125px">User</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Phone</th>
                        <th class="min-w-125px">Status</th>
                        <th class="min-w-125px">Joined</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px me-5">
                                        <img src="{{ asset('assets/img/avatar.jpg') }}" alt="User avatar">
                                    </div>
                                    <div class="d-flex justify-content-start flex-column">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="text-gray-900 fw-bold text-hover-primary mb-1 fs-6">{{ $user->name }}</a>
                                        <span class="text-muted fw-semibold d-block fs-7">{{ $user->username }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-gray-600 fw-semibold d-block fs-7">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="text-gray-600 fw-semibold d-block fs-7">{{ $user->phone ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge badge-light-success">Verified</span>
                                @else
                                    <span class="badge badge-light-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-gray-600 fw-semibold d-block fs-7">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-duotone ki-down fs-5 m-0"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="menu-link px-3">View</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="menu-link px-3">Edit</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="menu-link px-3 text-danger border-0 bg-transparent" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="d-flex flex-stack flex-wrap pt-10">
                <div class="fs-6 fw-semibold text-gray-700">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                </div>
                <div class="d-flex justify-content-end">
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 