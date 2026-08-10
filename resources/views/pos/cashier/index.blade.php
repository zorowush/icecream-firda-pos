@extends('pos.layouts.app')

@section('title', 'Transaksi')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Transaksi Penjualan
            </h3>

            <p class="text-muted mb-0">
                Pilih produk untuk mulai transaksi.
            </p>

        </div>

    </div>

    <div class="row">

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif
        <!-- Daftar Produk -->
        <div class="col-lg-8 cashier-products">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-white">

                    <div class="row">

                        <div class="col-md-8">

                            <input
                                type="text"
                                class="form-control"
                                placeholder="Cari produk...">

                        </div>

                        <div class="col-md-4">

                            <select class="form-select">

                                <option>
                                    Semua Jenis
                                </option>

                                <option value="eceran">
                                    Eceran
                                </option>

                                <option value="mitra">
                                    Mitra Warung
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row">

                        @forelse($products as $product)

                            <div class="col-12 col-sm-6 col-xl-4 mb-4">

                                <div class="card h-100 shadow-sm border-0 product-card">

                                    @if($product->image)

                                    <img
                                        src="{{ asset('storage/'.$product->image) }}"
                                        class="card-img-top product-image">

                                    @endif

                                    <div class="card-body">

                                        <h5>

                                            {{ $product->package->name }}

                                        </h5>

                                        <p class="mb-1">

                                            {{ $product->flavor->name }}

                                        </p>

                                        <p class="fw-bold text-primary">

                                            Rp {{ number_format($product->price,0,',','.') }}

                                        </p>

                                        <small class="text-muted">

                                            Stok :
                                            {{ $product->stock }}

                                        </small>

                                    </div>

                                    <div class="card-footer bg-white">

                                        <form
                                            action="{{ route('cashier.add', $product) }}"
                                            method="POST">

                                            @csrf

                                            <button
                                                class="btn btn-primary w-100">

                                                <i class="fas fa-cart-plus me-2"></i>

                                                Tambah

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="col-12 text-center py-5">

                                Tidak ada produk.

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

        <!-- Keranjang -->
        <div class="col-lg-4 cashier-cart">
            <div class="card shadow-sm border-0 h-100 cart-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        Keranjang ({{ count($cart) }})
                    </h5>
                </div>

                <div class="card-body">

                    @if(count($cart))

                        @foreach($cart as $item)

                            <div class="border-bottom pb-2 mb-3">

                                <strong>

                                    {{ $item['name'] }}

                                </strong>

                                <div class="d-flex align-items-center mt-2">

                                    <form
                                        action="{{ route('cashier.decrease', $item['id']) }}"
                                        method="POST">

                                        @csrf

                                        <button
                                            class="btn btn-sm btn-outline-secondary">

                                            -

                                        </button>

                                    </form>

                                    <span class="mx-3 fw-bold">

                                        {{ $item['qty'] }}

                                    </span>

                                    <form
                                        action="{{ route('cashier.add', $item['id']) }}"
                                        method="POST">

                                        @csrf

                                        <button
                                            class="btn btn-sm btn-outline-primary">

                                            +

                                        </button>

                                    </form>

                                </div>

                                <div class="mt-2">

                                    Rp {{ number_format($item['price'],0,',','.') }}

                                </div>

                                <strong>

                                    Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}

                                </strong>

                                <form
                                    action="{{ route('cashier.remove', $item['id']) }}"
                                    method="POST"
                                    class="mt-2">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm btn-danger">

                                        <i class="fas fa-trash me-1"></i>

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        @endforeach

                    @else

                        <div class="text-center text-muted py-5">

                            Belum ada produk.

                        </div>

                    @endif

                </div>

                <div class="card-footer">

                    <div class="d-flex justify-content-between">

                        <strong>Total</strong>

                        <strong>

                            Rp {{ number_format($total,0,',','.') }}

                        </strong>

                    </div>

                    @if(count($cart))

                        <a
                            href="{{ route('cashier.payment') }}"
                            class="btn btn-success w-100 mt-3">

                            <i class="fas fa-credit-card me-2"></i>

                            Proses Pembayaran

                        </a>

                    @else

                        <button
                            class="btn btn-success w-100 mt-3"
                            disabled>

                            Proses Pembayaran

                        </button>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection