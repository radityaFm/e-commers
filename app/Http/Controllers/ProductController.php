<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
        public function show()
        {
            $products = Product::all(); // Ambil semua produk
        
            return view('user.product', ['products' => $products]);
        }
        

    // Menangani pembelian produk
    public function purchase($id, $quantity)
    {
        try {
            // Ambil produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Cek apakah stok cukup
            if ($product->stock >= $quantity) {
                // Kurangi stok
                $product->decreaseStock($quantity);

                // Lakukan pembelian, misalnya menyimpan transaksi ke database (tambahkan kode sesuai kebutuhan)

                return redirect()->route('user.product')->with('success', 'Product purchased successfully!');
            } else {
                return redirect()->route('user.product')->with('error', 'Not enough stock available.');
            }
        } catch (\Exception $e) {
            // Tangani error jika produk tidak ditemukan atau terjadi kesalahan
            return redirect()->route('user.product')->with('error', $e->getMessage());
        }
    }
}
