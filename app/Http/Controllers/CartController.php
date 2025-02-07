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
    public function index()
{// Ambil semua item dalam keranjang beserta produk yang terkait
    $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
    return view('cart', compact('cartItems'));

    // Hitung total harga keranjang
    $total = $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    // Cek apakah sedang dalam proses checkout
    $isCheckout = session('isCheckout', false);

    // Kirim data ke view
    return view('cart', compact('cartItems', 'total', 'isCheckout'));
}
public function updateCart(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $cartItem = CartItem::findOrFail($id);
    $product = $cartItem->product;

    // Hitung perubahan stok
    $oldQuantity = $cartItem->quantity;
    $newQuantity = $request->quantity;
    $difference = $newQuantity - $oldQuantity;

    // Cek apakah stok cukup
    if ($difference > 0 && $difference > $product->stock) {
        return back()->with('error', 'Stok tidak mencukupi untuk perubahan ini.');
    }

    // Update quantity
    $cartItem->update(['quantity' => $newQuantity]);

    // Kurangi atau kembalikan stok sesuai perubahan
    $product->decrement('stock', max($difference, 0));
    $product->increment('stock', min($difference, 0));

    return back()->with('success', 'Jumlah produk berhasil diperbarui.');
}
    public function remove(Request $request) {
        $cartItem = CartItem::findOrFail($id);
        $product = $cartItem->product;
    
        // Kembalikan stok saat item dihapus dari keranjang
        $product->increment('stock', $cartItem->quantity);
    
        $cartItem->delete();
    
        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
    // Menambahkan produk ke keranjang
    public function addToCart(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil produk berdasarkan ID
        $product = Product::find($validated['product_id']);

        // Cek jika stok cukup
        if ($product->stock >= $validated['quantity']) {
            // Cek apakah produk sudah ada di keranjang
            $cartItem = Cart::where('product_id', $validated['product_id'])->first();

            if ($cartItem) {
                // Jika produk sudah ada, tambahkan kuantitas
                $cartItem->quantity += $validated['quantity'];
                $cartItem->save();
            } else {
                $cartItem = new Cart();
                $cartItem->user_id = auth()->id(); // Tambahkan user_id
                $cartItem->product_id = $validated['product_id'];
                $cartItem->quantity = $validated['quantity'];
                $cartItem->save();
            }

            return redirect()->route('cart')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } else {
            return redirect()->route('user.product')->with('error', 'Stok tidak cukup.');
        }
    }

    // Melihat keranjang
    public function viewCart()
    {
        // Ambil data keranjang
        $cartItems = Cart::all(); // Semua item keranjang
        return view('cart', compact('cartItems'));
    }  
    public function showCart()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        return view('cart', compact('cartItems'));
    }
    
    public function update(Request $request)
{
    // Validasi input untuk memastikan setiap produk memiliki jumlah yang valid
    $validated = $request->validate([
        'updatedQuantities' => 'required|array', // Pastikan itu adalah array
        'updatedQuantities.*' => 'required|integer|min:1', // Setiap nilai harus integer dan minimal 1
    ]);

    // Ambil data updatedQuantities dari request
    $updatedQuantities = $request->input('updatedQuantities');

    // Loop melalui setiap produk dan perbarui jumlahnya di keranjang
    foreach ($updatedQuantities as $productId => $quantity) {
        // Debugging: log quantity before inserting/updating
        \Log::info("Product ID: {$productId}, Quantity: {$quantity}");

        // Cari item di keranjang berdasarkan user_id dan product_id
        $cartItem = Cart::where('user_id', auth()->id())->where('product_id', $productId)->first();

        if ($cartItem) {
            // Jika item ada di keranjang, perbarui jumlahnya
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            // Jika item tidak ada, tambahkan item baru ke keranjang
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,  // Pastikan memberikan nilai default jika tidak ada
            ]);
        }
    }

    // Kembalikan respons sukses
    return response()->json(['success' => true]);
}

//masih update submit, agar bisa menyimpan data berkurang atau bertambahnya input dari stock yang di masukan user 

public function checkout(Request $request)
    {
        DB::beginTransaction();

        try {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
    
            foreach ($cartItems as $item) {
                $product = $item->product;
    
                if ($product->stock >= $item->quantity) {
                    $product->stock -= $item->quantity;
                    $product->save();
                    $item->delete(); // Hapus dari keranjang
                } else {
                    throw new \Exception("Stok produk {$product->name} tidak cukup.");
                }
            }
    
            DB::commit();
            return redirect()->route('cart.index')->with('success', 'Terima kasih telah berbelanja di sini!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
}
}