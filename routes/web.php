<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BusinessCardController;
use App\Http\Controllers\TemplateController;

// Guest/Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Business Cards Management
    Route::prefix('cards')->name('cards.')->group(function () {
        Route::get('/', [BusinessCardController::class, 'index'])->name('index');
        Route::get('/create', [BusinessCardController::class, 'create_card'])->name('create');
        Route::post('/', [BusinessCardController::class, 'store'])->name('store');
        
        // Dynamic template preview
        Route::get('/templates/{template}', function ($template) {
            try {
                $templateModel = \App\Models\Template::where('slug', $template)
                    ->where('is_active', true)
                    ->firstOrFail();

                $view = view("cards.templates.{$template}", [
                    'full_name' => '',
                    'job_title' => '',
                    'company_name' => '',
                    'email' => '',
                    'phone' => '',
                    'website' => '',
                    'address' => '',
                    'linkedin' => '',
                    'twitter' => '',
                    'logoUrl' => null
                ])->render();

                return response()->json([
                    'success' => true,
                    'html' => $view
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load template: ' . $e->getMessage()
                ], 404);
            }
        })->name('template.view');

        // Card resource routes
        Route::get('/{card}', [BusinessCardController::class, 'show'])->name('show');
        Route::get('/{card}/edit', [BusinessCardController::class, 'edit'])->name('edit');
        Route::put('/{card}', [BusinessCardController::class, 'update'])->name('update');
        Route::delete('/{card}', [BusinessCardController::class, 'destroy'])->name('destroy');
        
       
        // Preview
        Route::get('/{id}/preview', [BusinessCardController::class, 'preview'])->name('preview');
    });

    // Admin and Super Admin routes
    Route::middleware(['role:admin|super-admin'])->group(function () {
        // Cards approval route
        Route::get('/cards/approval', function () {
            return view('dashboard.index', ['activeTab' => 'approvals']);
        })->name('cards.approval');

        // Template Management
        Route::prefix('templates')->name('templates.')->group(function () {
            Route::get('/', [TemplateController::class, 'index'])->name('index');
            Route::get('/create', [TemplateController::class, 'create'])->name('create');
            Route::post('/', [TemplateController::class, 'store'])->name('store');
            Route::get('/{template}', [TemplateController::class, 'show'])->name('show');
            Route::get('/{template}/edit', [TemplateController::class, 'edit'])->name('edit');
            Route::put('/{template}', [TemplateController::class, 'update'])->name('update');
            Route::delete('/{template}', [TemplateController::class, 'destroy'])->name('destroy');
            Route::post('/{template}/toggle-status', [TemplateController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/{template}/preview', [TemplateController::class, 'preview'])->name('preview');
        });

     

        // User Management (Admin view)
        Route::prefix('admin')->group(function () {
            Route::get('/users', function () {
                return view('dashboard.index', ['activeTab' => 'users']);
            })->name('users.index');
        });
    });

    // Super Admin only routes
    Route::middleware(['role:super-admin'])->group(function () {
        Route::prefix('super-admin/users')->name('admin.users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/cards', [UserController::class, 'cards'])->name('cards');
            Route::get('/data', [UserController::class, 'data'])->name('data');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
        });
    });
});
