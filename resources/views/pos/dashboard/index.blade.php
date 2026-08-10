@extends('pos.layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h3 class="fw-bold">

            Selamat Datang 👋

        </h3>

        <p class="text-muted">

            {{ $setting->business_name }}

        </p>

    </div>

    <div class="row">

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Penjualan Hari Ini

                    </small>

                    <h3 class="fw-bold text-success">

                        Rp {{ number_format($todaySales,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Transaksi Hari Ini

                    </small>

                    <h3 class="fw-bold text-primary">

                        {{ $todayTransactions }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Pendapatan Hari Ini

                    </small>

                    <h3 class="fw-bold text-info">

                        Rp {{ number_format($todayProfit,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Total Produk

                    </small>

                    <h3 class="fw-bold">

                        {{ $totalProducts }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Total Mitra

                    </small>

                    <h3 class="fw-bold">

                        {{ $totalPartners }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">

                        Produk Stok Menipis

                    </small>

                    <h3 class="fw-bold text-danger">

                        {{ $lowStock }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="row mb-4">

    <div class="col-12">

        <div class="card shadow-sm border-0">

            <div class="card-header">

                <strong>

                    📈 Penjualan 7 Hari Terakhir

                </strong>

            </div>

            <div class="card-body">

                <canvas id="salesChart" height="65"></canvas>

            </div>

        </div>

    </div>

</div>

    <div class="row mt-4">

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header">

                    <strong>

                        🏆 Produk Terlaris

                    </strong>

                </div>

                <div class="card-body">

                    @forelse($bestProducts as $product)

                        <div class="d-flex justify-content-between mb-2">

                            <span>

                                {{ $product->product_name }}

                            </span>

                            <strong>

                                {{ $product->total_sold }}

                            </strong>

                        </div>

                    @empty

                        <p class="text-muted">

                            Belum ada data.

                        </p>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header">

                    <strong>

                        🧾 Transaksi Terbaru

                    </strong>

                </div>

                <div class="table-responsive">

                    <table class="table mb-0">

                        <thead>

                            <tr>

                                <th>Invoice</th>

                                <th>Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($latestTransactions as $trx)

                                <tr>

                                    <td>

                                        {{ $trx->invoice }}

                                    </td>

                                    <td>

                                        Rp {{ number_format($trx->grand_total,0,',','.') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="2">

                                        Belum ada transaksi.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('salesChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: [

            @foreach($chartData as $item)

                '{{ $item['date'] }}',

            @endforeach

        ],

        datasets: [{

            label: 'Penjualan',
            data: [

                @foreach($chartData as $item)

                    {{ $item['total'] }},

                @endforeach

            ],

            borderColor: '#0d6efd',
            borderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 6,

            backgroundColor: 'rgba(13,110,253,.08)',

            fill: true,

            tension: 0.4

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true,

                ticks: {

                    callback: function(value) {

                        return 'Rp ' + (value / 1000) + 'K';

                    }

                }

            }

        }

    }

});

</script>

@endpush