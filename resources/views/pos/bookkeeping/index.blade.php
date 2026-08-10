@extends('pos.layouts.app')

@section('title','Pembukuan')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Pembukuan
            </h3>

            <p class="text-muted mb-0">
                Ringkasan pemasukan dan pengeluaran.
            </p>

        </div>

        @if(auth()->user()->role == 'admin')

            <a href="{{ route('bookkeeping.expense.create') }}"
                class="btn btn-primary">

                <i class="fas fa-plus me-2"></i>

                Tambah Pengeluaran

            </a>

        @endif

    </div>

    {{-- Card Ringkasan --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Penjualan
                    </h6>

                    <h3 class="fw-bold text-success">

                        Rp {{ number_format($totalSales,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Pengeluaran
                    </h6>

                    <h3 class="fw-bold text-danger">

                        Rp {{ number_format($totalExpenses,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Laba Bersih
                    </h6>

                    <h3 class="fw-bold text-primary">

                        Rp {{ number_format($profit,0,',','.') }}

                    </h3>

                </div>

            </div>

        </div>

    </div>
    

    {{-- Riwayat Pembukuan --}}
    <div class="card shadow-sm border-0">

        <div class="card-header">

            <strong>Riwayat Pembukuan</strong>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th class="text-end">Nominal</th>

                        @if(auth()->user()->role == 'admin')
                        <th width="80" class="text-center">Aksi</th>
                        @endif

                    </tr>

                </thead>

                <tbody>

                    {{-- Penjualan --}}
                    @foreach($transactions as $transaction)

                        <tr>

                            <td>

                                {{ $transaction->created_at->format('d/m/Y') }}

                            </td>

                            <td>

                                <span class="badge bg-success">

                                    Penjualan

                                </span>

                            </td>

                            <td>

                                {{ $transaction->invoice }}

                            </td>

                            <td class="text-end text-success fw-bold">

                                + Rp {{ number_format($transaction->grand_total,0,',','.') }}

                            </td>

                        </tr>

                    @endforeach

                    {{-- Pengeluaran --}}
                    @foreach($expenses as $expense)

                        <tr>

                            <td>

                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}

                            </td>

                            <td>

                                <span class="badge bg-danger">

                                    Pengeluaran

                                </span>

                            </td>

                            <td>

                                {{ $expense->description }}

                            </td>

                            <td class="text-end text-danger fw-bold">

                                - Rp {{ number_format($expense->amount,0,',','.') }}

                            </td>

                            @if(auth()->user()->role == 'admin')

<td class="text-center">

    <form
        action="{{ route('bookkeeping.expense.destroy', $expense) }}"
        method="POST"
        onsubmit="return confirm('Hapus data pengeluaran ini?')">

        @csrf
        @method('DELETE')

        <button
            class="btn btn-danger btn-sm">

            <i class="fas fa-trash"></i>

        </button>

    </form>

</td>

@endif

                        </tr>

                    @endforeach

                    @if($transactions->isEmpty() && $expenses->isEmpty())

                        <tr>

                            <td colspan="4" class="text-center py-5 text-muted">

                                Belum ada data pembukuan.

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection