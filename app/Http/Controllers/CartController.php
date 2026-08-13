<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with([
            'items.product.store'
        ])->firstOrCreate([
            'user_id' => auth()->id()
        ]);

        return Inertia::render('Cart/Index', [
            'cart' => $cart,
        ]);
    }

    public function add(Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return back()->with(
            'success',
            'Produk berhasil ditambahkan ke keranjang'
        );
    }

    public function remove($id)
    {
        $cart = Cart::where(
            'user_id',
            auth()->id()
        )->first();

        if ($cart) {
            $cart->items()
                ->where('id', $id)
                ->delete();
        }

        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ]
        ]);

        $cart = Cart::where(
            'user_id',
            auth()->id()
        )->first();

        if ($cart) {
            $cart->items()
                ->where('id', $id)
                ->update([
                    'quantity' => $request->quantity
                ]);
        }

        return back();
    }
}