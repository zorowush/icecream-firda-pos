@extends('pos.layouts.app')

@section('title','Tambah Mitra')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Tambah Mitra Warung

            </h3>

            <p class="text-muted mb-0">

                Tambahkan data pelanggan tetap.

            </p>

        </div>

        <a href="{{ route('partners') }}"
            class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Kembali

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form
                id="partnerForm"
                action="{{ route('partners.store') }}"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Nama Warung

                    </label>

                    <input
                        type="text"
                        name="shop_name"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nama Pemilik

                    </label>

                    <input
                        type="text"
                        name="owner_name"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Alamat

                    </label>

                    <textarea
                        name="address"
                        class="form-control"
                        rows="3"></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nomor HP

                    </label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control">

                </div>

                

            </form>
        <div class="card-footer bg-white">

            <div class="d-flex justify-content-end">

                <button
                    type="submit"
                    form="partnerForm"
                    class="btn btn-primary">

                    <i class="fas fa-save me-2"></i>

                    Simpan Mitra

                </button>

            </div>

        </div>
        </div>

    </div>

</div>

@endsection