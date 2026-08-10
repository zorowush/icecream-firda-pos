<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $transactions = Transaction::with([
            'user',
            'partner'
        ])
        ->when($start, function ($q) use ($start) {
            $q->whereDate('created_at', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('created_at', '<=', $end);
        })
        ->latest()
        ->get();

        $totalSales = $transactions->sum('grand_total');

        $totalTransactions = $transactions->count();

        $products = Product::all();

        $lowStock = $products
            ->where('stock', '<=', 10)
            ->count();

        $expenses = Expense::when($start, function ($q) use ($start) {
                $q->whereDate('expense_date', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('expense_date', '<=', $end);
            })
            ->sum('amount');
        
        $bestProducts = TransactionDetail::select(
                'product_name',
                DB::raw('SUM(qty) as total_sold')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $profit = $totalSales - $expenses;

        return view(
            'pos.reports.index',
            compact(
            'transactions',
            'totalSales',
            'totalTransactions',
            'lowStock',
            'expenses',
            'profit',
            'bestProducts',
            'start',
            'end'
        )
        );
    }

    public function exportPdf(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $transactions = Transaction::with([
            'user',
            'partner'
        ])
        ->when($start, function ($q) use ($start) {
            $q->whereDate('created_at', '>=', $start);
        })
        ->when($end, function ($q) use ($end) {
            $q->whereDate('created_at', '<=', $end);
        })
        ->latest()
        ->get();

        $totalSales = $transactions->sum('grand_total');

        $expenses = Expense::when($start, function ($q) use ($start) {
                $q->whereDate('expense_date', '>=', $start);
            })
            ->when($end, function ($q) use ($end) {
                $q->whereDate('expense_date', '<=', $end);
            })
            ->sum('amount');

        $profit = $totalSales - $expenses;

        $pdf = Pdf::loadView(
            'pos.reports.pdf',
            compact(
                'transactions',
                'totalSales',
                'expenses',
                'profit',
                'start',
                'end'
            )
        );

        return $pdf->download('laporan-icecream-firda.pdf');
    }
}