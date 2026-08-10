<!DOCTYPE html>
<html>

<head>

    <title>Struk</title>

    <style>

        body{

            font-family: monospace;
            width:300px;
            margin:auto;

        }

        h3{

            text-align:center;

        }

        table{

            width:100%;

            border-collapse:collapse;

        }

        td{

            padding:3px 0;

        }

        hr{

            border:dashed 1px #999;

        }

    </style>

</head>

<body>

@if($setting->logo)

<center>

    <img
        src="{{ asset('storage/'.$setting->logo) }}"
        width="70">

</center>

@endif

<h3>

{{ $setting->business_name }}

</h3>

<center>

{{ $setting->address }}

<br>

{{ $setting->phone }}

</center>

<hr>

Invoice :
{{ $transaction->invoice }}

<br>

Tanggal :
{{ $transaction->created_at->format('d/m/Y H:i') }}

<br>

Kasir :
{{ $transaction->user->name }}

<hr>

@foreach($transaction->details as $detail)

{{ $detail->product_name }}

<br>

{{ $detail->qty }}
x

Rp {{ number_format($detail->price,0,',','.') }}

<br>

<b>

Rp {{ number_format($detail->subtotal,0,',','.') }}

</b>

<hr>

@endforeach

<table>

<tr>

<td>Total</td>

<td align="right">

Rp {{ number_format($transaction->grand_total,0,',','.') }}

</td>

</tr>

<tr>

<td>Dibayar</td>

<td align="right">

Rp {{ number_format($transaction->paid_amount,0,',','.') }}

</td>

</tr>

<tr>

<td>Kembalian</td>

<td align="right">

Rp {{ number_format($transaction->change_amount,0,',','.') }}

</td>

</tr>

</table>

<hr>

<center>

{{ $setting->receipt_footer ?: 'Terima kasih telah berbelanja 😊' }}

</center>

<script>

window.print();

</script>

</body>

</html>