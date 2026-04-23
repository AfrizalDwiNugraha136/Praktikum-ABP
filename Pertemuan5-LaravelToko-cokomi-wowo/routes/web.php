<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Toko Inventari Cokomi & Wowo
|--------------------------------------------------------------------------
*/

// ── Public Routes ────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('products.index');
});

// ── Protected Routes (Butuh Login) ───────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard redirect ke produk
    Route::get('/dashboard', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    // Resource CRUD untuk produk
    Route::resource('products', ProductController::class);

});

// ── Auth Routes (Laravel Breeze) ─────────────────────────────
require __DIR__ . '/auth.php';
