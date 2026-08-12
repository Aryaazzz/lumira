<?php

use App\Http\Controllers\Admin\SellerApplicationController as AdminSellerApplicationController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\SellerApplicationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/marketplace', [
    MarketplaceController::class,
    'index'
])->name('marketplace');

Route::get('/marketplace/{product}', [
    MarketplaceController::class,
    'show'
])->name('marketplace.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $role = auth()->user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dashboard'),
            default => redirect()->route('user.dashboard'),
        };

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:user')->group(function () {

        Route::get('/user/dashboard', function () {
            return Inertia::render('DashboardUser');
        })->name('user.dashboard');

        Route::get(
            '/seller/apply',
            [SellerApplicationController::class, 'create']
        )->name('seller.apply');

        Route::post(
            '/seller/apply',
            [SellerApplicationController::class, 'store']
        )->name('seller.apply.store');
    });

    /*
    |--------------------------------------------------------------------------
    | SELLER
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:seller')->group(function () {

        Route::get('/seller/dashboard', function () {
            return Inertia::render('DashboardSeller');
        })->name('seller.dashboard');

        Route::get(
            '/seller/products',
            [ProductController::class, 'index']
        )->name('seller.products.index');

        Route::get(
            '/seller/products/create',
            [ProductController::class, 'create']
        )->name('seller.products.create');

        Route::post(
            '/seller/products',
            [ProductController::class, 'store']
        )->name('seller.products.store');

        Route::delete(
            '/seller/products/{product}',
            [ProductController::class, 'destroy']
        )->name('seller.products.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/dashboard', function () {
            return Inertia::render('DashboardAdmin');
        })->name('admin.dashboard');

        Route::get(
            '/admin/seller-applications',
            [AdminSellerApplicationController::class, 'index']
        )->name('admin.seller.applications');

        Route::post(
            '/admin/seller-applications/{sellerApplication}/approve',
            [AdminSellerApplicationController::class, 'approve']
        )->name('admin.seller.approve');

        Route::post(
            '/admin/seller-applications/{sellerApplication}/reject',
            [AdminSellerApplicationController::class, 'reject']
        )->name('admin.seller.reject');
    });
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});

require __DIR__.'/auth.php';