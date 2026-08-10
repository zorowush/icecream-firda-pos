@extends('pos.layouts.app')

@section('title','Profil Saya')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold">
                Profil Saya
            </h3>

            <p class="text-muted mb-0">
                Kelola informasi akun Anda.
            </p>

        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>

    </div>

    @if(session('status') == 'profile-updated')

        <div class="alert alert-success">
            Profil berhasil diperbarui.
        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="{{ route('profile.update') }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Nama
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name',$user->name) }}"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Role
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ ucfirst($user->role) }}"
                            readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email',$user->email) }}"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Password Lama
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Password Baru
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control">

                    </div>

                </div>

                <div class="text-end">

                    <button class="btn btn-primary">

                        <i class="fas fa-save me-2"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection