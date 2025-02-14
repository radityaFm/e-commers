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

    // Menambahkan produk ke keranjang
    public function addToCart(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $cart = Cart::firstOrCreate([
        'user_id' => auth()->id(),
    ]);

    $cartItem = CartItem::where('cart_id', $cart->id)
        ->where('product_id', $validated['product_id'])
        ->first();

    if ($cartItem) {
        // Jika sudah ada, update jumlahnya
        $cartItem->update([
            'quantity' => $cartItem->quantity + $validated['quantity']
        ]);
    } else {
        // Jika belum ada, tambahkan item baru
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
        ]);
    }

    return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}
public function updateCart(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $cartItem = CartItem::find($id);

    if (!$cartItem) {
        return back()->with('error', 'Item tidak ditemukan.');
    }

    $product = $cartItem->product;
    $oldQuantity = $cartItem->quantity;
    $newQuantity = $request->quantity;
    $difference = $newQuantity - $oldQuantity;

    if ($difference > 0 && $product->stock < $difference) {
        return back()->with('error', 'Stok tidak mencukupi.');
    }

    $cartItem->update(['quantity' => $newQuantity]);
    $product->decrement('stock', max($difference, 0));
    $product->increment('stock', min($difference, 0));

    return back()->with('success', 'Jumlah produk diperbarui.');
}

    // Menghapus item dari keranjang
    public function removeCart($id)
    {
        $cartItem = CartItem::find($id);
    
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
        }
    
        // Kembalikan stok saat dihapus
        $cartItem->product->increment('stock', $cartItem->quantity);
        $cartItem->delete();
    
        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
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
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }             
}