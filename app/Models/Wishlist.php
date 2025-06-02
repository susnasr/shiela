<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_id'];

    /**
     * Enable timestamps for created_at and updated_at.
     */
    public $timestamps = true;

    /**
     * Automatically eager load product relationship.
     */
    protected $with = ['product'];

    /**
     * Wishlist belongs to a product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Wishlist belongs to a user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for wishlist items where the product is on sale.
     */
    public function scopeOnSale($query)
    {
        return $query->whereHas('product', function ($q) {
            $q->where('discount_price', '>', 0);
        });
    }
}
