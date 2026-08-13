<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => [
                'required',
                'in:balance,cod'
            ],
        ]);

        $user = auth()->user();

        $cart = Cart::with(
            'items.product'
        )->where(
            'user_id',
            $user->id
        )->first();

        if (
            !$cart ||
            $cart->items->count() === 0
        ) {
            return back()->with(
                'error',
                'Keranjang kosong'
            );
        }

        $total = 0;

        foreach ($cart->items as $item) {
            $total +=
                $item->product->price *
                $item->quantity;
        }

        if (
            $request->payment_method === 'balance' &&
            $user->balance < $total
        ) {
            return back()->with(
                'error',
                'Saldo tidak cukup'
            );
        }

        DB::transaction(function () use (
            $cart,
            $user,
            $total,
            $request
        ) {

            if ($request->payment_method === 'balance') {

    $user->decrement(
        'balance',
        $total
    );

    $paymentStatus = 'paid';
    $orderStatus = 'paid';
}
else {

    $paymentStatus = 'unpaid';
    $orderStatus = 'pending';
}
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
            ]);

            foreach ($cart->items as $item) {

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                Notification::create([
    'user_id' => $item->product->store->user_id,
    'title' => 'Pesanan Baru',
    'message' =>
        auth()->user()->name .
        ' membeli produk ' .
        $item->product->name,
    'type' => 'order',
]);

                $item->product->decrement(
                    'stock',
                    $item->quantity
                );

                $item->product->increment(
                    'sold_count',
                    $item->quantity
                );
            }

            $cart->items()->delete();
        });

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Pesanan berhasil dibuat'
            );
    }
}