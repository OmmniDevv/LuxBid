@extends('emails.layout')
@section('content')
<h2>✅ Konfirmasi Kesediaan Diterima</h2>
<p>Terima kasih, <strong>{{ $nama_pemenang }}</strong>!</p>
<p>Konfirmasi kesediaan Anda untuk melanjutkan proses pembayaran dan pengambilan barang telah kami terima.</p>

<div class="highlight">
  <strong>{{ $lelang->barang->nama_barang }}</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a">Harga akhir: <strong style="color:#c9a84c">Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</strong></span><br>
  <span style="font-size:.88rem;color:#6a5a3a">Nomor Faktur: <strong style="font-family:monospace;color:#1a1208">{{ $lelang->nomor_faktur }}</strong></span>
</div>

<h3 style="font-size:1rem;color:#1a1208;margin-top:24px;margin-bottom:8px">Langkah Selanjutnya:</h3>
<ol style="margin:0;padding-left:20px;line-height:1.8;color:#4a3f2f">
  <li><strong>Lakukan Pembayaran</strong> sesuai nominal yang tertera pada faktur</li>
  <li><strong>Hubungi Admin</strong> untuk konfirmasi pembayaran dan mengatur jadwal pengambilan barang</li>
  <li><strong>Tunjukkan Nomor Faktur</strong> saat pengambilan barang</li>
</ol>

<div style="background:#e7f3ff;border:1px solid #b3d7ff;border-radius:8px;padding:14px 16px;margin:20px 0">
  <div style="font-weight:700;color:#004085;margin-bottom:8px">💳 Informasi Pembayaran</div>
  <div style="color:#004085;font-size:.9rem;line-height:1.7">
    <strong>Metode:</strong> Transfer Bank / Tunai (konfirmasi ke admin)<br>
    <strong>Total:</strong> Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}<br>
    <strong>Nomor Faktur:</strong> <span style="font-family:monospace">{{ $lelang->nomor_faktur }}</span>
  </div>
</div>

<div style="background:#fdf8ee;border-left:3px solid #c9a84c;padding:14px 16px;border-radius:6px;margin:16px 0">
  <div style="font-weight:700;color:#1a1208;margin-bottom:6px">📞 Kontak Admin LuxBid</div>
  <div style="color:#4a3f2f;font-size:.9rem;line-height:1.7">
    <strong>WhatsApp:</strong> +62 858-6907-4622 (Respon cepat)<br>
    <strong>Email:</strong> support@luxbid.id<br>
    <strong>Jam Operasional:</strong> Senin - Jumat, 08.00 - 17.00 WIB
  </div>
</div>

<p style="margin-top:20px;font-size:.88rem;color:#7a7260">
  Harap segera menghubungi admin untuk menyelesaikan proses pembayaran dan pengambilan barang.
  Kami tunggu kabar baik dari Anda!
</p>
@endsection
