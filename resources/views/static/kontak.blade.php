<!DOCTYPE html>
<html lang="id">
<head>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Kontak — Lux Bid</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
<link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--gold:#B8860B;--gold-l:#D4A017;--gold-p:#FDF8EE;--gold-ln:rgba(184,134,11,.2);--ink:#1C1A15;--ink-s:#3A3527;--ink-m:#7A7260;--cream:#FAF7F0;--cream-d:#EDE8DC;--white:#FFFFFF;--r:12px;--rs:7px;--ease:.24s cubic-bezier(.4,0,.2,1);}
body{font-family:'Inter',sans-serif;background:var(--cream);color:var(--ink)}
.ln{position:fixed;inset:0 0 auto 0;z-index:200;display:flex;align-items:center;justify-content:space-between;padding:0 3rem;height:64px;background:rgba(250,247,240,.88);backdrop-filter:blur(14px);border-bottom:1px solid var(--gold-ln)}
.ln-logo{font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:700;color:var(--ink);text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.ln-logo img{width:44px;height:44px;object-fit:contain;border-radius:8px}
.ln-logo span{color:var(--gold)}
.ln-links{display:flex;align-items:center;gap:.25rem;list-style:none}
.ln-links a{font-size:.85rem;font-weight:500;color:var(--ink-m);text-decoration:none;padding:.45rem .9rem;border-radius:100px;transition:color var(--ease),background var(--ease)}
.ln-links a:hover,.ln-links a.active{color:var(--ink);background:var(--cream-d)}
.ln-cta{background:var(--ink)!important;color:var(--cream)!important;padding:.45rem 1.2rem!important}
.ln-cta:hover{background:var(--gold)!important;color:var(--ink)!important}
.page-hero{padding:9rem 1.5rem 4rem;text-align:center}
.lbl{display:inline-block;font-size:.68rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);margin-bottom:.75rem}
.ttl{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);line-height:1.1;color:var(--ink)}
.dsc{margin-top:.9rem;font-size:.95rem;color:var(--ink-m);max-width:520px;margin-left:auto;margin-right:auto;line-height:1.75}
.inner{max-width:900px;margin:0 auto;padding:0 1.5rem 6rem}
.contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-top:3rem}
@media(max-width:640px){.contact-grid{grid-template-columns:1fr}}
.contact-card{background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:2rem;display:flex;flex-direction:column;gap:.75rem}
.contact-card .icon{width:48px;height:48px;background:var(--gold-p);border-radius:var(--rs);display:flex;align-items:center;justify-content:center;font-size:1.3rem}
.contact-card h3{font-size:1rem;font-weight:600;color:var(--ink)}
.contact-card p{font-size:.85rem;color:var(--ink-m);line-height:1.65}
.contact-card a{font-size:.85rem;color:var(--gold);text-decoration:none;font-weight:500}
.contact-card a:hover{text-decoration:underline}
.wa-btn{display:inline-flex;align-items:center;gap:.6rem;background:#25D366;color:#fff;padding:.75rem 1.5rem;border-radius:100px;font-size:.9rem;font-weight:600;text-decoration:none;transition:all var(--ease);box-shadow:0 4px 14px rgba(37,211,102,.3);margin-top:.5rem}
.wa-btn:hover{background:#1ebe5d;transform:translateY(-2px);text-decoration:none;color:#fff}
.footer{background:var(--gold-p);border-top:1px solid var(--gold-ln)}
.fi{max-width:1080px;margin:0 auto;padding:2.5rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem}
.flogo{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ink);text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.flogo img{width:36px;height:36px;object-fit:contain;border-radius:6px}
.flogo span{color:var(--gold)}
.ftag{font-size:.75rem;color:var(--ink-m);margin-top:.25rem}
.flinks{display:flex;gap:1.5rem}
.flinks a{font-size:.82rem;color:var(--ink-m);text-decoration:none;transition:color var(--ease)}
.flinks a:hover{color:var(--gold)}
.fbot{max-width:1080px;margin:0 auto;padding:.75rem 1.5rem 1.5rem;display:flex;justify-content:space-between;flex-wrap:wrap;gap:.5rem;font-size:.72rem;color:var(--ink-m);border-top:1px solid var(--gold-ln)}
</style>
</head>
<body>
<nav class="ln">
  <a href="{{ route('home') }}" class="ln-logo">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Lux Bid">
    Lux<span>Bid</span>
  </a>
  <ul class="ln-links">
    <li><a href="{{ route('home') }}">Beranda</a></li>
    <li><a href="/bantuan">Bantuan</a></li>
    <li><a href="/kontak" class="active">Kontak</a></li>
    <li><a href="{{ route('login.masyarakat') }}" class="ln-cta">Masuk</a></li>
  </ul>
</nav>

<div class="page-hero">
  <div class="lbl">Hubungi Kami</div>
  <h1 class="ttl">Kami Siap Membantu Anda</h1>
  <p class="dsc">Ada pertanyaan, kendala, atau masukan? Tim LuxBid siap merespons dengan cepat dan profesional. Jangan ragu untuk menghubungi kami melalui saluran di bawah ini.</p>
</div>

<div class="inner">
  <div class="contact-grid">

    <div class="contact-card">
      <div class="icon">💬</div>
      <h3>WhatsApp</h3>
      <p>Cara tercepat untuk menghubungi kami. Tim support kami aktif setiap hari Senin–Sabtu, pukul 08.00–17.00 WIB.</p>
      <p><strong>+62 858-6907-4622</strong></p>
      <a href="https://wa.me/6285869074622" class="wa-btn" target="_blank" rel="noopener">
        <i class="fab fa-whatsapp"></i> Chat via WhatsApp
      </a>
    </div>

    <div class="contact-card">
      <div class="icon">📧</div>
      <h3>Email</h3>
      <p>Untuk pertanyaan formal, laporan masalah teknis, atau kerja sama bisnis, kirimkan email ke alamat berikut. Kami merespons dalam 1×24 jam kerja.</p>
      <a href="mailto:support@luxbid.id">support@luxbid.id</a>
    </div>

    <div class="contact-card">
      <div class="icon">🏢</div>
      <h3>Kantor</h3>
      <p>SMKN 7 Baleendah, Jl. Siliwangi No. 1, Baleendah, Kabupaten Bandung, Jawa Barat 40375.</p>
      <p style="font-size:.8rem;color:var(--ink-m)">Kunjungan hanya dengan perjanjian terlebih dahulu.</p>
    </div>

    <div class="contact-card">
      <div class="icon">🕐</div>
      <h3>Jam Operasional</h3>
      <p>Senin – Jumat: 08.00 – 17.00 WIB<br>Sabtu: 08.00 – 12.00 WIB<br>Minggu & Hari Libur: Tutup</p>
      <p style="font-size:.8rem;color:var(--ink-m)">Pesan di luar jam operasional akan dibalas pada hari kerja berikutnya.</p>
    </div>

  </div>
</div>

<footer class="footer">
  <div class="fi">
    <div>
      <a href="{{ route('home') }}" class="flogo">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Lux Bid">
        Lux<span>Bid</span>
      </a>
      <p class="ftag">Platform Pelelangan Online</p>
    </div>
    <div class="flinks">
      <a href="/kontak">Kontak</a>
      <a href="/bantuan">Bantuan</a>
      <a href="/kebijakan-privasi">Kebijakan Privasi</a>
    </div>
  </div>
  <div class="fbot">
    <span>&copy; 2026 Lux Bid. Hak cipta dilindungi.</span>
    <span>Made by TEAM HUNTERS &middot; MIT License</span>
  </div>
</footer>
<script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
