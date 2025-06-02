<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'subtotal',
        'discount',
        'status',
        'shipping_address',
        'payment_method',
        'carrier',
        'tracking_number'
    ];

    const STATUSES = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusColorAttribute(): string
    {
        return [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ][$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getTrackingUrlAttribute(): ?string
    {
        if (!$this->carrier || !$this->tracking_number) {
            return null;
        }

        $carriers = [
            'fedex' => 'https://www.fedex.com/fedextrack/?tracknumbers=',
            'ups' => 'https://www.ups.com/track?tracknum=',
            'usps' => 'https://tools.usps.com/go/TrackConfirmAction?tLabels=',
            'dhl' => 'https://www.dhl.com/en/express/tracking.html?AWB=',
        ];

        $carrier = strtolower($this->carrier);
        $baseUrl = $carriers[$carrier] ?? 'https://www.google.com/search?q=';

        return $baseUrl . $this->tracking_number;
    }
}
