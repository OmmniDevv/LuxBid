<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Kontak — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    .static-nav{
      position:fixed;inset:0 0 auto 0;z-index:200;
      height:64px;display:flex;align-items:center;justify-content:space-between;
      padding:0 2.5rem;
      background:rgba(250,250,249,.88);
      backdrop-filter:blur(20px) saturate(180%);
      border-bottom:1px solid var(--border);
    }
    [data-theme="dark"] .static-nav{background:rgba(12,10,9,.92)}
    .sn-brand{
      font-family:var(--font-serif);font-size:1.3rem;font-weight:700;
      color:var(--text);text-decoration:none;
      display:inline-flex;align-items:center;gap:.6rem;
    }
    .sn-brand span{color:var(--accent)}
    .sn-brand img{width:40px;height:40px;border-radius:8px}
    .sn-links{display:flex;align-items:center;gap:.5rem}
    .sn-links a{
      font-size:.8rem;font-weight:500;color:var(--text-2);
      text-decoration:none;padding:.4rem .9rem;border-radius:100px;
      transition:all var(--ease-fast);
    }
    .sn-links a:hover{color:var(--text);background:var(--surface-2)}

    .static-hero{
      padding:9rem 1.5rem 4rem;text-align:center;
      background:var(--surface-2);
    }
    [data-theme="dark"] .static-hero{background:var(--surface)}
    .static-inner{max-width:900px;margin:0 auto;padding:4rem 1.5rem 6rem}

    .contact-grid{
      display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
      gap:1.5rem;margin-top:3rem;
    }
    .contact-card{
      background:var(--surface);border:1px solid var(--border);
      border-radius:var(--r);padding:2rem;
      transition:transform var(--ease-fast),box-shadow var(--ease-fast),border-color var(--ease-fast);
    }
    .contact-card:hover{
      transform:translateY(-4px);box-shadow:var(--shadow-lg);border-color:var(--accent-ln);
    }
    .cc-icon{
      width:50px;height:50px;border-radius:var(--rs);
      background:var(--accent-p);border:1px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:1.3rem;color:var(--accent);margin-bottom:1.1rem;
    }
    .cc-title{
      font-family:var(--font-serif);font-size:1.05rem;
      color:var(--text);margin-bottom:.4rem;font-weight:600;
    }
    .cc-text{font-size:.84rem;color:var(--text-2);line-height:1.65;margin-bottom:.6rem}
    .cc-link{
      font-size:.86rem;color:var(--accent);
      text-decoration:none;font-weight:600;
      transition:color var(--ease-fast);
    }
    .cc-link:hover{color:var(--accent-l);text-decoration:underline}

    .wa-cta{
      background:var(--accent-p);border:1px solid var(--accent-ln);
      border-radius:var(--r);padding:2.5rem;text-align:center;
      margin-top:3rem;
    }
    .wa-cta h3{
      font-family:var(--font-serif);font-size:1.35rem;
      color:var(--text);margin-bottom:.6rem;
    }
    .wa-cta p{font-size:.88rem;color:var(--text-2);margin-bottom:1.5rem;line-height:1.7}
    .wa-btn{
      display:inline-flex;align-items:center;gap:.6rem;
      background:#25D366;color:#fff;
      padding:.85rem 2rem;border-radius:100px;
      font-size:.9rem;font-weight:600;text-decoration:none;
      box-shadow:0 4px 16px rgba(37,211,102,.3);
      transition:all var(--ease-fast);
    }
    .wa-btn:hover{
      background:#1ebe5d;transform:translateY(-2px);
      box-shadow:0 6px 22px rgba(37,211,102,.4);text-decoration:none;color:#fff;
    }

    .static-footer{
      background:var(--surface-2);border-top:1px solid var(--border);
      padding:2.5rem 1.5rem 1.5rem;
    }
    [data-theme="dark"] .static-footer{background:var(--surface)}
    .sf-inner{max-width:900px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1.5rem}
    .sf-brand{
      font-family:var(--font-serif);font-size:1.1rem;font-weight:700;
      color:var(--text);text-decoration:none;
      display:inline-flex;align-items:center;gap:.55rem;
    }
    .sf-brand span{color:var(--accent)}
    .sf-brand img{width:32px;height:32px;border-radius:6px}
    .sf-links{display:flex;gap:1.5rem}
    .sf-links a{font-size:.8rem;color:var(--text-2);text-decoration:none;transition:color var(--ease-fast)}
    .sf-links a:hover{color:var(--accent)}
    .sf-copy{
      max-width:900px;margin:.75rem auto 0;padding-top:1rem;
      border-top:1px solid var(--border);
      font-size:.72rem;color:var(--text-3);text-align:center;
    }

    @media(max-width:768px){
      .static-nav{padding:0 1.25rem}
      .sn-links a:not(:last-child){display:none}
    }
  </style>
</head>
<body>
  <nav class="static-nav">
    <a href="{{ route('home') }}" class="sn-brand">
      <img src="{{ asset('assets/images/logo.png') }}" alt="LuxBid">
      Lux<span>Bid</span>
    </a>
    <div class="sn-links">
      <a href="{{ route('home') }}">Beranda</a>
      <a href="/kontak">Kontak</a>
      <a href="/bantuan">Bantuan</a>
      <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode"><i class="fas fa-moon"></i></button>
    </div>
  </nav>

  <section class="static-hero">
    <span class="sec-lbl">Hubungi Kami</span>
    <h1 class="sec-title">Kontak LuxBid</h1>
    <p class="sec-desc" style="max-width:520px;margin-left:auto;margin-right:auto">
      Butuh bantuan atau informasi lebih lanjut? Tim kami siap membantu Anda.
    </p>
  </section>

  <div class="static-inner">
    <div class="contact-grid">
      <div class="contact-card">
        <div class="cc-icon"><i class="fas fa-envelope"></i></div>
        <h3 class="cc-title">Email</h3>
        <p class="cc-text">Kirim pertanyaan atau saran Anda melalui email resmi kami.</p>
        <a href="mailto:support@luxbid.com" class="cc-link">support@luxbid.com</a>
      </div>

      <div class="contact-card">
        <div class="cc-icon"><i class="fas fa-phone-alt"></i></div>
        <h3 class="cc-title">Telepon</h3>
        <p class="cc-text">Hubungi kami via telepon pada jam kerja (Senin-Jumat, 09:00-17:00 WIB).</p>
        <a href="tel:+6285869074622" class="cc-link">+62 858-6907-4622</a>
      </div>

      <div class="contact-card">
        <div class="cc-icon"><i class="fas fa-map-marker-alt"></i></div>
        <h3 class="cc-title">Alamat Kantor</h3>
        <p class="cc-text">Kunjungi kantor kami untuk konsultasi langsung (by appointment).</p>
        <a href="https://maps.google.com" target="_blank" rel="noopener" class="cc-link">Lihat di Google Maps &rarr;</a>
      </div>

      <div class="contact-card">
        <div class="cc-icon"><i class="bi bi-clock"></i></div>
        <h3 class="cc-title">Jam Operasional</h3>
        <p class="cc-text">
          <strong>Senin - Jumat:</strong> 09:00 - 17:00 WIB<br>
          <strong>Sabtu:</strong> 09:00 - 13:00 WIB<br>
          <strong>Minggu & Libur:</strong> Tutup
        </p>
      </div>
    </div>

    <div class="wa-cta">
      <h3>Butuh Respons Cepat?</h3>
      <p>Hubungi kami via WhatsApp untuk mendapatkan balasan lebih cepat dari tim customer support kami.</p>
      <a href="https://wa.me/6285869074622" target="_blank" rel="noopener" class="wa-btn">
        <i class="bi bi-whatsapp"></i> Chat via WhatsApp
      </a>
    </div>
  </div>

  <footer class="static-footer">
    <div class="sf-inner">
      <a href="{{ route('home') }}" class="sf-brand">
        <img src="{{ asset('assets/images/logo.png') }}" alt="LuxBid">
        Lux<span>Bid</span>
      </a>
      <div class="sf-links">
        <a href="/kontak">Kontak</a>
        <a href="/bantuan">Bantuan</a>
        <a href="/kebijakan-privasi">Kebijakan Privasi</a>
      </div>
    </div>
    <div class="sf-copy">&copy; {{ date('Y') }} LuxBid. Hak cipta dilindungi.</div>
  </footer>

  <script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
