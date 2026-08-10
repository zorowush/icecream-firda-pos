@extends('pos.layouts.app')

@section('title','Mitra Warung')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Mitra Warung
            </h3>

            <p class="text-muted mb-0">
                Kelola data mitra warung dan pelanggan tetap.
            </p>
        </div>

        <a href="{{ route('partners.create') }}"
            class="btn btn-primary">

            <i class="fas fa-plus me-2"></i>

            Tambah Mitra

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Nama Warung</th>
                        <th>Pemilik</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Bergabung</th>
                        <th>Status</th>
                        @if(auth()->user()->role == 'admin')
                            <th width="170">Aksi</th>
                        @endif

                    </tr>

                </thead>

                <tbody>

                    @forelse($partners as $partner)

                        <tr>

                            <td>{{ $partner->shop_name }}</td>
                            <td>{{ $partner->owner_name }}</td>
                            <td>{{ $partner->address ?? '-' }}</td>
                            <td>{{ $partner->phone ?? '-' }}</td>
                            <td>{{ $partner->joined_at?->format('d/m/Y') }}</td>

                            <td>

                                @if($partner->status)

                                    <span class="badge bg-success">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if(auth()->user()->role == 'admin')

                                    <a
                                        href="{{ route('partners.edit',$partner) }}"
                                        class="btn btn-warning btn-sm">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <form
                                        action="{{ route('partners.destroy',$partner) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus mitra ini?')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="{{ auth()->user()->role == 'admin' ? 7 : 6 }}"
                                class="text-center py-5">

                                Belum ada data mitra.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($partners->hasPages())

            <div class="card-footer">

                {{ $partners->links() }}

            </div>

        @endif

    </div>

</div>

@endsection