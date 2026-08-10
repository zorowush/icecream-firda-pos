<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Partner;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $setting = Setting::first();

        // Penjualan hari ini
        $todaySales = Transaction::whereDate('created_at', $today)
            ->sum('grand_total');

        // Jumlah transaksi hari ini
        $todayTransactions = Transaction::whereDate('created_at', $today)
            ->count();

        // Pengeluaran hari ini
        $todayExpenses = Expense::whereDate('created_at', $today)
            ->sum('amount');

        // Pendapatan hari ini
        $todayProfit = $todaySales - $todayExpenses;

        // Total produk
        $totalProducts = Product::count();

        // Total mitra
        $totalPartners = Partner::count();

        // Minimum stok dari pengaturan
        $minimumStock = $setting->minimum_stock ?? 10;

        // Jumlah produk stok menipis
        $lowStock = Product::where('stock', '<=', $minimumStock)
            ->count();

        // Produk terlaris
        $bestProducts = DB::table('transaction_details')
            ->select(
                'product_name',
                DB::raw('SUM(qty) as total_sold')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // 5 transaksi terbaru
        $latestTransactions = Transaction::latest()
            ->take(5)
            ->get();
        
        // Grafik penjualan 7 hari terakhir
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $total = Transaction::whereDate('created_at', $date)
                ->sum('grand_total');

            $chartData[] = [
                'date' => $date->format('d M'),
                'total' => $total,
            ];
        }

        return view('pos.dashboard.index', compact(
            'setting',
            'todaySales',
            'todayTransactions',
            'todayProfit',
            'totalProducts',
            'totalPartners',
            'lowStock',
            'bestProducts',
            'latestTransactions',
            'chartData'
        ));
    }
}