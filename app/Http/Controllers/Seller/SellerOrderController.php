<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Notification;

class SellerOrderController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $orders = OrderItem::with([
            'order.user',
            'product',
        ])
        ->whereHas('product', function ($query) use ($store) {
            $query->where('store_id', $store->id);
        })
        ->latest()
        ->get();

        return inertia(
            'Seller/Orders/Index',
            [
                'orders' => $orders,
            ]
        );
    }

    public function ship(OrderItem $orderItem)
    {

        if (auth()->user()->isSuspended()) {

    return back()->with(
        'error',
        'Akun seller sedang ditangguhkan.'
    );

}   

        $orderItem->order->update([
            'status' => 'shipped',
        ]);

        return back()->with(
            'success',
            'Pesanan dikirim'
        );

        Notification::create([
    'user_id' => $orderItem->order->user_id,
    'title' => 'Pesanan Dikirim',
    'message' =>
        'Pesanan #' .
        $orderItem->order->id .
        ' sedang dikirim seller.',
    'type' => 'shipping',
]);
    }

    public function complete(OrderItem $orderItem)
    {

        if (auth()->user()->isSuspended()) {

    return back()->with(
        'error',
        'Akun seller sedang ditangguhkan.'
    );

}

        $orderItem->order->update([
            'status' => 'completed',
        ]);

        return back()->with(
            'success',
            'Pesanan selesai'
        );

        Notification::create([
    'user_id' => $orderItem->order->user_id,
    'title' => 'Pesanan Selesai',
    'message' =>
        'Pesanan #' .
        $orderItem->order->id .
        ' telah selesai.',
    'type' => 'completed',
]);
    }
}