@extends('pos.layouts.app')

@section('title','Tambah Pengeluaran')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            Tambah Pengeluaran
        </h3>

         <a href="{{ route('bookkeeping') }}"
           class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form
                action="{{ route('bookkeeping.expense.store') }}"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label>Kategori</label>

                    <input
                        type="text"
                        name="category"
                        class="form-control"
                        placeholder="Contoh : Bahan Baku"
                        required>

                </div>

                <div class="mb-3">

                    <label>Keterangan</label>

                    <textarea
                        name="description"
                        class="form-control"
                        required></textarea>

                </div>

                <div class="mb-3">

                    <label>Nominal</label>

                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label>Tanggal</label>

                    <input
                        type="date"
                        name="expense_date"
                        class="form-control"
                        value="{{ date('Y-m-d') }}"
                        required>

                </div>

                <div class="d-flex justify-content-end">

    <button
        type="submit"
        class="btn btn-primary">

        <i class="fas fa-save me-2"></i>
        Simpan

    </button>

</div>

            </form>

        </div>

    </div>

</div>

@endsection