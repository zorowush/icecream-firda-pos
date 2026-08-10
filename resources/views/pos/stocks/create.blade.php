@extends('pos.layouts.app')

@section('title','Tambah Stok')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold">Tambah Stok</h3>
            <p class="text-muted mb-0">
                Tambah stok produk.
            </p>
        </div>

        <a href="{{ route('stocks') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="{{ route('stocks.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Produk
                    </label>

                    <select
                        name="product_id"
                        class="form-select"
                        required>

                        <option value="">
                            -- Pilih Produk --
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">
                                {{ $product->code }}
                                - {{ $product->package->name }}
                                - {{ $product->flavor->name }}
                                (Stok: {{ $product->stock }})
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Jumlah Stok
                    </label>

                    <input
                        type="number"
                        name="qty"
                        class="form-control"
                        min="1"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea
                        name="note"
                        class="form-control"
                        rows="3"
                        placeholder="Contoh: Produksi hari ini"></textarea>

                </div>

                <div class="text-end">

                    <button class="btn btn-primary">

                        <i class="fas fa-save me-2"></i>

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection