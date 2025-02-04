<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // Menangani pembelian produk
    public function purchase($id, $quantity)
    {
        try {
            $product = Product::findOrFail($id);

            // Pastikan stok cukup
            if ($product->stock < $quantity) {
                return redirect()->route('user.product')->with('error', 'Stok tidak cukup');
            }

            // Mengurangi stok produk setelah pembelian
            $product->decreaseStock($quantity);

            // Mencatat transaksi pembelian
            Order::create([
                'user_id' => auth()->id(), // ID pengguna yang membeli
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            return redirect()->route('user.product')->with('success', 'Produk berhasil dibeli');
        } catch (\Exception $e) {
            return redirect()->route('user.product')->with('error', $e->getMessage());
        }
    }
}
