<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionItemController extends Controller
{
    public function index()
    {
        $transactionItems = TransactionItem::with(['productTransaction', 'product'])->get();
        return response()->json($transactionItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producttransaction_id' => 'required|exists:ctions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $transactionItem = TransactionItem::create($request->all());

        return response()->json([
            'message' => 'Transaction Item Created Successfully!',
            'data' => $transactionItem
        ], 201);
    }

    public function show($id)
    {
        $transactionItem = TransactionItem::with(['productTransaction', 'product'])->findOrFail($id);
        return response()->json($transactionItem);
    }

    public function update(Request $request, $id)
    {
        $transactionItem = TransactionItem::findOrFail($id);

        $request->validate([
            'quantity' => 'integer|min:1',
            'price' => 'numeric|min:0',
            'subtotal' => 'numeric|min:0',
        ]);

        $transactionItem->update($request->all());

        return response()->json([
            'message' => 'Transaction Item Updated Successfully!',
            'data' => $transactionItem
        ]);
    }

    public function destroy($id)
    {
        $transactionItem = TransactionItem::findOrFail($id);
        $transactionItem->delete();

        return response()->json([
            'message' => 'Transaction Item Deleted Successfully!'
        ]);
    }
}
