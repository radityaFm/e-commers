<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan produk dengan pencarian dan filter harga
    public function show(Request $request)
    {
        // Ambil input pencarian nama produk
        $search = $request->input('search');
    
        // Query produk
        $query = Product::query();
    
        // Filter berdasarkan nama produk saja
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
    
        // Ambil hasil query
        $products = $query->get();
    
        return view('user.product', compact('products'));
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
