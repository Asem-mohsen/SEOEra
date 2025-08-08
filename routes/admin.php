<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard routes
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/stats', 'stats')->name('stats');
    });

    Route::resource('/users', UserController::class);
    Route::resource('/posts', PostController::class);
}); 