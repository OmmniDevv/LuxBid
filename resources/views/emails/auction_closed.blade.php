@extends('emails.layout')
@section('content')
<h2>Lelang Telah Ditutup</h2>
<p>Halo <strong>{{ $nama }}</strong>, lelang untuk barang berikut telah resmi ditutup.</p>
<div class="highlight">
  <strong>{{ $nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Penawaran Anda: <strong>Rp {{ number_format($penawaran_saya, 0, ',', '.') }}</strong></span>
</div>
<p>Terima kasih telah berpartisipasi. Pantau terus LuxBid untuk lelang berikutnya!</p>
@endsection
