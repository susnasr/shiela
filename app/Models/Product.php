<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    BelongsToMany
};
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'images',
        'is_active',
        'category_id',
        'stock_quantity',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected $appends = ['main_image', 'final_price', 'has_active_discount'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = $product->generateSlug();
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = $product->generateSlug();
            }
        });
    }

    public function generateSlug()
    {
        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $isAdminRoute = request()->is('admin/*');

        $query = $isAdminRoute ? $this->withTrashed() : $this;

        return $query->where('slug', $value)->firstOrFail();
    }

    public function getMainImageAttribute(): string
    {
        \Log::info('Fetching main image', ['product_id' => $this->id, 'image' => $this->image]);

        if ($this->image) {

            return asset('storage/' . ltrim($this->image, '/'));
        }

        if (is_array($this->images) && count($this->images)) {
            return asset('storage/product_images/' . ltrim($this->images[0], '/'));
        }

        return asset('images/default-product.png');
    }


    public function getFinalPriceAttribute(): float
    {
        $bestDiscount = $this->activeDiscounts()->orderByDesc('value')->first();

        if ($bestDiscount) {
            return $bestDiscount->type === 'percentage'
                ? $this->price - ($this->price * ($bestDiscount->value / 100))
                : max(0, $this->price - $bestDiscount->value);
        }

        return (float) $this->price;
    }

    public function getHasActiveDiscountAttribute(): bool
    {
        return $this->activeDiscounts()->exists();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        $avg = $this->reviews()->avg('rating');
        return $avg !== null ? (float) $avg : 0.0;
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class);
    }

    public function activeDiscounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('uses_count < max_uses');
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)
            ->withDefault(['name' => 'Uncategorized']);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot(['quantity', 'price', 'attributes'])
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithDiscounts($query)
    {
        return $query->whereHas('activeDiscounts');
    }

    public function scopeWithPriceReduction($query)
    {
        return $query->whereHas('activeDiscounts', function($q) {
            $q->where(function($q) {
                $q->where('type', 'percentage')
                    ->where('value', '>', 0);
            })->orWhere(function($q) {
                $q->where('type', 'fixed')
                    ->where('value', '<', \DB::raw('products.price'));
            });
        });
    }
}
