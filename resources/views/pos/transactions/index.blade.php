@extends('pos.layouts.app')

@section('title','Transaksi')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">

                Riwayat Transaksi

            </h3>

            <p class="text-muted">

                Daftar seluruh transaksi penjualan.

            </p>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Jenis</th>
                        <th>Mitra</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $transaction)

                        <tr>

                            <td>

                                {{ $transaction->invoice }}

                            </td>

                            <td>

                                {{ $transaction->created_at->format('d/m/Y H:i') }}

                            </td>

                            <td>

                                {{ $transaction->user->name }}

                            </td>
                            <td>
                                @if($transaction->sale_type == 'eceran')
                                    <span class="badge bg-primary">Eceran</span>
                                @else
                                    <span class="badge bg-warning text-dark">Mitra</span>
                                @endif
                            </td>

                            <td>

                                {{ $transaction->partner->shop_name ?? '-' }}

                            </td>

                            <td>

                                Rp {{ number_format($transaction->grand_total,0,',','.') }}

                            </td>

                            <td>
                                @if($transaction->payment_method=='cash')
                                    <span class="badge bg-success">Cash</span>
                                @elseif($transaction->payment_method=='qris')
                                    <span class="badge bg-info">QRIS</span>
                                @else
                                    <span class="badge bg-secondary">Transfer</span>
                                @endif
                            </td>

                            <td>
                                @if($transaction->payment_status == 'paid')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td class="text-nowrap">

    {{-- Detail --}}
    <a
        href="{{ route('transactions.show', $transaction) }}"
        class="btn btn-primary btn-sm">

        <i class="fas fa-eye"></i>

    </a>

    @if(Auth::user()->role == 'admin')

        <form
            action="{{ route('transactions.destroy', $transaction) }}"
            method="POST"
            class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok produk akan dikembalikan.');">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger btn-sm">

                <i class="fas fa-trash"></i>

            </button>

        </form>

    @endif

</td>
                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center py-5">

                                Belum ada transaksi.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($transactions->hasPages())

            <div class="card-footer">

                {{ $transactions->links() }}

            </div>

        @endif

    </div>

</div>

@endsection