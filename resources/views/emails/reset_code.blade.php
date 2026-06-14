@extends('emails.layout')
@section('content')
<h2>Reset Password LuxBid</h2>
<p>Halo <strong>{{ $nama }}</strong>, kami menerima permintaan reset password untuk akun Anda.</p>
<p>Gunakan kode verifikasi berikut:</p>
<div class="highlight" style="text-align:center;padding:20px">
  <span style="font-size:2.4rem;font-weight:800;letter-spacing:.4rem;color:#1a1208;font-family:monospace">{{ $code }}</span>
  <br><span style="font-size:.8rem;color:#9a8a6a;margin-top:8px;display:block">Berlaku selama <strong>10 menit</strong></span>
</div>
<p style="font-size:.82rem;color:#9a8a6a">Jika Anda tidak merasa meminta reset password, abaikan email ini. Akun Anda tetap aman.</p>
@endsection
