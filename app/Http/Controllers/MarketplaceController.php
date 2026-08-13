<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class MarketplaceController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'store',
            'category'
        ])
        ->where('status', 'active')
        ->latest()
        ->get();

        return Inertia::render('Marketplace/Index', [
            'products' => $products,
        ]);
    }

    public function show(Product $product)
{
    $product->load([
        'category',
        'store.reviews.user'
    ]);

    return Inertia::render(
        'Marketplace/Show',
        [
            'product' => $product,
        ]
    );
}
}