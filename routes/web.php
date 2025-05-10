<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', function () {
        // Placeholder data for dashboard stats
        $data = [];

        if (auth()->user()->hasRole('super-admin')) {
            $data['totalUsers'] = 125;
            $data['totalAdmins'] = 8;
            $data['totalCards'] = 350;
            $data['totalTemplates'] = 12;
        } elseif (auth()->user()->hasRole('admin')) {
            $data['departmentUsers'] = 42;
            $data['pendingApprovals'] = 7;
            $data['approvedCards'] = 85;
        } else {
            $data['userCards'] = 3;
            $data['pendingCards'] = 1;
        }

        // Placeholder data for user's business cards
        $data['userBusinessCards'] = [
            (object)[
                'id' => 1,
                'name' => 'Corporate Card',
                'created_at' => '2023-08-15',
                'status' => 'approved'
            ],
            (object)[
                'id' => 2,
                'name' => 'Event Card',
                'created_at' => '2023-09-20',
                'status' => 'pending'
            ]
        ];

        // Placeholder data for pending approvals
        $data['pendingApprovalCards'] = [
            (object)[
                'id' => 2,
                'name' => 'Event Card',
                'user_name' => 'John Doe',
                'created_at' => '2023-09-20'
            ],
            (object)[
                'id' => 3,
                'name' => 'Sales Card',
                'user_name' => 'Jane Smith',
                'created_at' => '2023-09-22'
            ]
        ];

        return view('dashboard.index', $data);
    })->name('dashboard');

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

    // Admin routes
    Route::prefix('admin')->middleware('role:admin|super-admin')->group(function () {
        Route::get('/templates', function () {
            return view('dashboard.index', ['activeTab' => 'templates']);
        })->name('templates.index');

        Route::get('/users', function () {
            return view('dashboard.index', ['activeTab' => 'users']);
        })->name('users.index');
    });

    // Super Admin routes
    Route::prefix('super-admin')->middleware('role:super-admin')->group(function () {
        Route::get('/admins', function () {
            return view('dashboard.index', ['activeTab' => 'admins']);
        })->name('admins.index');

        Route::get('/settings', function () {
            return view('dashboard.index', ['activeTab' => 'settings']);
        })->name('settings.index');
    });
});

require __DIR__.'/auth.php';
