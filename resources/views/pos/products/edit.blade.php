@extends('pos.layouts.app')

@section('title','Edit Produk')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Edit Produk
            </h3>

            <p class="text-muted">
                Perbarui data produk Ice Cream Firda.
            </p>

        </div>

        <a href="{{ route('products') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

         @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif
            <form action="{{ route('products.update', $product) }}"
                    method="POST"
                    enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Kode -->
                    <div class="col-12 mb-4">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Kode produk tidak dapat diubah.
                        </div>
                    </div>

                    <!-- Kemasan -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Kemasan

                        </label>

                        <select
                            class="form-select"
                            disabled>

                            <option value="">

                                Pilih Kemasan

                            </option>

                            @foreach($packages as $package)

                                <option
                                    value="{{ $package->id }}"
                                    @selected(old('package_id', $product->package_id) == $package->id)>
                                    {{ $package->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Rasa -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Rasa

                        </label>

                        <select
                            class="form-select"
                            disabled>

                            <option value="">

                                Pilih Rasa

                            </option>

                            @foreach($flavors as $flavor)

                                <option
                                    value="{{ $flavor->id }}"
                                    @selected(old('flavor_id', $product->flavor_id) == $flavor->id)

                                    {{ $flavor->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Harga -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Harga

                        </label>

                        <input
                            type="number"
                            name="price"
                            min="1"
                            value="{{ old('price', $product->price) }}"
                            class="form-control"
                            required>

                    </div>

                    <!-- Jenis Penjualan -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Jenis Penjualan

                        </label>

                        <select
                            name="sale_type"
                            class="form-select"
                            required>

                            <option
                                value="eceran"
                                @selected(old('sale_type', $product->sale_type) == 'eceran')>
                                Eceran
                            </option>

                            <option
                                value="mitra"
                                @selected(old('sale_type', $product->sale_type) == 'mitra')>
                                Mitra
                            </option>

                            <option
                                value="keduanya"
                                @selected(old('sale_type', $product->sale_type) == 'keduanya')>
                                Keduanya
                            </option>

                        </select>

                    </div>

                    <!-- Stok -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Stok Awal

                        </label>

                        <input  
                            type="number"
                            class="form-control"
                            value="{{ $product->stock }}"
                            disabled>

                    </div>

                    <!-- Minimum -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Minimum Stok

                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            min="0"
                            value="{{ old('minimum_stock', $product->minimum_stock) }}"
                            class="form-control"
                            required>

                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required>

                            <option
                                value="1"
                                @selected(old('status', $product->status) == 1)>
                                Aktif
                            </option>

                            <option
                                value="0"
                                @selected(old('status', $product->status) == 0)>
                                Nonaktif
                            </option>

                        </select>

                    </div>

                    <!-- Foto -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Foto Produk

                        </label>
                        @if($product->image)

                            <img
                                src="{{ Storage::url($product->image) }}"
                                width="120"
                                class="img-thumbnail mb-3">

                        @endif
                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png">
                    </div>

                </div>

                <div class="mt-4 text-end">

                    <button
                        class="btn btn-primary">

                        <i class="fas fa-save me-2"></i>

                        Update Produk

                    </button>

                </div>
            </form>

        </div>

    </div>

</div>

@endsection