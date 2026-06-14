@extends('emails.layout')
@section('content')
<h2>Lelang Baru Telah Dibuka! 🔨</h2>
<p>Halo <strong>{{ $nama }}</strong>, ada lelang baru yang baru saja dibuka di LuxBid.</p>
<div class="highlight">
  <strong>{{ $nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Harga awal: <strong style="color:#c9a84c">Rp {{ number_format($harga_awal, 0, ',', '.') }}</strong></span>
</div>
<p>Jangan lewatkan kesempatan ini! Segera ajukan penawaran terbaik Anda sebelum waktu habis.</p>
@endsection
