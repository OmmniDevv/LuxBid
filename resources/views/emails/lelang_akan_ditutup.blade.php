@extends('emails.layout')
@section('content')
<h2>⏰ Lelang Favorit Segera Ditutup</h2>
<p>Halo <strong>{{ $nama }}</strong>, lelang untuk barang favorit Anda akan segera berakhir!</p>
<div class="highlight">
  <strong>{{ $nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Harga Tertinggi Saat Ini: <strong>Rp {{ number_format($harga_tertinggi, 0, ',', '.') }}</strong></span><br>
  <span style="font-size:.88rem;color:#c9a84c;font-weight:600">⏱️ Sisa Waktu: {{ $sisa_waktu }}</span>
</div>
<p style="margin-top:20px">Jangan lewatkan kesempatan ini! Ajukan penawaran Anda sekarang sebelum lelang ditutup.</p>
<a href="{{ $link_lelang }}" class="btn">Lihat Lelang</a>
<p style="font-size:.85rem;color:#6a5a3a;margin-top:16px">Anda menerima email ini karena telah menandai barang ini sebagai favorit.</p>
@endsection
