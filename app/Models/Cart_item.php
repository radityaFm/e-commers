<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Cart_item extends Model
    {
        protected $fillable = [
            'cart_id',
            'product_id',
            'quantity',
            'total_price',
        ];

        public function cart()
        {
            return $this->belongsTo(Cart::class, 'cart_id');
        }
    
        public function product()
        {
            return $this->belongsTo(Product::class, 'product_id');
        }
        public function isCheckedOut()
        {
            return $this->status === 'checked_out';
        }
    public function getTotal()
    {
        return $this->items->sum(fn($item) => $item->product->price * $item->quantity);
    }

}
