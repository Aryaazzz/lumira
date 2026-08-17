<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'conversation.{conversationId}',
    function ($user, $conversationId) {

        $conversation =
            Conversation::find(
                $conversationId
            );

        if (! $conversation) {
            return false;
        }

        return
            $conversation->buyer_id === $user->id ||
            $conversation->seller_id === $user->id;
    }
);