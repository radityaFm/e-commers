<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'slug',
        'about',
        'stock',
        'price',
        'is_popular',
        'category_id',  // Change 'category' to 'category_id' to match the foreign key in the database
        'brands_id',
    ];

    // Automatically generate slug when the name is filled
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->generateSlug();
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->generateSlug();
            }
        });
    }

    // Function to generate the slug
    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    // Get the route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Accessor for the 'is_popular' attribute
    public function getIsPopularAttribute($value)
    {
        return $value ? 'Popular' : 'Not Popular';
    }

    // Relationship with the Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    // Relationship with the Category (the correct relationship)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with the Transaction (for purchases or orders)
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Relationship with Product Photos
    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    // Relationship with Sizes (if applicable)
    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }

    // Method to display the formatted price
    public function getPriceFormatted()
    {
        return number_format($this->price, 2);
    }

    // Method to display stock status
    public function getStockStatus()
    {
        return $this->stock > 0 ? 'Available' : 'Out of stock';
    }

    // Method to decrease stock when a user buys a product
    public function decreaseStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
        } else {
            throw new \Exception("Not enough stock");
        }
    }
}
