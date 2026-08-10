@extends('pos.layouts.app')

@section('title','Stok Produk')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Stok Produk
            </h3>

            <p class="text-muted mb-0">
                Kelola stok produk Ice Cream Firda.
            </p>

        </div>

        @if(auth()->user()->role == 'admin')

            <a href="{{ route('stocks.create') }}"
                class="btn btn-primary">

                <i class="fas fa-plus me-2"></i>

                Tambah Stok

            </a>

        @endif

    </div>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Kode</th>
                        <th>Produk</th>
                        <th>Kemasan</th>
                        <th>Rasa</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>

                            <td>{{ $product->code }}</td>

                            <td>{{ $product->package->name }} {{ $product->flavor->name }}</td>

                            <td>{{ $product->package->name }}</td>

                            <td>{{ $product->flavor->name }}</td>

                            <td>
                                Rp {{ number_format($product->price,0,',','.') }}
                            </td>

                            <td>{{ $product->stock }}</td>

                            <td>

                                @if($product->stock == 0)

                                    <span class="badge bg-danger">
                                        Habis
                                    </span>

                                @elseif($product->stock <= 10)

                                    <span class="badge bg-warning text-dark">
                                        Hampir Habis
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        Aman
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                Belum ada produk.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer">

            {{ $products->links() }}

        </div>

    </div>

</div>

@endsection