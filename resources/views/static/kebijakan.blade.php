<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Kebijakan Privasi — LuxBid</title>
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
    .static-inner{max-width:780px;margin:0 auto;padding:3rem 1.5rem 6rem}
    .policy-section{margin-bottom:3rem}
    .policy-section h2{font-family:var(--font-serif);font-size:1.45rem;color:var(--text);margin-bottom:.9rem;padding-bottom:.5rem;border-bottom:1px solid var(--border)}
    .policy-section p{font-size:.88rem;color:var(--text-2);line-height:1.85;margin-bottom:1rem}
    .policy-section ul{margin:.75rem 0 1rem 1.5rem;list-style:disc;color:var(--text-2)}
    .policy-section li{font-size:.86rem;line-height:1.75;margin-bottom:.4rem}
    .policy-section strong{color:var(--text);font-weight:600}
    .policy-meta{background:var(--accent-p);border:1px solid var(--accent-ln);border-radius:var(--r);padding:1.25rem 1.5rem;font-size:.82rem;color:var(--text-2);margin-bottom:3rem}
    .static-footer{background:var(--surface-2);border-top:1px solid var(--border);padding:2.5rem 1.5rem 1.5rem}
    [data-theme="dark"] .static-footer{background:var(--surface)}
    .sf-inner{max-width:780px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1.5rem}
    .sf-brand{font-family:var(--font-serif);font-size:1.1rem;font-weight:700;color:var(--text);text-decoration:none;display:inline-flex;align-items:center;gap:.55rem}
    .sf-brand span{color:var(--accent)}
    .sf-brand img{width:32px;height:32px;border-radius:6px}
    .sf-links{display:flex;gap:1.5rem}
    .sf-links a{font-size:.8rem;color:var(--text-2);text-decoration:none;transition:color var(--ease-fast)}
    .sf-links a:hover{color:var(--accent)}
    .sf-copy{max-width:780px;margin:.75rem auto 0;padding-top:1rem;border-top:1px solid var(--border);font-size:.72rem;color:var(--text-3);text-align:center}
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
    <span class="sec-lbl">Dokumen Legal</span>
    <h1 class="sec-title">Kebijakan Privasi</h1>
    <p class="sec-desc" style="max-width:560px;margin-left:auto;margin-right:auto">
      Kami menghargai privasi Anda. Dokumen ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda.
    </p>
  </section>

  <div class="static-inner">
    <div class="policy-meta">
      <strong>Terakhir Diperbarui:</strong> {{ date('d F Y') }}<br>
      <strong>Berlaku Efektif:</strong> 1 Januari 2026
    </div>

    <section class="policy-section">
      <h2><i class="bi bi-info-circle" style="color:var(--accent);margin-right:.5rem"></i> Pendahuluan</h2>
      <p>
        Selamat datang di <strong>LuxBid</strong>, platform pelelangan daring yang transparan dan terpercaya. Kami berkomitmen untuk melindungi privasi dan keamanan data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, menyimpan, dan melindungi informasi yang Anda berikan saat menggunakan layanan kami.
      </p>
      <p>
        Dengan menggunakan platform LuxBid, Anda menyetujui praktik yang dijelaskan dalam kebijakan ini. Jika Anda tidak setuju, harap tidak menggunakan layanan kami.
      </p>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-folder2-open" style="color:var(--accent);margin-right:.5rem"></i> Informasi yang Kami Kumpulkan</h2>
      <p>Kami mengumpulkan informasi berikut untuk menyediakan dan meningkatkan layanan kami:</p>
      <ul>
        <li><strong>Data Identitas:</strong> Nama lengkap, username, nomor telepon, dan alamat email (jika disediakan).</li>
        <li><strong>Data Transaksi:</strong> Riwayat penawaran lelang, barang yang dimenangkan, dan nominal penawaran.</li>
        <li><strong>Data Teknis:</strong> Alamat IP, jenis browser, perangkat yang digunakan, dan log aktivitas sistem untuk keamanan dan diagnostik.</li>
        <li><strong>Data Opsional:</strong> Foto profil dan informasi tambahan yang Anda berikan secara sukarela.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-gear" style="color:var(--accent);margin-right:.5rem"></i> Bagaimana Kami Menggunakan Informasi Anda</h2>
      <p>Informasi yang kami kumpulkan digunakan untuk:</p>
      <ul>
        <li>Memproses pendaftaran akun dan autentikasi pengguna.</li>
        <li>Mengelola sesi lelang, penawaran, dan transaksi secara transparan.</li>
        <li>Mengirimkan notifikasi terkait lelang, hasil penawaran, dan pembaruan penting.</li>
        <li>Menjaga keamanan platform, mencegah kecurangan, dan mendeteksi aktivitas mencurigakan.</li>
        <li>Menyediakan layanan dukungan pelanggan dan merespons pertanyaan Anda.</li>
        <li>Menghasilkan laporan dan analitik internal untuk meningkatkan kualitas layanan.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-shield-lock" style="color:var(--accent);margin-right:.5rem"></i> Keamanan Data</h2>
      <p>
        Kami menggunakan teknologi enkripsi dan protokol keamanan standar industri untuk melindungi data pribadi Anda dari akses tidak sah, kebocoran, atau penyalahgunaan. Semua data sensitif disimpan di server yang aman dan hanya dapat diakses oleh petugas yang berwenang.
      </p>
      <p>
        Meskipun kami menerapkan langkah-langkah keamanan terbaik, tidak ada sistem yang 100% aman. Kami mendorong Anda untuk menjaga kerahasiaan password dan segera menghubungi kami jika mencurigai adanya aktivitas yang tidak wajar.
      </p>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-share" style="color:var(--accent);margin-right:.5rem"></i> Berbagi Informasi dengan Pihak Ketiga</h2>
      <p>
        Kami <strong>tidak menjual, menyewakan, atau membagikan</strong> data pribadi Anda kepada pihak ketiga untuk tujuan pemasaran. Namun, kami dapat membagikan informasi Anda dalam kondisi berikut:
      </p>
      <ul>
        <li><strong>Penyedia Layanan:</strong> Kepada vendor teknologi (hosting, email, dll.) yang membantu kami menjalankan platform, dengan perjanjian kerahasiaan yang ketat.</li>
        <li><strong>Kepatuhan Hukum:</strong> Jika diwajibkan oleh hukum, pengadilan, atau otoritas pemerintah.</li>
        <li><strong>Perlindungan Hak:</strong> Untuk melindungi hak, keamanan, atau properti LuxBid dan pengguna kami.</li>
      </ul>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-person-check" style="color:var(--accent);margin-right:.5rem"></i> Hak Anda</h2>
      <p>Anda memiliki hak berikut terkait data pribadi Anda:</p>
      <ul>
        <li><strong>Akses & Koreksi:</strong> Anda dapat mengakses dan memperbarui informasi profil Anda melalui dashboard akun.</li>
        <li><strong>Penghapusan:</strong> Anda dapat meminta penghapusan akun dan data pribadi dengan menghubungi tim support kami.</li>
        <li><strong>Penarikan Persetujuan:</strong> Anda dapat menarik persetujuan untuk pemrosesan data tertentu, namun ini dapat membatasi akses Anda ke layanan kami.</li>
        <li><strong>Portabilitas Data:</strong> Anda dapat meminta salinan data pribadi Anda dalam format yang dapat dibaca mesin.</li>
      </ul>
      <p>Untuk menggunakan hak-hak ini, silakan hubungi kami melalui halaman <a href="/kontak" style="color:var(--accent);font-weight:600">Kontak</a>.</p>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-clock-history" style="color:var(--accent);margin-right:.5rem"></i> Retensi Data</h2>
      <p>
        Kami menyimpan data pribadi Anda selama akun Anda aktif dan selama diperlukan untuk menyediakan layanan, mematuhi kewajiban hukum, menyelesaikan sengketa, dan menegakkan perjanjian kami. Data yang tidak lagi diperlukan akan dihapus atau dianonimkan.
      </p>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-cookie" style="color:var(--accent);margin-right:.5rem"></i> Cookies dan Teknologi Pelacakan</h2>
      <p>
        Kami menggunakan <strong>localStorage</strong> dan teknologi serupa untuk menyimpan preferensi Anda (seperti mode gelap) dan meningkatkan pengalaman pengguna. Kami tidak menggunakan cookies iklan pihak ketiga. Anda dapat menghapus data lokal ini melalui pengaturan browser Anda.
      </p>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-pencil-square" style="color:var(--accent);margin-right:.5rem"></i> Perubahan Kebijakan</h2>
      <p>
        Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu untuk mencerminkan perubahan dalam praktik kami atau persyaratan hukum. Perubahan akan diposting di halaman ini dengan tanggal "Terakhir Diperbarui" yang baru. Kami mendorong Anda untuk meninjau kebijakan ini secara berkala.
      </p>
    </section>

    <section class="policy-section">
      <h2><i class="bi bi-envelope" style="color:var(--accent);margin-right:.5rem"></i> Hubungi Kami</h2>
      <p>Jika Anda memiliki pertanyaan atau kekhawatiran tentang Kebijakan Privasi ini, silakan hubungi kami:</p>
      <ul style="list-style:none;margin-left:0">
        <li style="margin-bottom:.5rem"><strong>Email:</strong> <a href="mailto:privacy@luxbid.com" style="color:var(--accent)">privacy@luxbid.com</a></li>
        <li style="margin-bottom:.5rem"><strong>Telepon:</strong> <a href="tel:+6285869074622" style="color:var(--accent)">+62 858-6907-4622</a></li>
        <li><strong>Halaman Kontak:</strong> <a href="/kontak" style="color:var(--accent)">luxbid.com/kontak</a></li>
      </ul>
    </section>

    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--r);padding:1.75rem;text-align:center;margin-top:3rem">
      <p style="font-size:.86rem;color:var(--text-2);line-height:1.75;margin-bottom:1.1rem">
        Dengan menggunakan LuxBid, Anda mengonfirmasi bahwa Anda telah membaca, memahami, dan menyetujui Kebijakan Privasi ini.
      </p>
      <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:.5rem;background:var(--ink);color:var(--cream);padding:.85rem 2rem;border-radius:100px;font-size:.9rem;font-weight:600;text-decoration:none;font-family:var(--font-sans);box-shadow:0 4px 16px rgba(28,25,23,.18);transition:all var(--ease-fast);" onmouseover="this.style.background='var(--accent)';this.style.color='var(--ink)';this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 22px rgba(202,138,4,.28)'" onmouseout="this.style.background='var(--ink)';this.style.color='var(--cream)';this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(28,25,23,.18)'">
        <i class="bi bi-house-door"></i> Kembali ke Beranda
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
