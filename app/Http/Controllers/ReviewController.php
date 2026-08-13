<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function create(Order $order)
    {
        $order->load(
            'items.product.store'
        );

        return Inertia::render(
            'Reviews/Create',
            [
                'order' => $order,
            ]
        );
    }

    public function store(
        Request $request,
        Order $order
    ) {
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

        $store = $order
            ->items
            ->first()
            ->product
            ->store;

        Review::create([
            'user_id' => auth()->id(),
            'store_id' => $store->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $store->update([
            'rating' => round(
                $store->reviews()->avg('rating'),
                2
            ),
            'total_reviews' => $store
                ->reviews()
                ->count(),
        ]);

        return redirect()
            ->route('orders.index')
            ->with(
                'success',
                'Review berhasil dikirim'
            );
    }
}