<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class CartItem extends Model
    {
        use HasFactory;
    
        protected $fillable = ['cart_id', 'product_id', 'quantity', 'status']; // Pastikan ada kolom 'status'

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isCheckedOut()
    {
        return $this->status === 'checked_out';
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id'); // Relasi reverse ke Cart
    }
    public function getTotal()
    {
        return $this->items->sum(fn($item) => $item->product->price * $item->quantity);
    }

}
