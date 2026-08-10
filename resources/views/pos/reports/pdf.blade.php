<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Ice Cream Firda</title>

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        th,td{
            border:1px solid #000;
            padding:6px;
        }

        th{
            background:#f2f2f2;
        }

        h2,h4{
            text-align:center;
            margin:0;
        }

    </style>

</head>

<body>

<h2>Ice Cream Firda</h2>

<h4>Laporan Penjualan</h4>

<p>

Periode :

{{ $start ?? '-' }}

s/d

{{ $end ?? '-' }}

</p>

<table>

<thead>

<tr>

<th>Tanggal</th>

<th>Invoice</th>

<th>Kasir</th>

<th>Jenis</th>

<th>Total</th>

</tr>

</thead>

<tbody>

@foreach($transactions as $transaction)

<tr>

<td>

{{ $transaction->created_at->format('d/m/Y') }}

</td>

<td>

{{ $transaction->invoice }}

</td>

<td>

{{ $transaction->user->name }}

</td>

<td>

{{ ucfirst($transaction->sale_type) }}

</td>

<td>

Rp {{ number_format($transaction->grand_total,0,',','.') }}

</td>

</tr>

@endforeach

</tbody>

</table>

<br>

<table>

<tr>

<td>Total Penjualan</td>

<td>

Rp {{ number_format($totalSales,0,',','.') }}

</td>

</tr>

<tr>

<td>Total Pengeluaran</td>

<td>

Rp {{ number_format($expenses,0,',','.') }}

</td>

</tr>

<tr>

<td>Laba Bersih</td>

<td>

Rp {{ number_format($profit,0,',','.') }}

</td>

</tr>

</table>

</body>

</html>