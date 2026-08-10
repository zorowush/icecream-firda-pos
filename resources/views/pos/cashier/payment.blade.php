@extends('pos.layouts.app')

@section('title','Pembayaran')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">

        Pembayaran

    </h3>

    <form
        action="{{ route('cashier.checkout') }}"
        method="POST">

        @csrf

        <div class="card shadow-sm">

            <div class="card-body">

                <h5>Total Belanja</h5>

                <h2 class="text-primary mb-4">

                    Rp {{ number_format($total,0,',','.') }}

                </h2>
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jenis Penjualan
                    </label>

                    <select
                        name="sale_type"
                        id="sale_type"
                        class="form-select">

                        <option
                            value="eceran"
                            {{ old('sale_type') == 'eceran' ? 'selected' : '' }}>
                            Penjualan Eceran
                        </option>

                        <option
                            value="mitra"
                            {{ old('sale_type') == 'mitra' ? 'selected' : '' }}>
                            Penjualan Mitra Warung
                        </option>

                    </select>
                </div>

                <div
                    class="mb-3"
                    id="partner-box"
                    style="display:none;">

                    <label class="form-label fw-semibold">

                        Mitra Warung

                    </label>

                    <select
                        name="partner_id"
                        class="form-select">

                        <option value="">-- Pilih Mitra --</option>

                        @foreach($partners as $partner)

                        <option
                            value="{{ $partner->id }}"
                            {{ old('partner_id') == $partner->id ? 'selected' : '' }}>

                            {{ $partner->shop_name }}

                        </option>

                        @endforeach

                    </select>

                </div>
                <div class="mb-3">

                    <label class="form-label">

                        Metode Pembayaran

                    </label>

                    <select
                        name="payment_method"
                        class="form-select">

                        <option
                            value="cash"
                            {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                            Cash
                        </option>

                        <option
                            value="qris"
                            {{ old('payment_method') == 'qris' ? 'selected' : '' }}>
                            QRIS
                        </option>

                        <option
                            value="transfer"
                            {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>
                            Transfer
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Uang Dibayar

                    </label>

                    <input
                        type="number"
                        id="paid"
                        name="paid_amount"
                        class="form-control"
                        value="{{ old('paid_amount') }}"
                        required>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Kembalian

                    </label>

                    <input
                        id="change"
                        class="form-control"
                        readonly>

                </div>

                <button
                    class="btn btn-success w-100">

                    Simpan Transaksi

                </button>

            </div>

        </div>

    </form>

</div>

<script>

const paid=document.getElementById('paid');
const change=document.getElementById('change');
const total={{ $total }};

paid.addEventListener('input',function(){

    let kembali=this.value-total;

    change.value=kembali>0 ? kembali : 0;

});

</script>

<script>

const saleType = document.getElementById('sale_type');
const partnerBox = document.getElementById('partner-box');

saleType.addEventListener('change', function(){

    if(this.value === 'mitra'){

        partnerBox.style.display = 'block';

    }else{

        partnerBox.style.display = 'none';

    }

});

</script>
@endsection