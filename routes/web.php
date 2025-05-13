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
            Route::prefix('users')->name('admin.users.')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
                Route::get('/data', [App\Http\Controllers\Admin\UserController::class, 'data'])->name('data');
                Route::post('/', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
                Route::get('/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
                Route::put('/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
                Route::delete('/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
            });

            // Other Super Admin Routes
            Route::get('/settings', function () {
                return view('dashboard.index', ['activeTab' => 'settings']);
            })->name('settings.index');
        });
    });
});

require __DIR__.'/auth.php';
