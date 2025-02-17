<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    $cartItems = CartItem::where('cart_id', $cart->id)
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

    // Pastikan pengguna sudah login
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu!');
    }

    // Ambil data produk
    $product = Product::find($validated['product_id']);

    // Cek stok produk
    if ($product->stock < $validated['quantity']) {
        return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia! Stok tersedia: ' . $product->stock);
    }

    // Dapatkan atau buat keranjang untuk pengguna yang sedang login
    $cart = Cart::firstOrCreate([
        'user_id' => auth()->id(),
    ]);

    // Cek apakah produk sudah ada di keranjang
    $cartItem = CartItem::where('cart_id', $cart->id)
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
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'status' => 'active', // Default status
        ]);
    }

    // Kurangi stok produk
    $product->decrement('stock', $validated['quantity']);

    // Redirect ke halaman keranjang dengan pesan sukses
    return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}
public function updateCart(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $cartItem = CartItem::findOrFail($id); // Jika tidak ditemukan, otomatis 404

    if (!$cartItem->product) {
        return back()->with('error', 'Produk tidak ditemukan.');
    }

    $product = $cartItem->product;
    $oldQuantity = $cartItem->quantity;
    $newQuantity = $request->quantity;
    $difference = $newQuantity - $oldQuantity;

    // Jika jumlah bertambah, cek stok tersedia
    if ($difference > 0) {
        if ($product->stock < $difference) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }
        $product->decrement('stock', $difference);
    } 
    // Jika jumlah berkurang, kembalikan stok
    elseif ($difference < 0) {
        $product->increment('stock', abs($difference));
    }

    $cartItem->update(['quantity' => $newQuantity]);

    return back()->with('success', 'Jumlah produk diperbarui.');
}
    
public function removeCart($id)
{
    try {
        DB::beginTransaction();

        // Cari keranjang pengguna
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            DB::rollBack();
            return back()->with('error', 'Keranjang tidak ditemukan.');
        }

        // Cari item dalam keranjang berdasarkan ID
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('id', $id) // ID item keranjang, bukan ID produk
            ->first();

        if (!$cartItem) {
            DB::rollBack();
            return back()->with('error', 'Item tidak ditemukan dalam keranjang.');
        }

        // Kembalikan stok produk
        $product = Product::find($cartItem->product_id);
        if ($product) {
            $product->increment('stock', $cartItem->quantity);
        }

        // Hapus item dari keranjang
        $cartItem->delete();

        // Cek apakah keranjang kosong setelah penghapusan
        if ($cart->cartItems()->count() === 0) {
            // Jika keranjang kosong, hapus keranjang (opsional)
            $cart->delete();
        }

        DB::commit();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    } catch (\Exception $e) {
        DB::rollBack();
        // Log error untuk debugging
        \Log::error('Error removing cart item: ' . $e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat menghapus produk.');
    }
}
    // Menampilkan keranjang
    public function viewCart()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        $cartItems = $cart ? CartItem::where('cart_id', $cart->id)->with('product')->get() : [];

        return view('cart', compact('cartItems'));
    }

    // Checkout - Simpan perubahan stock sebelum checkout
    public function update(Request $request)
    {
        $validated = $request->validate([
            'updatedQuantities' => 'required|array',
            'updatedQuantities.*' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('user_id', auth()->id())->first();
        if (!$cart) {
            return response()->json(['error' => 'Keranjang tidak ditemukan'], 404);
        }

        foreach ($validated['updatedQuantities'] as $productId => $quantity) {
            $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
    public function checkout(Request $request)
    {
        $userId = auth()->id();
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
    
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.']);
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($cartItems as $item) {
                $product = $item->product; // Mengambil produk dari relasi
    
                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan dalam database.");
                }
    
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok tidak cukup untuk produk: {$product->name}.");
                }
    
                // Kurangi stok produk
                $product->decrement('stock', $item->quantity);
                $product->refresh(); // Pastikan stok di-refresh setelah dikurangi
    
                // Tandai pesanan sebagai "checked_out" agar tidak bisa diedit atau dihapus lagi
                $item->update(['status' => 'checked_out']);
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil!',
                'redirect_url' => route('user.product')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Checkout error: ' . $e->getMessage()); // Log error untuk debugging
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}