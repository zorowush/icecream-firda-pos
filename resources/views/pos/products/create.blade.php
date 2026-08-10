@extends('pos.layouts.app')

@section('title','Tambah Produk')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Tambah Produk
            </h3>

            <p class="text-muted">
                Tambahkan produk baru Ice Cream Firda.
            </p>

        </div>

        <a href="{{ route('products') }}"
        class="btn btn-outline-secondary">

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
            <form action="{{ route('products.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <!-- Kode -->
                    <div class="col-12 mb-4">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Kode produk akan dibuat otomatis oleh sistem.
                        </div>
                    </div>

                    <!-- Kemasan -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Kemasan

                        </label>

                        <select
                            name="package_id"
                            class="form-select"
                            required>

                            <option value="">

                                Pilih Kemasan

                            </option>

                            @foreach($packages as $package)

                                <option
                                    value="{{ $package->id }}"
                                    @selected(old('package_id') == $package->id)>

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
                            name="flavor_id"
                            class="form-select"
                            required>

                            <option value="">

                                Pilih Rasa

                            </option>

                            @foreach($flavors as $flavor)

                                <option
                                    value="{{ $flavor->id }}"
                                    @selected(old('flavor_id') == $flavor->id)>

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
                            value="{{ old('price') }}"
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
                                @selected(old('sale_type') == 'eceran')>

                                Eceran

                            </option>

                            <option
                                value="mitra"
                                @selected(old('sale_type') == 'mitra')>

                                Mitra

                            </option>

                            <option
                                value="keduanya"
                                @selected(old('sale_type') == 'keduanya')>

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
                            name="stock"
                            min="0"
                            value="{{ old('stock', 0) }}"
                            class="form-control"
                            required>

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
                            value="{{ old('minimum_stock', 10) }}"
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

                            <option value="1" @selected(old('status',1) == 1)>
                                Aktif
                            </option>

                            <option value="0" @selected(old('status') == 0)>
                                Nonaktif
                            </option>

                        </select>

                    </div>

                    <!-- Foto -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Foto Produk

                        </label>

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

                        Simpan Produk

                    </button>

                </div>
            </form>

        </div>

    </div>

</div>

@endsection