<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BookkeepingController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Kasir
    Route::get('/kasir', [CashierController::class, 'index'])
        ->name('cashier');
    Route::post('/kasir/tambah/{product}', [CashierController::class, 'addToCart'])
        ->name('cashier.add');
    Route::post('/kasir/kurang/{product}', [CashierController::class, 'decreaseQty'])
        ->name('cashier.decrease');
    Route::delete('/kasir/hapus/{product}', [CashierController::class, 'removeCart'])
        ->name('cashier.remove');
    Route::get('/kasir/pembayaran', [CashierController::class, 'payment'])
        ->name('cashier.payment');
    Route::post('/kasir/checkout', [CashierController::class,'checkout'])
        ->name('cashier.checkout');

    // Produk
    Route::get('/produk', [ProductController::class, 'index'])
        ->name('products');
    Route::get('/produk/create', [ProductController::class, 'create'])
    ->name('products.create');
    Route::post('/produk', [ProductController::class, 'store'])
        ->name('products.store');
    Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/produk/{product}', [ProductController::class, 'update'])
        ->name('products.update'); 
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    // Mitra Warung
    Route::get('/mitra-warung', [PartnerController::class, 'index'])
        ->name('partners');
    Route::get('/mitra-warung/create', [PartnerController::class, 'create'])
        ->name('partners.create');
    Route::post('/mitra-warung', [PartnerController::class, 'store'])
        ->name('partners.store');
    Route::get('/mitra-warung/{partner}/edit', [PartnerController::class, 'edit'])
        ->name('partners.edit');
    Route::put('/mitra-warung/{partner}', [PartnerController::class, 'update'])
        ->name('partners.update');
    Route::delete('/mitra-warung/{partner}', [PartnerController::class, 'destroy'])
        ->name('partners.destroy');

    // Stok
    Route::get('/stok', [StockController::class, 'index'])
        ->name('stocks');
    Route::get('/stok/create', [StockController::class,'create'])
        ->name('stocks.create');
    Route::post('/stok', [StockController::class,'store'])
        ->name('stocks.store');

    // Transaksi
    Route::get('/transaksi', [TransactionController::class, 'index'])
        ->name('transactions');
    Route::get('/transaksi/{transaction}', [TransactionController::class, 'show'])
        ->name('transactions.show');
    Route::get('/transaksi/{transaction}/print', [TransactionController::class, 'print'])
        ->name('transactions.print');
    Route::delete('/transaksi/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');
    

    // Pembukuan
    Route::get('/pembukuan', [BookkeepingController::class, 'index'])
        ->name('bookkeeping');
    Route::get('/pembukuan/pengeluaran/create',[BookkeepingController::class,'createExpense'])
        ->name('bookkeeping.expense.create');
    Route::post('/pembukuan/pengeluaran/store',[BookkeepingController::class,'storeExpense'])
        ->name('bookkeeping.expense.store');
   Route::delete('/pembukuan/pengeluaran/{expense}',[BookkeepingController::class, 'destroyExpense'])
    ->name('bookkeeping.expense.destroy');

    // Laporan
    Route::get('/laporan', [ReportController::class, 'index'])
        ->name('reports');
    Route::get('/laporan/pdf', [ReportController::class, 'exportPdf'])
        ->name('reports.pdf');

    // Pengaturan
    Route::get('/pengaturan', [SettingController::class, 'index'])
        ->name('settings');
    Route::put('/pengaturan', [SettingController::class, 'update'])
        ->name('settings.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';