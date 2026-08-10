@extends('pos.layouts.app')

@section('title','Detail Transaksi')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Detail Transaksi</h3>
        <p class="text-muted mb-0">
            Informasi lengkap transaksi penjualan.
        </p>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('transactions.print',$transaction) }}"
            class="btn btn-success">

            <i class="fas fa-print me-2"></i>
            Cetak Struk

        </a>

        <a href="{{ route('transactions') }}"
            class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

</div>

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Invoice</th>
                            <td>{{ $transaction->invoice }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        </tr>

                        <tr>
                            <th>Kasir</th>
                            <td>{{ $transaction->user->name }}</td>
                        </tr>

                        <tr>
                            <th>Jenis Penjualan</th>
                            <td>{{ ucfirst($transaction->sale_type) }}</td>
                        </tr>

                        <tr>
                            <th>Mitra Warung</th>

                            <td>

                                {{ $transaction->partner->shop_name ?? '-' }}

                            </td>

                        </tr>

                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ strtoupper($transaction->payment_method) }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header">

            <strong>Daftar Produk</strong>

        </div>

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>

                        <th>Produk</th>
                        <th>Kemasan</th>
                        <th>Rasa</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($transaction->details as $detail)

                        <tr>

                            <td>{{ $detail->product_name }}</td>

                            <td>{{ $detail->package_name }}</td>

                            <td>{{ $detail->flavor_name }}</td>

                            <td>{{ $detail->qty }}</td>

                            <td>
                                Rp {{ number_format($detail->price,0,',','.') }}
                            </td>

                            <td>
                                Rp {{ number_format($detail->subtotal,0,',','.') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="card-footer">

            <div class="row justify-content-end">

                <div class="col-md-4">

                    <table class="table table-borderless mb-0">

                        <tr>

                            <th>Subtotal</th>

                            <td class="text-end">

                                Rp {{ number_format($transaction->subtotal,0,',','.') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Diskon</th>

                            <td class="text-end">

                                Rp {{ number_format($transaction->discount,0,',','.') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Grand Total</th>

                            <td class="text-end fw-bold">

                                Rp {{ number_format($transaction->grand_total,0,',','.') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Dibayar</th>

                            <td class="text-end">

                                Rp {{ number_format($transaction->paid_amount,0,',','.') }}

                            </td>

                        </tr>

                        <tr>

                            <th>Kembalian</th>

                            <td class="text-end text-success fw-bold">

                                Rp {{ number_format($transaction->change_amount,0,',','.') }}

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection