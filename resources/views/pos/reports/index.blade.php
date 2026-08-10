@extends('pos.layouts.app')

@section('title','Laporan')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Laporan
            </h3>

            <p class="text-muted mb-0">
                Ringkasan penjualan, pengeluaran, dan stok produk.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('reports.pdf',[
                    'start_date'=>$start,
                    'end_date'=>$end
                ]) }}"
                class="btn btn-danger">

                <i class="fas fa-file-pdf me-2"></i>

                Export PDF

            </a>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    {{-- Filter --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    <div class="col-md-4">

                        <label class="form-label">
                            Dari Tanggal
                        </label>

                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Sampai Tanggal
                        </label>

                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-4">

                        <button class="btn btn-primary w-100">

                            <i class="fas fa-search me-2"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Ringkasan --}}
    <div class="row mb-4">

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Total Penjualan
                    </small>

                    <h3 class="fw-bold text-success mt-2">

                        Rp {{ number_format($totalSales,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Jumlah Transaksi
                    </small>

                    <h3 class="fw-bold text-primary mt-2">

                        {{ $totalTransactions }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Total Pengeluaran
                    </small>

                    <h3 class="fw-bold text-danger mt-2">

                        Rp {{ number_format($expenses,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <small class="text-muted">
                        Laba Bersih
                    </small>

                    <h3 class="fw-bold text-info mt-2">

                        Rp {{ number_format($profit,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    {{-- Informasi Stok --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">

                        Produk Stok Menipis

                    </h5>

                    <small class="text-muted">

                        Produk dengan stok ≤ 10

                    </small>

                </div>

                <h2 class="text-warning fw-bold">

                    {{ $lowStock }}

                </h2>

            </div>

        </div>

    </div>

    {{-- Riwayat --}}
    <div class="card shadow-sm border-0">

        <div class="card-header">

            <strong>

                Riwayat Transaksi

            </strong>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Kasir</th>
                        <th>Jenis</th>
                        <th>Mitra</th>
                        <th>Total</th>
                        <th>Pembayaran</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $transaction)

                        <tr>

                            <td>

                                {{ $transaction->created_at->format('d/m/Y') }}

                            </td>

                            <td>

                                {{ $transaction->invoice }}

                            </td>

                            <td>

                                {{ $transaction->user->name }}

                            </td>

                            <td>

                                @if($transaction->sale_type == 'mitra')

                                    <span class="badge bg-warning text-dark">

                                        Mitra

                                    </span>

                                @else

                                    <span class="badge bg-primary">

                                        Eceran

                                    </span>

                                @endif

                            </td>

                            <td>

                                {{ $transaction->partner->shop_name ?? '-' }}

                            </td>

                            <td>

                                Rp {{ number_format($transaction->grand_total,0,',','.') }}

                            </td>

                            <td>

                                {{ strtoupper($transaction->payment_method) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted">

                                Belum ada data laporan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header">

            <strong>
                Produk Terlaris
            </strong>

        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th width="80">
                            Ranking
                        </th>

                        <th>
                            Produk
                        </th>

                        <th class="text-end">
                            Total Terjual
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($bestProducts as $index => $product)

                        <tr>

                            <td>

                                #{{ $index + 1 }}

                            </td>

                            <td>

                                {{ $product->product_name }}

                            </td>

                            <td class="text-end">

                                {{ $product->total_sold }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="3" class="text-center py-4">

                                Belum ada data penjualan.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection