<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerApplication;
use App\Models\Store;
use App\Models\TopUp;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'sellers' => User::where('role', 'seller')->count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => OrderItem::sum(\DB::raw('price * quantity')),
            'pendingTopups' => TopUp::where('status', 'pending')->count(),
            'pendingSellerApplications' => SellerApplication::where('status', 'pending')->count(),
            'soldOutProducts' => Product::where('status', 'sold_out')->count(),
        ];

        $topSeller = Store::orderByDesc('total_sales')->first();
        $topProduct = Product::orderByDesc('sold_count')->first();

        $latestOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'topSeller' => $topSeller,
            'topProduct' => $topProduct,
            'latestOrders' => $latestOrders,
        ]);
    }
}

