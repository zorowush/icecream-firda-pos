@extends('pos.layouts.app')

@section('title', 'Produk')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Produk Ice Cream
            </h3>

            <p class="text-muted mb-0">
                Kelola seluruh produk Ice Cream Firda.
            </p>

        </div>

        @if(Auth::user()->role == 'admin')

            <a href="{{ route('products.create') }}"
            class="btn btn-primary">

                <i class="fas fa-plus me-2"></i>

                Tambah Produk

            </a>

        @endif

    </div>

    <!-- Filter -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row align-items-end">

                    <!-- Cari -->
                    <div class="col-md-4">

                        <label class="form-label">

                            Cari Produk

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Cari kode / kemasan / rasa">

                    </div>

                    <!-- Jenis -->
                    <div class="col-md-3">

                        <label class="form-label">

                            Jenis Penjualan

                        </label>

                        <select
                            name="sale_type"
                            class="form-select">

                            <option value="">Semua</option>

                            <option
                                value="eceran"
                                @selected(request('sale_type') == 'eceran')>

                                Eceran

                            </option>

                            <option
                                value="mitra"
                                @selected(request('sale_type') == 'mitra')>

                                Mitra

                            </option>

                            <option
                                value="keduanya"
                                @selected(request('sale_type') == 'keduanya')>

                                Keduanya

                            </option>

                        </select>

                    </div>

                    @if(Auth::user()->role == 'admin')

                    <div class="col-md-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">Semua</option>

                            <option
                                value="1"
                                @selected(request('status') === '1')>

                                Aktif

                            </option>

                            <option
                                value="0"
                                @selected(request('status') === '0')>

                                Nonaktif

                            </option>

                        </select>

                    </div>

                    @endif

                    <div class="col-md-2">

                        <button
                            class="btn btn-primary w-100">

                            <i class="fas fa-search me-2"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <!-- Tabel -->
    <div class="card shadow-sm border-0">

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Kemasan</th>
                        <th>Rasa</th>
                        <th>Harga</th>
                        <th>Penjualan</th>
                        <th>Stok</th>
                        <th>Minimum</th>
                        @if(Auth::user()->role == 'admin')
                            <th>Status</th>
                        @endif
                        @if(Auth::user()->role == 'admin')
                            <th width="120">Aksi</th>
                        @endif

                    </tr>

                </thead>

                <tbody>

                @forelse($products as $product)

                    <tr>

                        <td>

                            @if($product->image)

                                <img
                                    src="{{ asset('storage/'.$product->image) }}"
                                    width="60"
                                    class="rounded">

                            @else

                                <span class="text-muted">
                                    Tidak ada foto
                                </span>

                            @endif

                        </td>

                        <td>{{ $product->code }}</td>

                        <td>{{ $product->package->name }}</td>

                        <td>{{ $product->flavor->name }}</td>

                        <td>
                            Rp {{ number_format($product->price,0,',','.') }}
                        </td>

                        <td>
                            {{ ucfirst($product->sale_type) }}
                        </td>

                        <td>

                            @if($product->stock <= $product->minimum_stock)

                                <span class="badge bg-danger">

                                    {{ $product->stock }}

                                </span>

                                <br>

                                <small class="text-danger">

                                    Stok Menipis

                                </small>

                            @else

                                {{ $product->stock }}

                            @endif

                        </td>

                        <td>
                            {{ $product->minimum_stock }}
                        </td>

                        @if(Auth::user()->role == 'admin')
                            <td>
                                @if($product->status)
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                        @endif

                        @if(Auth::user()->role == 'admin')
                            <td>
                                <a href="{{ route('products.edit', $product) }}"
                                class="btn btn-warning btn-sm">

                                    <i class="fas fa-edit"></i>

                                </a>
                                <form
                                    action="{{ route('products.destroy', $product) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm">

                                        <i class="fas fa-trash"></i> 
                                    </button>
                                </form>
                            </td>
                        @endif

                    </tr>

                @empty
                    <tr>
                        <td
                            colspan="{{ Auth::user()->role == 'admin' ? 10 : 8 }}"
                            class="text-center text-muted py-5">

                            Belum ada produk.

                        </td>
                    </tr>
                @endforelse

                </tbody>

                </table>

            </div>

            @if($products->hasPages())

                <div class="card-footer">

                    {{ $products->links() }}

                </div>

            @endif

        </div>

    </div>

@endsection