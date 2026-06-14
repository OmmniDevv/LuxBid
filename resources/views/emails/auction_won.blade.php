@extends('emails.layout')
@section('content')
<h2>🏆 Selamat, Anda Menang!</h2>
<p>Halo <strong>{{ $nama }}</strong>, Anda adalah pemenang lelang untuk barang berikut:</p>
<div class="highlight">
  <strong>{{ $nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Harga akhir: <strong style="color:#c9a84c">Rp {{ number_format($harga_akhir, 0, ',', '.') }}</strong></span>
</div>
<p>Login ke akun Anda untuk mengunduh <strong>Faktur PDF</strong> dan menyelesaikan proses pembayaran.</p>
@endsection
