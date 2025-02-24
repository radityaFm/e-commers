<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;

class Order extends Model
{
    protected $fillable = [ 'user_id', 'status',];

    public function items()
{
    return $this->hasMany(OrderItem::class);
}


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function index()
{
    $orders = Order::all(); // Ambil semua pesanan
    return view('order.index', compact('orders'));
}

public function show($orderId)
{
    $order = Order::findOrFail($orderId);
    return view('order.show', compact('order'));
}
}