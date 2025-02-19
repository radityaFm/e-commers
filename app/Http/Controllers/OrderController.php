<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

    class OrderController extends Controller
{
    // Method untuk menampilkan riwayat pesanan
    public function orderHistory()
    {
        // Ambil pesanan pengguna yang sedang login beserta item dan produknya
        $orders = Order::where('user_id', auth()->id())
                       ->with('items.product')
                       ->get();

        // Tampilkan view riwayat pesanan
        return view('order.histori', compact('orders'));
    }

    // Method untuk membuat pesanan baru
    public function store(Request $request)
{
    // Debug data request
    logger('Request Data:', $request->all());

    // Validasi request
    $request->validate([
        'cart' => 'required|array',
        'cart.items' => 'required|array',
        'cart.total' => 'required|numeric',
    ]);

    // Ambil data cart dari request
    $cart = $request->input('cart');
    logger('Cart Data:', $cart);

    // Buat pesanan baru
    $order = Order::create([
        'user_id' => Auth::id(),
        'total' => $cart['total'],
        'status' => 'pending',
    ]);
    logger('Order Created:', $order->toArray());

    // Tambahkan item pesanan dari cart ke order_items
    foreach ($cart['items'] as $item) {
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['product']['price'],
        ]);
        logger('Order Item Created:', $orderItem->toArray());
    }

    // Redirect ke halaman riwayat pesanan dengan pesan sukses
    return redirect()->route('order.histori')
                     ->with('success', 'Pesanan berhasil dibuat!');
}
}