<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->where('store_id', auth()->user()->store->id)
            ->latest()
            ->get();

        return Inertia::render('Seller/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return Inertia::render('Seller/Products/Create', [
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'category_id' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $image = $request->file('image')->store(
            'products',
            'public'
        );

        Product::create([
            'store_id' => auth()->user()->store->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image,
            'status' => 'active',
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete(
                $product->image
            );
        }

        $product->delete();

        return back();
    }
}