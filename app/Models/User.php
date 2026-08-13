<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Review;
use App\Models\Notification;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'avatar',
    'balance',
    'warning_count',
    'seller_status',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    public function sellerApplication()
    {
        return $this->hasOne(SellerApplication::class);
    }

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function cart()
{
    return $this->hasOne(Cart::class);
}

    public function reviewedApplications()
    {
        return $this->hasMany(
            SellerApplication::class,
            'reviewed_by'
        );
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}

   public function buyerConversations()
{
    return $this->hasMany(
        Conversation::class,
        'buyer_id'
    );
}

public function sellerConversations()
{
    return $this->hasMany(
        Conversation::class,
        'seller_id'
    );
}

public function messages()
{
    return $this->hasMany(
        Message::class,
        'sender_id'
    );
}

public function topUps()
{
    return $this->hasMany(
        TopUp::class
    );
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

    public function notifications()
{
    return $this->hasMany(Notification::class)
        ->latest();
}
}