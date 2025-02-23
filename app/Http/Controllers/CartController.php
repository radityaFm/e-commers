<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Cart_item;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
{
    $cart = Cart::where('user_id', auth()->id())->first();

    if (!$cart) {
        return view('cart', [
            'cartItems' => collect(), 
            'total' => 0, 
            'isCheckout' => session()->get('isCheckout', false)
        ]);
    }

    $cartItems = Cart_item::where('cart_id', $cart->id)
                         ->with('product')
                         ->get();

    // Hitung total harga, pastikan produk tidak null
    $total = $cartItems->sum(fn($item) => optional($item->product)->price * $item->quantity ?? 0);

    return view('cart', compact('cartItems', 'total'))->with('isCheckout', session()->get('isCheckout', false));
}
public function addToCart(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);
    $product = Product::where('id', $validated['product_id'])->first();
    $totalPrice = $validated['quantity'] * $product->price;
    // Pastikan pengguna sudah login
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu!');
    }
    // Ambil data produk

    // Cek stok produk
    if ($product->stock < $validated['quantity']) {
        return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia! Stok tersedia: ' . $product->stock);
    }

    // Dapatkan atau buat keranjang untuk pengguna yang sedang login
    $cart = Cart::firstOrCreate([
        'user_id' => auth()->id(),
    ]);

    // Cek apakah produk sudah ada di keranjang
    $cartItem = Cart_item::where('cart_id', $cart->id)
        ->where('product_id', $validated['product_id'])
        ->first();

    if ($cartItem) {
        // Jika produk sudah ada, update jumlahnya
        $newQuantity = $cartItem->quantity + $validated['quantity'];

        // Cek stok lagi setelah penambahan quantity
        if ($product->stock < $newQuantity) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia! Stok tersedia: ' . $product->stock);
        }

        $cartItem->update([
            'quantity' => $newQuantity,
        ]);
    } else {
        // Jika produk belum ada, tambahkan sebagai item baru
        Cart_item::create([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice
        ]);
    }

    // Redirect ke halaman keranjang dengan pesan sukses
    return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}
public function updateCart(Request $request, $id)
{
    // Validasi input quantity
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    // Cari item keranjang berdasarkan ID
    $cartItem = Cart_item::findOrFail($id); // Jika tidak ditemukan, otomatis 404

    // Pastikan produk terkait ada
    if (!$cartItem->product) {
        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.']);
    }

    $product = $cartItem->product;
    $oldQuantity = $cartItem->quantity;
    $newQuantity = $request->quantity;
    $difference = $newQuantity - $oldQuantity;

    // Jika jumlah berubah
    if ($difference != 0) {
        // Jika jumlah bertambah, cek stok tersedia
        if ($difference > 0) {
            if ($product->stock < $difference) {
                return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.']);
            }
            $product->decrement('stock', $difference); // Kurangi stok
        } 
        // Jika jumlah berkurang, kembalikan stok
        elseif ($difference < 0) {
            $product->increment('stock', abs($difference)); // Tambahkan stok
        }

        // Hitung ulang harga total
        $unitPrice = $product->price;
        if ($unitPrice <= 0) {
            return response()->json(['success' => false, 'message' => 'Harga produk tidak valid.']);
        }
        $totalPrice = $unitPrice * $newQuantity;

        // Update quantity dan total price di cart item
        $cartItem->update([
            'quantity' => $newQuantity,
            'total_price' => $totalPrice // Pastikan kolom 'total_price' ada di tabel cart_items
        ]);

        // Update order_items yang terkait dengan cart_item ini
        $cartItem->orderItems()->each(function ($orderItem) use ($newQuantity, $unitPrice, $totalPrice) {
            $orderItem->update([
                'quantity' => $newQuantity,
                'price' => $unitPrice,
            ]);
        });
    }

    return response()->json(['success' => true, 'message' => 'Jumlah produk diperbarui.']);
}
public function removeCart($id)
{
    try {
        DB::beginTransaction();

        if (!auth()->check()) {
            return back()->with('error', 'Anda harus login terlebih dahulu.');
        }

        $cart = Cart::where('user_id', auth()->id())->first();
        if (!$cart) {
            DB::rollBack();
            return back()->with('error', 'Keranjang tidak ditemukan.');
        }

        $cartItem = Cart_item::where('id', $id)->first();
        if (!$cartItem) {
            DB::rollBack();
            return back()->with('error', 'Item tidak ditemukan dalam keranjang.');
        }

        $cartItem->delete();

        // if ($cart->cartItems()->count() === 0) {
        //     $cart->delete();
        // }

        DB::commit();
        return redirect()->route('cart')->with('success', 'sukses delete');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error removing cart item: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat menghapus produk.');
    }
}
    // Menampilkan keranjang
    public function viewCart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        $cartItems = $cart ? Cart_item::where('cart_id', $cart->id)->with('product')->get() : [];

        return view('cart', compact('cartItems'));
    }
     // Proses checkout
     public function checkout(Request $request)
     {
         // Ambil cart milik user yang sedang login
         $cart = Cart::where('user_id', auth()->id())->first();
         $cartItems = Cart_item::where('cart_id', $cart->id)->get();
         if (!$cart || $cartItems->isEmpty()) {
             return redirect()->route('cart')->with('error', 'Keranjang kosong!');
         }
 
         // Buat order baru
         $order = Order::create([
             'user_id' => auth()->id(),
             'status' => 'completed', // Status selesai
             'total' => $cart->cartItems->sum(fn($item) => $item->quantity * $item->product->price), // Hitung total harga
         ]);
 
         // Pindahkan item dari cart ke order
         foreach ($cartItems as $item) {
             OrderItem::create([
                 'order_id' => $order->id,
                 'product_id' => $item->product_id,
                 'quantity' => $item->quantity,
                 'price' => $item->product->price,
             ]);
 
             // Kurangi stok produk
             $product = Product::find($item->product_id);
             if ($product) {
                 $product->decrement('stock', $item->quantity);
             }
             $item->delete();
         }
 
         // Hapus semua item dari cart
         $cart->cartItems()->delete();
 
         return redirect()->route('cart')->with('success', 'Checkout berhasil!');
     }
 } 