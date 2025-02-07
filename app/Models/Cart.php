<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    // Relasi ke CartItem
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relasi ke Product melalui CartItem
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');    }
    // Method untuk menghitung total harga
    public function getTotal()
    {
        return $this->items->sum(fn($item) => $item->product->price * $item->quantity);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
