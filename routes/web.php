<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\Admin\SellerApplicationController as AdminSellerApplicationController;
use App\Http\Controllers\Admin\TopUpController as AdminTopUpController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SellerManagementController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerOrderController;

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

Route::get(
    '/marketplace',
    [MarketplaceController::class, 'index']
)->name('marketplace');

Route::get(
    '/marketplace/{product}',
    [MarketplaceController::class, 'show']
)->name('marketplace.show');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {

        return match (auth()->user()->role) {
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

    $announcement = \App\Models\Announcement::where(
        'is_active',
        true
    )
    ->latest()
    ->first();

    return Inertia::render(
        'DashboardUser',
        [
            'announcement' => $announcement,
        ]
    );

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
    | NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    )->name('notifications.index');

    Route::post(
        '/notifications/{notification}/read',
        [NotificationController::class, 'read']
    )->name('notifications.read');

    Route::post(
        '/notifications/read-all',
        [NotificationController::class, 'readAll']
    )->name('notifications.readAll');

    /*
    |--------------------------------------------------------------------------
    | TOP UP
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/topup',
        [TopUpController::class, 'index']
    )->name('topup.index');

    Route::post(
        '/topup',
        [TopUpController::class, 'store']
    )->name('topup.store');

    Route::get(
        '/topup/history',
        [TopUpController::class, 'history']
    )->name('topup.history');

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/cart',
        [CartController::class, 'index']
    )->name('cart.index');

    Route::post(
        '/cart/add/{product}',
        [CartController::class, 'add']
    )->name('cart.add');

    Route::patch(
        '/cart/update/{cartItem}',
        [CartController::class, 'update']
    )->name('cart.update');

    Route::delete(
        '/cart/remove/{cartItem}',
        [CartController::class, 'remove']
    )->name('cart.remove');

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/checkout',
        [CheckoutController::class, 'store']
    )->name('checkout.store');

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/orders',
        [OrderController::class, 'index']
    )->name('orders.index');

    /*
    |--------------------------------------------------------------------------
    | REVIEWS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/orders/{order}/review',
        [ReviewController::class, 'create']
    )->name('reviews.create');

    Route::post(
        '/orders/{order}/review',
        [ReviewController::class, 'store']
    )->name('reviews.store');

    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/chat',
        [ChatController::class, 'index']
    )->name('chat.index');

    Route::post(
        '/chat/start/{product}',
        [ChatController::class, 'start']
    )->name('chat.start');

    Route::get(
        '/chat/{conversation}',
        [ChatController::class, 'show']
    )->name('chat.show');

    Route::post(
        '/chat/{conversation}/send',
        [ChatController::class, 'send']
    )->name('chat.send');

    /*
|--------------------------------------------------------------------------
| SELLER
|--------------------------------------------------------------------------
*/

Route::middleware('role:seller')->group(function () {

    Route::get('/seller/dashboard', function () {

        $announcement = \App\Models\Announcement::where(
            'is_active',
            true
        )
        ->latest()
        ->first();

        return Inertia::render(
            'DashboardSeller',
            [
                'announcement' => $announcement,
            ]
        );

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

    Route::get(
        '/seller/orders',
        [SellerOrderController::class, 'index']
    )->name('seller.orders.index');

    Route::post(
        '/seller/orders/{orderItem}/ship',
        [SellerOrderController::class, 'ship']
    )->name('seller.orders.ship');

    Route::post(
        '/seller/orders/{orderItem}/complete',
        [SellerOrderController::class, 'complete']
    )->name('seller.orders.complete');

});
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get(
    '/admin/dashboard',
    [DashboardController::class, 'index']
)->name('admin.dashboard');

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

        Route::get(
            '/admin/topups',
            [AdminTopUpController::class, 'index']
        )->name('admin.topups.index');

        Route::post(
            '/admin/topups/{topUp}/approve',
            [AdminTopUpController::class, 'approve']
        )->name('admin.topups.approve');

        Route::post(
            '/admin/topups/{topUp}/reject',
            [AdminTopUpController::class, 'reject']
        )->name('admin.topups.reject');

        Route::get(
    '/admin/sellers',
    [SellerManagementController::class, 'index']
)->name('admin.sellers.index');

Route::post(
    '/admin/sellers/{user}/warning',
    [SellerManagementController::class, 'warning']
)->name('admin.sellers.warning');

Route::post(
    '/admin/sellers/{user}/suspend',
    [SellerManagementController::class, 'suspend']
)->name('admin.sellers.suspend');

Route::post(
    '/admin/sellers/{user}/unsuspend',
    [SellerManagementController::class, 'unsuspend']
)->name('admin.sellers.unsuspend');

Route::get(
    '/admin/announcements',
    [AnnouncementController::class, 'index']
)->name('admin.announcements.index');

Route::post(
    '/admin/announcements',
    [AnnouncementController::class, 'store']
)->name('admin.announcements.store');

Route::get(
    '/admin/categories',
    [CategoryController::class, 'index']
)->name('admin.categories.index');

Route::post(
    '/admin/categories',
    [CategoryController::class, 'store']
)->name('admin.categories.store');

Route::patch(
    '/admin/categories/{category}',
    [CategoryController::class, 'update']
)->name('admin.categories.update');

Route::delete(
    '/admin/categories/{category}',
    [CategoryController::class, 'destroy']
)->name('admin.categories.destroy');

    Route::get(
    '/admin/products',
    [AdminProductController::class, 'index']
)->name('admin.products.index');

Route::delete(
    '/admin/products/{product}',
    [AdminProductController::class, 'destroy']
)->name('admin.products.destroy');

Route::post(
    '/admin/products/{product}/hide'
    ,
    [AdminProductController::class, 'hide']
)->name('admin.products.hide');

Route::post(
    '/admin/products/{product}/show'
    ,
    [AdminProductController::class, 'show']
)->name('admin.products.show');

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

require __DIR__ . '/auth.php';