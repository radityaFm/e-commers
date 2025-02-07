<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderNotification;

class ProductTransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'city' => 'required|string',
            'address' => 'required|string',
            'post_code' => 'required|string',
            'sub_total_amount' => 'required|numeric',
            'grand_total_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'proof' => 'nullable|image|max:2048',
        ]);

        $bookingTrxId = ProductTransaction::generateUniqueBookingTrxId();

        // Simpan transaksi ke database
        $transaction = new ProductTransaction();
        $transaction->product_id = $request->product_id;
        $transaction->quantity = $request->quantity;
        $transaction->city = $request->city;
        $transaction->address = $request->address;
        $transaction->post_code = $request->post_code;
        $transaction->sub_total_amount = $request->sub_total_amount;
        $transaction->grand_total_amount = $request->grand_total_amount;
        $transaction->discount_amount = $request->discount_amount ?? 0;
        $transaction->booking_trx_id = $bookingTrxId;
        $transaction->is_paid = false;
        
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
            $transaction->proof = $proofPath;
        }

        $transaction->save();

        return redirect()->route('thankyou')->with('success', 'Pesanan berhasil dibuat dan sedang diproses.');
    }

    public function index()
    {
        // Menampilkan semua transaksi produk
        $transactions = ProductTransaction::with('product')->get();
        return view('admin.productTransactions', compact('transactions'));
    }
}