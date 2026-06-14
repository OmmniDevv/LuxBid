@extends('emails.layout')
@section('content')
<h2>Penawaran Anda Dilampaui</h2>
<p>Halo <strong>{{ $nama }}</strong>, seseorang baru saja mengajukan penawaran lebih tinggi untuk barang yang Anda ikuti.</p>
<div class="highlight">
  <strong>{{ $nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Penawaran tertinggi saat ini: <strong style="color:#c9a84c">Rp {{ number_format($harga_baru, 0, ',', '.') }}</strong></span>
</div>
<p>Segera ajukan penawaran baru agar Anda tetap unggul!</p>
@endsection
