<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $conversations = Conversation::with([
            'buyer',
            'seller',
            'product',
            'messages'
        ])
        ->where('buyer_id', $user->id)
        ->orWhere('seller_id', $user->id)
        ->latest()
        ->get();

        return Inertia::render(
            'Chat/Index',
            [
                'conversations' => $conversations
            ]
        );
    }

    public function start(Product $product)
    {
        $sellerId = $product->store->user_id;

        $conversation = Conversation::firstOrCreate(
            [
                'buyer_id' => auth()->id(),
                'seller_id' => $sellerId,
                'product_id' => $product->id,
            ]
        );

        return redirect()->route(
            'chat.show',
            $conversation
        );
    }

    public function show(
        Conversation $conversation
    ) {
        $conversation->load([
            'buyer',
            'seller',
            'product',
            'messages.sender'
        ]);

        return Inertia::render(
            'Chat/Show',
            [
                'conversation' => $conversation
            ]
        );
    }

    public function send(
        Request $request,
        Conversation $conversation
    ) {
        $request->validate([
            'message' => [
                'required',
                'string',
                'max:2000'
            ]
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        $receiverId =
            auth()->id() === $conversation->buyer_id
            ? $conversation->seller_id
            : $conversation->buyer_id;

        Notification::create([
            'user_id' => $receiverId,
            'title' => 'Pesan Baru',
            'message' => auth()->user()->name .
                ' mengirim pesan mengenai produk ' .
                $conversation->product->name,
            'type' => 'chat',
        ]);

        return back();
    }
}