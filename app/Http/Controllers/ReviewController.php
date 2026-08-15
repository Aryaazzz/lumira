<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(
        Request $request,
        Order $order
    ) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->review) {
            return back()->with(
                'error',
                'Pesanan ini sudah diberi review.'
            );
        }

        $request->validate([
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'comment' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $storeId = $order
            ->items
            ->first()
            ->product
            ->store_id;

        Review::create([
            'user_id' => auth()->id(),
            'store_id' => $storeId,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $store = \App\Models\Store::find($storeId);

        $store->rating = round(
            $store->reviews()->avg('rating'),
            1
        );

        $store->save();

        return back()->with(
            'success',
            'Review berhasil dikirim.'
        );
    }
}