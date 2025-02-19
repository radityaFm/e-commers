<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
        protected $fillable = [
             'user_id', 'product_id', 'quantity', 'is_fixed', 'expires_at'
        ];
    
        public function product()
        {
            return $this->belongsTo(Product::class);
        }
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product')->withPivot('quantity');
    }    
    // Method untuk menghitung total harga
    public function getTotal()
    {
        return $this->items->sum(fn($item) => $item->product->price * $item->quantity);
    }
}
