<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminBrandController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminOfferController;

// ==========================
// Public Routes
// ==========================
Route::get('/', function () {
    return view('welcome');
})->name('index');

// ==========================
// User Authentication Routes
// ==========================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/post-login', [AuthController::class, 'post_login'])->name('post_login');
Route::get('/sign-up', [AuthController::class, 'signup'])->name('signup');
Route::post('/post-signup', [AuthController::class, 'post_signup'])->name('post_signup');

// ==========================
// Admin Authentication Routes
// ==========================
Route::get('/admin-login', [AuthController::class, 'admin_login'])->name('admin_login');
Route::post('/post-login-admin', [AuthController::class, 'post_login_admin'])->name('post_login_admin');

// ==========================
// Logout Route
// ==========================
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth.custom')->prefix('admin')->name('admin.')->group(function () {

    // ===== Admin Dashboard =====
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ===== User Management =====
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.update-status');
    Route::delete('/users/{userId}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/bulk-delete', [AdminUserController::class, 'bulkDelete'])->name('users.bulk-delete');

    // ===== Brand Management =====
    Route::get('/brands', [AdminBrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [AdminBrandController::class, 'store'])->name('brands.store');
    Route::patch('/brands/{brand}', [AdminBrandController::class, 'update'])->name('brands.update');
    Route::patch('/brands/{brand}/status', [AdminBrandController::class, 'updateStatus'])->name('brands.update-status');
    Route::delete('/brands/{brand}', [AdminBrandController::class, 'destroy'])->name('brands.destroy');
    Route::post('/brands/bulk-delete', [AdminBrandController::class, 'bulkDelete'])->name('brands.bulk-delete');

    // ===== Category Management =====
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::patch('/categories/{category}/status', [AdminCategoryController::class, 'updateStatus'])->name('categories.update-status');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/bulk-delete', [AdminCategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

    // ===== Offer Management =====
    Route::get('/offers', [AdminOfferController::class, 'index'])->name('offers.index');
    Route::post('/offers', [AdminOfferController::class, 'store'])->name('offers.store');
    Route::patch('/offers/{offer}', [AdminOfferController::class, 'update'])->name('offers.update');
    Route::patch('/offers/{offer}/status', [AdminOfferController::class, 'updateStatus'])->name('offers.update-status');
    Route::delete('/offers/{offer}', [AdminOfferController::class, 'destroy'])->name('offers.destroy');
    Route::post('/offers/bulk-delete', [AdminOfferController::class, 'bulkDelete'])->name('offers.bulk-delete');
});

/*
|--------------------------------------------------------------------------
| User Routes (Protected by auth.custom middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.custom')->prefix('user')->name('user.')->group(function () {
    
});


