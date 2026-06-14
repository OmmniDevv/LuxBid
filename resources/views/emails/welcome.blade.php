@extends('emails.layout')
@section('content')
<h2>Selamat Datang di LuxBid, {{ $nama }}! 🎉</h2>
<p>Terima kasih telah bergabung dengan <strong>LuxBid</strong>, platform pelelangan online premium. Akun Anda telah berhasil dibuat dan siap digunakan.</p>
<div class="highlight">
  <strong>🎯 Mulai Jelajahi LuxBid</strong><br>
  <span style="font-size:.88rem;color:#6a5a3a;line-height:1.8">
    ✦ Ikuti lelang barang eksklusif pilihan<br>
    ✦ Ajukan penawaran & pantau status real-time<br>
    ✦ Unduh faktur PDF otomatis saat menang<br>
    ✦ Kelola profil & riwayat lelang Anda
  </span>
</div>
<p style="margin-top:20px;padding-top:16px;border-top:1px solid #e8dcc4">
  Jangan lewatkan lelang menarik! Masuk ke akun Anda dan mulai ikut serta dalam lelang eksklusif kami.
</p>
<p style="color:#9a8a6a;font-size:.85rem;margin-top:24px">
  <em>Tips:</em> Aktifkan notifikasi untuk mendapat info lelang terbaru dan jangan lupa cek dashboard Anda secara rutin.
</p>
@endsection
