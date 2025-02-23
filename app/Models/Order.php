<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;

class Order extends Model
{
    protected $fillable = [ 'user_id', 'status', 'grand_total_amount',];

    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}