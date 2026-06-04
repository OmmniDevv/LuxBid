<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Bantuan & FAQ — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    .static-nav{position:fixed;inset:0 0 auto 0;z-index:200;height:64px;display:flex;align-items:center;justify-content:space-between;padding:0 2.5rem;background:rgba(250,250,249,.88);backdrop-filter:blur(20px) saturate(180%);border-bottom:1px solid var(--border)}
    [data-theme="dark"] .static-nav{background:rgba(12,10,9,.92)}
    .sn-brand{font-family:var(--font-serif);font-size:1.3rem;font-weight:700;color:var(--text);text-decoration:none;display:inline-flex;align-items:center;gap:.6rem}
    .sn-brand span{color:var(--accent)}
    .sn-brand img{width:40px;height:40px;border-radius:8px}
    .sn-links{display:flex;align-items:center;gap:.5rem}
    .sn-links a{font-size:.8rem;font-weight:500;color:var(--text-2);text-decoration:none;padding:.4rem .9rem;border-radius:100px;transition:all var(--ease-fast)}
    .sn-links a:hover{color:var(--text);background:var(--surface-2)}
    .static-hero{padding:9rem 1.5rem 4rem;text-align:center;background:var(--surface-2)}
    [data-theme="dark"] .static-hero{background:var(--surface)}
    .static-inner{max-width:820px;margin:0 auto;padding:4rem 1.5rem 6rem}
    .section-block{margin-bottom:5rem}
    .section-title{font-family:var(--font-serif);font-size:1.65rem;color:var(--text);margin-bottom:1.75rem;padding-bottom:.75rem;border-bottom:2px solid var(--accent-ln);display:inline-flex;align-items:center;gap:.7rem}
    .steps{display:flex;flex-direction:column;gap:1.15rem}
    .step-item{display:flex;gap:1.25rem;background:var(--surface);border:1px solid var(--border);border-radius:var(--r);padding:1.6rem;transition:transform var(--ease-fast),border-color var(--ease-fast)}
    .step-item:hover{transform:translateX(4px);border-color:var(--accent-ln)}
    .step-num{width:38px;height:38px;min-width:38px;background:var(--ink);color:var(--cream);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:var(--font-serif);font-size:1.05rem;font-weight:700}
    [data-theme="dark"] .step-num{background:var(--accent);color:var(--ink)}
    .step-body h4{font-family:var(--font-serif);font-size:1rem;font-weight:600;color:var(--text);margin-bottom:.4rem}
    .step-body p{font-size:.84rem;color:var(--text-2);line-height:1.7}
    .step-body a{color:var(--accent);font-weight:600;text-decoration:none}
    .step-body a:hover{text-decoration:underline}
    .faq{display:flex;flex-direction:column;gap:.7rem}
    .faq-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--r);overflow:hidden;transition:border-color var(--ease-fast)}
    .faq-item:hover{border-color:var(--accent-ln)}
    .faq-q{width:100%;background:none;border:none;padding:1.15rem 1.35rem;display:flex;align-items:center;justify-content:space-between;cursor:pointer;font-family:var(--font-sans);font-size:.92rem;font-weight:600;color:var(--text);text-align:left;gap:1rem;transition:background var(--ease-fast)}
    .faq-q:hover{background:var(--accent-p)}
    .faq-q .chevron{font-size:.75rem;color:var(--accent);transition:transform .3s;flex-shrink:0}
    .faq-q[aria-expanded="true"]{background:var(--accent-p)}
    .faq-q[aria-expanded="true"] .chevron{transform:rotate(180deg)}
    .faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease,padding .35s ease}
    .faq-a.open{max-height:400px}
    .faq-a p{padding:.25rem 1.35rem 1.15rem;font-size:.84rem;color:var(--text-2);line-height:1.75}
    .static-footer{background:var(--surface-2);border-top:1px solid var(--border);padding:2.5rem 1.5rem 1.5rem}
    [data-theme="dark"] .static-footer{background:var(--surface)}
    .sf-inner{max-width:820px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1.5rem}
    .sf-brand{font-family:var(--font-serif);font-size:1.1rem;font-weight:700;color:var(--text);text-decoration:none;display:inline-flex;align-items:center;gap:.55rem}
    .sf-brand span{color:var(--accent)}
    .sf-brand img{width:32px;height:32px;border-radius:6px}
    .sf-links{display:flex;gap:1.5rem}
    .sf-links a{font-size:.8rem;color:var(--text-2);text-decoration:none;transition:color var(--ease-fast)}
    .sf-links a:hover{color:var(--accent)}
    .sf-copy{max-width:820px;margin:.75rem auto 0;padding-top:1rem;border-top:1px solid var(--border);font-size:.72rem;color:var(--text-3);text-align:center}
    @media(max-width:768px){.static-nav{padding:0 1.25rem}.sn-links a:not(:last-child){display:none}}
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
    <span class="sec-lbl">Pusat Bantuan</span>
    <h1 class="sec-title">Ada yang Bisa Kami Bantu?</h1>
    <p class="sec-desc" style="max-width:540px;margin-left:auto;margin-right:auto">
      Temukan panduan lengkap cara menggunakan LuxBid dan jawaban atas pertanyaan yang paling sering ditanyakan.
    </p>
  </section>

  <div class="static-inner">
    <section class="section-block">
      <h2 class="section-title">
        <i class="bi bi-signpost-2"></i> Panduan Penggunaan LuxBid
      </h2>
      <div class="steps">
        <div class="step-item">
          <div class="step-num">1</div>
          <div class="step-body">
            <h4>Buat Akun Gratis</h4>
            <p>Kunjungi halaman <a href="{{ route('daftar.masyarakat') }}">Daftar</a>, isi nama lengkap, username unik, nomor telepon aktif, dan password. Akun Anda langsung aktif setelah pendaftaran berhasil.</p>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">2</div>
          <div class="step-body">
            <h4>Login ke Akun Anda</h4>
            <p>Masuk menggunakan username dan password yang telah didaftarkan. Jika lupa password, gunakan fitur <a href="{{ route('lupa.password') }}">Lupa Password</a> dengan memasukkan username dan nomor telepon terdaftar.</p>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">3</div>
          <div class="step-body">
            <h4>Lihat Lelang yang Sedang Aktif</h4>
            <p>Di halaman dashboard, Anda bisa melihat daftar lelang yang sedang berjalan. Klik "Ajukan Penawaran" pada barang yang Anda inginkan.</p>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">4</div>
          <div class="step-body">
            <h4>Ajukan Penawaran</h4>
            <p>Masukkan nominal penawaran Anda. Minimum kenaikan penawaran adalah Rp 1.000 dari penawaran tertinggi saat ini. Pantau terus karena lelang memiliki waktu terbatas!</p>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">5</div>
          <div class="step-body">
            <h4>Pantau Status Lelang</h4>
            <p>Anda bisa melihat status penawaran Anda di menu "Penawaran Saya". Timer akan terus berjalan, dan penawar tertinggi saat waktu habis menjadi pemenang resmi.</p>
          </div>
        </div>
        <div class="step-item">
          <div class="step-num">6</div>
          <div class="step-body">
            <h4>Download Faktur (Jika Menang)</h4>
            <p>Jika Anda memenangkan lelang, Anda bisa download faktur resmi dalam format PDF dari halaman penawaran Anda.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section-block">
      <h2 class="section-title">
        <i class="bi bi-patch-question"></i> Pertanyaan yang Sering Ditanyakan (FAQ)
      </h2>
      <div class="faq">
        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Apakah pendaftaran di LuxBid berbayar?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Tidak, pendaftaran di LuxBid 100% gratis. Anda hanya perlu mengisi data diri dan membuat akun tanpa biaya apapun.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Berapa minimum kenaikan penawaran?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Minimum kenaikan penawaran adalah <strong>Rp 1.000</strong> dari penawaran tertinggi saat ini. Sistem akan menolak penawaran yang lebih rendah.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Berapa lama waktu lelang berjalan?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Setiap lelang memiliki waktu yang berbeda sesuai pengaturan petugas. Timer akan terus berjalan dan bisa di-reset jika ada penawaran baru masuk.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Apakah saya bisa membatalkan penawaran?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Tidak, penawaran yang sudah diajukan tidak dapat dibatalkan. Pastikan Anda mempertimbangkan dengan matang sebelum mengajukan penawaran.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Bagaimana cara melelang barang saya sendiri?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Untuk melelang barang, silakan <a href="/kontak" style="color:var(--accent);font-weight:600">hubungi tim kami</a> via email, telepon, atau WhatsApp. Petugas akan membantu Anda melakukan verifikasi dan menentukan harga awal yang wajar.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Bagaimana jika saya lupa password?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Gunakan fitur <a href="{{ route('lupa.password') }}" style="color:var(--accent);font-weight:600">Lupa Password</a>. Masukkan username dan nomor telepon terdaftar, sistem akan menghasilkan password baru untuk Anda.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-q" onclick="toggleFAQ(this)" aria-expanded="false">
            Apakah data saya aman di LuxBid?
            <i class="fas fa-chevron-down chevron"></i>
          </button>
          <div class="faq-a">
            <p>Ya, kami menjaga keamanan data Anda dengan enkripsi dan sistem autentikasi yang aman. Semua transaksi tercatat dan transparan. Baca selengkapnya di <a href="/kebijakan-privasi" style="color:var(--accent);font-weight:600">Kebijakan Privasi</a>.</p>
          </div>
        </div>
      </div>
    </section>

    <div style="background:var(--accent-p);border:1px solid var(--accent-ln);border-radius:var(--r);padding:2.25rem;text-align:center">
      <h3 style="font-family:var(--font-serif);font-size:1.25rem;color:var(--text);margin-bottom:.6rem">Tidak Menemukan Jawaban?</h3>
      <p style="font-size:.86rem;color:var(--text-2);margin-bottom:1.4rem">Hubungi tim support kami untuk bantuan lebih lanjut.</p>
      <a href="/kontak" style="display:inline-flex;align-items:center;justify-content:center;gap:.5rem;background:var(--ink);color:var(--cream);padding:.85rem 2rem;border-radius:100px;font-size:.9rem;font-weight:600;text-decoration:none;font-family:var(--font-sans);box-shadow:0 4px 16px rgba(28,25,23,.18);transition:all var(--ease-fast);" onmouseover="this.style.background='var(--accent)';this.style.color='var(--ink)';this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 22px rgba(202,138,4,.28)'" onmouseout="this.style.background='var(--ink)';this.style.color='var(--cream)';this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(28,25,23,.18)'">
        <i class="fas fa-envelope"></i> Hubungi Kami
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
  <script>
    function toggleFAQ(btn) {
      const isOpen = btn.getAttribute('aria-expanded') === 'true';
      const answer = btn.nextElementSibling;
      btn.setAttribute('aria-expanded', !isOpen);
      answer.classList.toggle('open');
    }
  </script>
</body>
</html>
