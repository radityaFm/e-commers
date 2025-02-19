<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

class OrderController extends Controller
{

    public function orderHistory()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->get();

        return view('order.histori', compact('orders'));
    }
}