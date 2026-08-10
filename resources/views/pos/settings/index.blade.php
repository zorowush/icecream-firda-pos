@extends('pos.layouts.app')

@section('title','Pengaturan')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <h3 class="fw-bold mb-2">
                Pengaturan
            </h3>

            <p class="text-muted mb-0">
                Kelola informasi usaha Ice Cream Firda.
            </p>

        </div>

        <a href="{{ url()->previous() }}"
        class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Kembali

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form
                action="{{ route('settings.update') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nama Usaha
                        </label>

                        <input
                            type="text"
                            name="business_name"
                            class="form-control"
                            value="{{ old('business_name',$setting->business_name) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nama Pemilik
                        </label>

                        <input
                            type="text"
                            name="owner_name"
                            class="form-control"
                            value="{{ old('owner_name',$setting->owner_name) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nomor HP
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone',$setting->phone) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email',$setting->email) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Minimum Stok
                        </label>

                        <input
                            type="number"
                            name="minimum_stock"
                            class="form-control"
                            value="{{ old('minimum_stock',$setting->minimum_stock) }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Pajak (%)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="tax"
                            class="form-control"
                            value="{{ old('tax',$setting->tax) }}">

                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Alamat
                        </label>

                        <textarea
                            name="address"
                            class="form-control"
                            rows="3">{{ old('address',$setting->address) }}</textarea>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Footer Struk
                        </label>

                        <textarea
                            name="receipt_footer"
                            class="form-control"
                            rows="3">{{ old('receipt_footer',$setting->receipt_footer) }}</textarea>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label class="form-label">
                            Logo
                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="form-control">

                        @if($setting->logo)

                            <img
                                src="{{ asset('storage/'.$setting->logo) }}"
                                class="img-thumbnail mt-3"
                                width="120">

                        @endif

                    </div>

                </div>

                <div class="text-end">

                    <button class="btn btn-primary">

                        <i class="fas fa-save me-2"></i>

                        Simpan Pengaturan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection