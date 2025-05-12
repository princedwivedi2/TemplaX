<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Card routes
    Route::prefix('cards')->group(function () {
        Route::get('/', function () {
            return view('dashboard.index', ['activeTab' => 'cards']);
        })->name('cards.index');

        Route::get('/create', function () {
            return view('dashboard.index', ['activeTab' => 'create']);
        })->name('cards.create');

        Route::get('/download/{id?}', function ($id = null) {
            // This is a placeholder for the actual PDF download functionality
            // In a real application, you would generate and return a PDF here
            return response()->json([
                'message' => 'PDF download functionality will be implemented here',
                'card_id' => $id
            ]);
        })->name('card.download');

        Route::get('/approval', function () {
            return view('dashboard.index', ['activeTab' => 'approvals']);
        })->middleware('role:admin|super-admin')->name('cards.approval');
    });

    // Admin and Super Admin routes
    Route::middleware(['auth', 'role:admin|super-admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/templates', function () {
                return view('dashboard.index', ['activeTab' => 'templates']);
            })->name('templates.index');

            Route::get('/users', function () {
                return view('dashboard.index', ['activeTab' => 'users']);
            })->name('users.index');
        });
    });

    // Super Admin routes
    Route::middleware(['auth', 'role:super-admin'])->group(function () {
        Route::prefix('super-admin')->group(function () {
            // User Management Routes
            Route::get('/users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('admin.users.index');
            Route::get('/admins', [App\Http\Controllers\UserManagementController::class, 'admins'])->name('admin.users.admins');

            // AJAX Routes for User Management
            Route::get('/users/data', [App\Http\Controllers\UserManagementController::class, 'getUsers'])->name('admin.users.data');
            Route::get('/admins/data', [App\Http\Controllers\UserManagementController::class, 'getAdmins'])->name('admin.admins.data');
            Route::post('/users', [App\Http\Controllers\UserManagementController::class, 'store'])->name('admin.users.store');
            Route::get('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'show'])->name('admin.users.show');
            Route::put('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'update'])->name('admin.users.update');
            Route::delete('/users/{id}', [App\Http\Controllers\UserManagementController::class, 'destroy'])->name('admin.users.destroy');

            // Legacy routes (to be updated)
            Route::get('/admins-old', function () {
                return view('dashboard.index', ['activeTab' => 'admins']);
            })->name('admins.index');

            Route::get('/settings', function () {
                return view('dashboard.index', ['activeTab' => 'settings']);
            })->name('settings.index');
        });
    });
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/data', [UserController::class, 'data'])->name('data');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
