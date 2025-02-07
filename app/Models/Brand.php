<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

   // Otomatis generate slug saat name diisi
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($brand) {
            $brand->slug = Str::slug($brand->name);
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    //bahwa slug adalah route key name
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
