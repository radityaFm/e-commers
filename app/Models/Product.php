<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\support\Str;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'image', 'thumbnail', 'slug', 'about', 'price', 'stock',
        'category', 'price', 'user_id', 'is_popular', 'brand_name', 'brand_logo', 'sizes'
    ];

    protected $casts = [
        'sizes' => 'array', // Cast kolom sizes ke tipe array
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_items')->withPivot('quantity');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')->withPivot('quantity', 'price', 'total_price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function decreaseStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }

    // Otomatis generate slug saat name diisi
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Bahwa slug adalah route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }
}