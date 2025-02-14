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
    use hasFactory, softDeletes;

    protected $fillable = [
        'name', 'thumbnail', 'slug', 'about','price', 'stock','products', 
        'category', 'price','user_id', 'is_popular', 'brands_id'
    ];
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
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
        
        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });

        static::updating(function ($product) {
            // Log::info("Update produk: " . $product->name);
        });
    }
    public function checkout($id)
{
    $product = Product::findOrFail($id);
    return view('checkout', compact('product'));
}

    //bahwa slug adalah route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = \Str::slug($value);
    }
    
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }
}
