<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
{
    public function index(Request $request)
    {
        $dayFilter = $request->input('day'); // Ambil filter hari dari request
        $ordersQuery = Order::with(['user', 'items.product'])->orderBy('created_at', 'desc');

        if ($dayFilter) {
            // Konversi nama hari menjadi angka (Senin = 1, Minggu = 7)
            $dayNumber = [
                'senin' => 1, 'selasa' => 2, 'rabu' => 3, 'kamis' => 4,
                'jumat' => 5, 'sabtu' => 6, 'minggu' => 7
            ][$dayFilter];

            // Filter pesanan berdasarkan hari
            $ordersQuery->whereRaw('DAYOFWEEK(created_at) = ?', [$dayNumber + 1]); // +1 karena di MySQL, Minggu = 1
        }

        $orders = $ordersQuery->get();

        return view('order', compact('orders', 'dayFilter'));
    }


    public function histori()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->with(['items.product'])->get();
        return view('order.histori', compact('orders'));
    }

    public function store()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        $totalAmount = $cartItems->sum(fn ($cart) => $cart->product->price * $cart->quantity);

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
            ]);

            $cart->product->decrement('stock', $cart->quantity);
        }

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('order.histori')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function checkout()
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status', 'pending')->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Tidak ada pesanan untuk diproses.');
        }

        $order->update(['status' => 'checkout']);

        return redirect()->route('order.histori')->with('success', 'Checkout berhasil!');
    }
}