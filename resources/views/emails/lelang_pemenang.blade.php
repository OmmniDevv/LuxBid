@extends('emails.layout')
@section('content')
<h2>🏆 Selamat, Anda Memenangkan Lelang!</h2>
<p>Halo <strong>{{ $nama_pemenang }}</strong>,</p>
<p>Kami dengan senang hati mengumumkan bahwa Anda adalah pemenang lelang untuk barang berikut:</p>
<div class="highlight">
  <strong>{{ $lelang->barang->nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Harga akhir: <strong style="color:#c9a84c">Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</strong></span>
</div>

<div style="background:#fdf8ee;border-left:3px solid #c9a84c;padding:12px 16px;border-radius:6px;margin:16px 0">
  <div style="font-weight:700;color:#1a1208;margin-bottom:8px">📋 Nomor Faktur</div>
  <div style="font-family:'Courier New',monospace;font-size:1.1rem;color:#c9a84c;font-weight:700">{{ $nomor_faktur }}</div>
</div>

<h3 style="font-size:1rem;color:#1a1208;margin-top:24px;margin-bottom:8px">Langkah Selanjutnya:</h3>
<ol style="margin:0;padding-left:20px;line-height:1.8;color:#4a3f2f">
  <li>Klik tombol di bawah untuk <strong>konfirmasi kesediaan Anda</strong></li>
  <li>Lakukan pembayaran sesuai instruksi</li>
  <li>Hubungi admin untuk pengambilan barang</li>
</ol>

<div style="background:#fff3cd;border:1px solid #ffc107;border-radius:6px;padding:10px 14px;margin:16px 0">
  <strong style="color:#856404">⏰ Batas Konfirmasi:</strong>
  <span style="color:#856404">{{ $lelang->batas_konfirmasi ? $lelang->batas_konfirmasi->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '2 x 24 jam' }} WIB</span>
</div>

<a href="{{ $link_konfirmasi }}" class="btn">Konfirmasi Kemenangan</a>

<p style="margin-top:20px;font-size:.85rem;color:#7a7260">Faktur PDF terlampir dalam email ini. Tunjukkan nomor faktur kepada petugas saat melakukan konfirmasi pembayaran.</p>

<p style="margin-top:16px;font-size:.85rem;color:#7a7260">
  <strong>Kontak Admin:</strong><br>
  WhatsApp: +62 858-6907-4622<br>
  Email: support@luxbid.id
</p>
@endsection
