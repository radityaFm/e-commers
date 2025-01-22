<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil pesanan berdasarkan user_id pengguna yang sedang login
        $orders = Order::where('user_id', Auth::id())->get();

        return view('order.index', compact('orders'));
    }
}
