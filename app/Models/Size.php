<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'size',
        'products_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'products_id');
    }
}
