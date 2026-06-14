@extends('emails.layout')
@section('content')
<h2>Lelang Telah Berakhir</h2>
<p>Halo <strong>{{ $nama }}</strong>, lelang untuk barang berikut telah resmi berakhir.</p>
<div class="highlight">
  <strong>{{ $nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Penawaran Anda: <strong>Rp {{ number_format($penawaran_saya, 0, ',', '.') }}</strong></span>
</div>
<p>Terima kasih telah berpartisipasi dalam lelang ini. Kami menghargai antusiasme Anda!</p>

@if(count($rekomendasi) > 0)
<h2 style="margin-top:28px;margin-bottom:12px;font-size:1rem">Lelang Lain yang Mungkin Anda Minati</h2>
<p style="margin-bottom:16px;font-size:.88rem;color:#6a5a3a">Berikut beberapa lelang serupa yang masih berlangsung:</p>
@foreach($rekomendasi as $item)
<div style="background:#fff;border:1px solid #e8dcc8;padding:12px 16px;border-radius:6px;margin-bottom:12px">
  <strong style="color:#1a1208;font-size:.95rem">{{ $item['nama_barang'] }}</strong><br>
  <span style="font-size:.82rem;color:#6a5a3a">Harga Awal: <strong>Rp {{ number_format($item['harga_awal'], 0, ',', '.') }}</strong></span><br>
  <span style="font-size:.78rem;color:#9a8a6a">Kategori: {{ $item['kategori'] }}</span>
</div>
@endforeach
<p style="font-size:.88rem;color:#6a5a3a;margin-top:16px">Kunjungi LuxBid untuk melihat semua lelang yang sedang berlangsung!</p>
@else
<p style="margin-top:20px;font-size:.88rem;color:#6a5a3a">Pantau terus LuxBid untuk lelang menarik berikutnya!</p>
@endif
@endsection
