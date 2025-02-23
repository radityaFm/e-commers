<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [ 'order_id', 'product_id', 'quantity', 'price', 'total_price',];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}