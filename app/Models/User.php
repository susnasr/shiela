<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Roles constants for easy reference
    public const ROLE_ADMIN = 'admin';
    public const ROLE_BUYER = 'buyer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'name' => 'Guest User',
        'role' => self::ROLE_BUYER, // Default role changed to 'buyer'
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is buyer
     */
    public function isBuyer(): bool
    {
        return $this->role === self::ROLE_BUYER;
    }

    /**
     * Get display name (with fallback)
     */
    public function getNameAttribute($value): string
    {
        return $value ?? $this->attributes['name'];
    }

    /**
     * User's orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->latest();
    }

    /**
     * User's wishlist items
     */
    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * User's cart items
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class)->with('product');
    }

    /**
     * Get cart total
     */
    public function getCartTotalAttribute(): float
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Get cart item count
     */
    public function getCartCountAttribute(): int
    {
        return $this->cartItems->sum('quantity');
    }

    /**
     * Fallback empty cart item
     */
    public function firstCartItemOrDefault(): CartItem
    {
        return $this->cartItems->first() ?? new CartItem([
            'id' => 0,
            'user_id' => null,
            'product_id' => null,
            'quantity' => 0,
        ]);
    }
}
