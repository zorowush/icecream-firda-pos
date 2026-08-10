<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);

        return view(
            'pos.transactions.index',
            compact('transactions')
        );
    }

    public function show(Transaction $transaction)
    {
        $transaction->load([
            'details',
            'user',
            'partner'
        ]);

        return view(
            'pos.transactions.show',
            compact('transaction')
        );
    }

    public function print(Transaction $transaction)
    {
        $transaction->load([
            'details',
            'user',
            'partner'
        ]);

        $setting = Setting::first();

        return view(
            'pos.transactions.print',
            compact(
                'transaction',
                'setting'
            )
        );
    }

    public function destroy(Transaction $transaction)
    {
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

        DB::beginTransaction();

        try {

            $transaction->load('details');

            foreach ($transaction->details as $detail) {

                if ($detail->product) {

                    $detail->product->increment('stock', $detail->qty);

                }

            }

            $transaction->details()->delete();

            $transaction->delete();

            DB::commit();

            return redirect()
                ->route('transactions')
                ->with('success', 'Transaksi berhasil dihapus.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors(
                'Gagal menghapus transaksi.'
            );

        }
    }
}