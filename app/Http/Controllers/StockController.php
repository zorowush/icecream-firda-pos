<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'package',
            'flavor'
        ])->latest()->paginate(10);

        return view(
            'pos.stocks.index',
            compact('products')
        );
    }

    public function create()
    {
        $products = Product::with([
            'package',
            'flavor'
        ])->orderBy('code')->get();

        return view(
            'pos.stocks.create',
            compact('products')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        $product->increment('stock', $request->qty);

        StockHistory::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'qty' => $request->qty,
            'note' => $request->note,
        ]);

        return redirect()
            ->route('stocks')
            ->with('success', 'Stok berhasil ditambahkan.');
    }
}