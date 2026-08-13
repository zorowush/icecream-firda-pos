<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['package','flavor'])
            ->where('status', true)
            ->where('stock', '>', 0);

        if ($request->filled('search')) {

            $search = $request->search;

            $products->where(function ($q) use ($search) {

                $q->where('code', 'like', "%{$search}%")
                    ->orWhereHas('package', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('flavor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });

            });

        }

        if ($request->filled('sale_type')) {

            $products->where('sale_type', $request->sale_type);

        }

        $products = $products
            ->latest()
            ->get();

        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        return view('pos.cashier.index', compact(
            'products',
            'cart',
            'total'
        ));
            }

    public function addToCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {

            $cart[$product->id]['qty']++;

        } else {

            $cart[$product->id] = [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->package->name . ' - ' . $product->flavor->name,
                'price' => $product->price,
                'qty' => 1,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function decreaseQty(Product $product)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])){

            $cart[$product->id]['qty']--;

            if($cart[$product->id]['qty'] <= 0){
                unset($cart[$product->id]);
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function removeCart(Product $product)
    {
        $cart = session()->get('cart', []);

        unset($cart[$product->id]);

        session()->put('cart', $cart);

        return back();
    }

    public function payment()
    {
        $cart = session()->get('cart', []);

        if(empty($cart)){
            return redirect()->route('cashier');
        }

        $total = collect($cart)->sum(function($item){
            return $item['price'] * $item['qty'];
        });

        $partners = \App\Models\Partner::orderBy('shop_name')->get();

        return view(
            'pos.cashier.payment',
            compact(
                'cart',
                'total',
                'partners'
            )
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'sale_type' => 'required',
            'partner_id' => 'nullable|exists:partners,id',
            'payment_method' => 'required',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cashier');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        if ($request->paid_amount < $total) {

            return back()
                ->withInput()
                ->withErrors([
                    'paid_amount' => 'Uang yang dibayar kurang.'
                ]);
        }

        if (
            $request->sale_type == 'mitra' &&
            empty($request->partner_id)
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'partner_id' => 'Silakan pilih Mitra Warung.'
                ]);

        }
        
        DB::beginTransaction();

        try {

            $invoice = 'INV' . now()->format('YmdHis');
            $transaction = Transaction::create([
                'invoice' => $invoice,
                'user_id' => Auth::id(),
                'partner_id' => $request->sale_type == 'mitra'
                    ? $request->partner_id
                    : null,

                'sale_type' => $request->sale_type,

                'subtotal' => $total,
                'discount' => 0,
                'grand_total' => $total,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
            ]);
            foreach ($cart as $item) {
                TransactionDetail::create([                
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'package_name' => explode(' - ', $item['name'])[0],
                    'flavor_name' => explode(' - ', $item['name'])[1],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);
                 $product = Product::find($item['id']);
                 $product->decrement('stock', $item['qty']);
            }
            session()->forget('cart');
            DB::commit();
            return redirect()
                ->route('transactions')
                ->with('success', 'Transaksi berhasil disimpan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors($e->getMessage());

        }
    }
}