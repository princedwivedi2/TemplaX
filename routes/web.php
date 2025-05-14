<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BusinessCardController;

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
    Route::prefix('cards')->name('cards.')->group(function () {
        // List and manage routes
        Route::get('/', [BusinessCardController::class, 'index'])->name('index');
        Route::get('/create', [BusinessCardController::class, 'create_card'])->name('create');
        Route::post('/', [BusinessCardController::class, 'store'])->name('store');
        
        // Admin routes
        Route::get('/approval', function () {
            return view('dashboard.index', ['activeTab' => 'approvals']);
        })->middleware('role:admin|super-admin')->name('approval');

        // Resource routes with {card} parameter
        Route::get('/download/{card}', [BusinessCardController::class, 'download'])->name('download');
        Route::get('/{card}', [BusinessCardController::class, 'show'])->name('show');
        Route::get('/{card}/edit', [BusinessCardController::class, 'edit'])->name('edit');
        Route::put('/{card}', [BusinessCardController::class, 'update'])->name('update');
        Route::delete('/{card}', [BusinessCardController::class, 'destroy'])->name('destroy');
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
                Route::get('/cards', [App\Http\Controllers\Admin\UserController::class, 'cards'])->name('cards');
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
