<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BookkeepingController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->get();

        $expenses = Expense::latest()->get();

        $totalSales = Transaction::sum('grand_total');

        $totalExpenses = Expense::sum('amount');

        $profit = $totalSales - $totalExpenses;

        return view(
            'pos.bookkeeping.index',
            compact(
                'transactions',
                'expenses',
                'totalSales',
                'totalExpenses',
                'profit'
            )
        );
    }

    public function createExpense()
    {
        return view('pos.bookkeeping.create');
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric|min:1',
            'expense_date' => 'required|date',
        ]);

        Expense::create([
            'user_id' => auth()->id(),
            'category' => $request->category,
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
        ]);

        return redirect()
            ->route('bookkeeping')
            ->with('success','Pengeluaran berhasil ditambahkan.');
    }

    public function destroyExpense(Expense $expense)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $expense->delete();

        return redirect()
            ->route('bookkeeping')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}