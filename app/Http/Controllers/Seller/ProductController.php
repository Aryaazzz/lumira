<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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

        if (auth()->user()->isSuspended()) {

    return back()->with(
        'error',
        'Akun seller Anda sedang ditangguhkan oleh admin.'
    );

}

        $request->validate([
            'name' => ['required'],
            'category_id' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'image' => ['required', 'image', 'max:2048'],

'images' => ['nullable', 'array'],

'images.*' => [
    'image',
    'max:2048'
],
        ]);

        $image = $request->file('image')->store(
            'products',
            'public'
        );

       $product = Product::create([
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

if ($request->hasFile('images')) {

    foreach (
        $request->file('images')
        as $file
    ) {

        $path = $file->store(
            'products/gallery',
            'public'
        );

        ProductImage::create([
            'product_id' => $product->id,
            'image' => $path,
        ]);
    }
}

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

   public function edit(Product $product)
{

    $product->load('images');
    return Inertia::render(
        'Seller/Products/Edit',
        [
            'product' => $product,
            'categories' => Category::all(),
        ]
    );
}

public function show(Product $product)
{
    $product->load([
    'images',
    'category',
    'store',
    'orderItems.order.user',
]);

    // Collect unique buyers who purchased this product
    $buyers = $product->orderItems
        ->map(fn($item) => $item->order->user)
        ->unique('id')
        ->values();

    return Inertia::render('Seller/Products/Show', [
        'product' => $product,
        'buyers' => $buyers,
    ]);
}

public function update(
    Request $request,
    Product $product
) {

    $request->validate([
        'name' => ['required'],
        'category_id' => ['required'],
        'description' => ['required'],
        'price' => ['required', 'numeric'],
        'stock' => ['required', 'integer'],
        'status' => ['required'],
        'image' => ['nullable', 'image'],
    ]);

    if ($request->hasFile('image')) {

        if ($product->image) {

            Storage::disk('public')->delete(
                $product->image
            );
        }

        $image = $request->file('image')
            ->store(
                'products',
                'public'
            );

        $product->image = $image;
    }

    $status = $request->status;

if ($request->stock <= 0) {
    $status = 'sold_out';
}

    $product->update([
    'name' => $request->name,
    'category_id' => $request->category_id,
    'description' => $request->description,
    'price' => $request->price,
    'stock' => $request->stock,
    'status' => $status,
]);

    if (isset($image)) {
        $product->image = $image;
        $product->save();
    }

    return redirect()
        ->route('seller.products.index')
        ->with(
            'success',
            'Produk berhasil diperbarui'
        );
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