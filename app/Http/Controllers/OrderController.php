<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
{
    // Method untuk menampilkan riwayat pesanan
    public function histori()
    {
        $user = Auth::user();
    
        $orders = Order::where('user_id', $user->id)
                       ->with(['items.product'])
                       ->get();
    
        return view('order.histori', compact('orders'));
    }    // Method untuk membuat pesanan baru
    public function store()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong.');
        }

        $totalAmount = $cartItems->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

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

            // Kurangi stok produk
            $cart->product->decreaseStock($cart->quantity);
        }

        // Hapus keranjang setelah checkout
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('order.histori', $order->id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function show(Order $order)
    {
        return view('order.histori', compact('order'));
    }
    public function checkout(Request $request)
    {
        $user = Auth::user();
    
        // Cari order yang masih pending
        $order = Order::where('user_id', $user->id)
                      ->where('status', 'pending')
                      ->first();
    
        if (!$order) {
            return redirect()->back()->with('error', 'Tidak ada pesanan untuk diproses.');
        }
    
        // Ambil item dari cart dengan relasi product
        $cartItems = $user->cart->cartItems()->with('product')->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak bisa checkout.');
        }
    
        // Hitung grand total untuk semua item
        $grandTotal = 0;
    
        foreach ($cartItems as $item) {
            // Pastikan produk valid dan memiliki harga
            if (!$item->product || !$item->product_id) {
                return redirect()->back()->with('error', 'Produk tidak valid atau sudah dihapus.');
            }
    
            // Pastikan harga produk valid
            $price = $item->product->price;
            if ($price <= 0) {
                return redirect()->back()->with('error', 'Harga produk tidak valid.');
            }
    
            // Hitung total harga per item
            $quantity = $item->quantity;
            $price = $price * $quantity;
    
            // Tambahkan ke grand total
            $grandTotal += $totalPrice;
    
            // Simpan ke order_items
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
    
            // Kurangi stok produk
            $item->product->decrement('stock', $quantity);
        }
    
        // Kosongkan cart setelah checkout
        $user->cart->cartItems()->delete();
    
        // Update status order dan grand total
        $order->update([
            'status' => 'checkout',
            'grand_total_amount' => $grandTotal,
        ]);
    
        return redirect()->route('order.histori')->with('success', 'Checkout berhasil!');
    }
}