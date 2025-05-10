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

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');

// Card routes
Route::prefix('cards')->middleware(['auth'])->group(function () {
    Route::get('/download/{id?}', function ($id = null) {
        // This is a placeholder for the actual PDF download functionality
        // In a real application, you would generate and return a PDF here
        return response()->json([
            'message' => 'PDF download functionality will be implemented here',
            'card_id' => $id
        ]);
    })->name('card.download');
});

require __DIR__.'/auth.php';
