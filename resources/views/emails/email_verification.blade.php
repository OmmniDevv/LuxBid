@extends('emails.layout')
@section('content')
<h2>Verifikasi Email LuxBid</h2>
<p>Halo <strong>{{ $nama }}</strong>, terima kasih telah mendaftar di LuxBid!</p>
<p>Gunakan kode berikut untuk memverifikasi email Anda:</p>
<div class="highlight" style="text-align:center;padding:20px">
  <span style="font-size:2.4rem;font-weight:800;letter-spacing:.4rem;color:#1a1208;font-family:monospace">{{ $code }}</span>
  <br><span style="font-size:.8rem;color:#9a8a6a;margin-top:8px;display:block">Berlaku selama <strong>10 menit</strong></span>
</div>
<p style="font-size:.82rem;color:#9a8a6a">Jika Anda tidak mendaftar di LuxBid, abaikan email ini.</p>
@endsection
