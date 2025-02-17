<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('user')->except(['show']);
    }

    public function show()
    {
        $products = Product::all();
        return view('user.product', compact('products'));
    }
    public function index()
{
    if (!Auth::check()) {
        return redirect()->route('user.product')->with('error', 'Maaf, Anda belum login. Silakan login terlebih dahulu.');
    }

    $products = Product::all();
    return view('user.product', compact('products'));
}

    public function purchase(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);
    
            $product = Product::findOrFail($id);
            $quantity = (int) $request->input('quantity');
    
            if ($product->stock >= $quantity) {
                // Kurangi stok produk
                $product->decrement('stock', $quantity);
    
                return redirect()->route('user.product')->with('success', 'Produk berhasil dibeli!');
            } else {
                return redirect()->route('user.product')->with('error', 'Stok tidak cukup.');
            }
        } catch (\Exception $e) {
            return redirect()->route('user.product')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }    
}
