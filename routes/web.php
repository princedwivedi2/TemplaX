<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessCardController;


// Guest/Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth', 'active'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // User profile
    Route::get('profile', [UserController::class, 'profile'])->name('users.profile');
    Route::patch('profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');

    // Business Cards
    Route::resource('cards', BusinessCardController::class);
    Route::get('cards/{card}/preview', [BusinessCardController::class, 'preview'])->name('cards.preview');
    Route::get('cards/{card}/download', [BusinessCardController::class, 'download'])->name('cards.download');

    // User Management (Admin only)
    Route::middleware(['role:super-admin,admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
    });

    // Role Management (Super Admin only)
    Route::middleware(['role:super-admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions');
    });

    // Admin routes
    Route::middleware(['role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
        // User management routes
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/data', [App\Http\Controllers\Admin\UserController::class, 'data'])->name('users.data');
        Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/data', [App\Http\Controllers\Admin\UserController::class, 'data'])->name('users.data');
    Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    
    // Template Management
    Route::get('/templates', [App\Http\Controllers\TemplateController::class, 'getAvailable'])->name('templates.index');
    Route::get('/templates/{template}/preview', [App\Http\Controllers\TemplateController::class, 'preview'])->name('templates.preview');
});
