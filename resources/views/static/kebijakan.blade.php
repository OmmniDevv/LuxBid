<!DOCTYPE html>
<html lang="id">
<head>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Kebijakan Privasi — Lux Bid</title>
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
.ln-links a:hover{color:var(--ink);background:var(--cream-d)}
.ln-cta{background:var(--ink)!important;color:var(--cream)!important;padding:.45rem 1.2rem!important}
.ln-cta:hover{background:var(--gold)!important;color:var(--ink)!important}
.page-hero{padding:9rem 1.5rem 4rem;text-align:center}
.lbl{display:inline-block;font-size:.68rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);margin-bottom:.75rem}
.ttl{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3rem);line-height:1.1;color:var(--ink)}
.dsc{margin-top:.9rem;font-size:.9rem;color:var(--ink-m);max-width:520px;margin-left:auto;margin-right:auto;line-height:1.75}
.inner{max-width:760px;margin:0 auto;padding:0 1.5rem 6rem}
.policy-section{margin-bottom:2.5rem}
.policy-section h2{font-family:'Playfair Display',serif;font-size:1.25rem;color:var(--ink);margin-bottom:.9rem;padding-bottom:.6rem;border-bottom:2px solid var(--gold-ln);display:flex;align-items:center;gap:.6rem}
.policy-section h2 .ico{color:var(--gold);font-size:1rem}
.policy-section p{font-size:.88rem;color:var(--ink-m);line-height:1.85;margin-bottom:.75rem}
.policy-section ul{padding-left:1.25rem;margin-bottom:.75rem}
.policy-section ul li{font-size:.88rem;color:var(--ink-m);line-height:1.85;margin-bottom:.3rem}
.policy-section ul li::marker{color:var(--gold)}
.meta-box{background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:1.25rem 1.5rem;margin-bottom:3rem;font-size:.82rem;color:var(--ink-m);display:flex;gap:2rem;flex-wrap:wrap}
.meta-box span{display:flex;align-items:center;gap:.4rem}
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
    <li><a href="/kontak">Kontak</a></li>
    <li><a href="{{ route('login.masyarakat') }}" class="ln-cta">Masuk</a></li>
  </ul>
</nav>

<div class="page-hero">
  <div class="lbl">Legal</div>
  <h1 class="ttl">Kebijakan Privasi</h1>
  <p class="dsc">Kami berkomitmen menjaga privasi dan keamanan data pribadi Anda. Dokumen ini menjelaskan bagaimana LuxBid mengumpulkan, menggunakan, dan melindungi informasi Anda.</p>
</div>

<div class="inner">

  <div class="meta-box">
    <span><i class="fas fa-calendar-alt" style="color:var(--gold)"></i> Berlaku sejak: 1 Mei 2026</span>
    <span><i class="fas fa-sync-alt" style="color:var(--gold)"></i> Terakhir diperbarui: 1 Mei 2026</span>
    <span><i class="fas fa-building" style="color:var(--gold)"></i> LuxBid — TEAM HUNTERS</span>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-info-circle ico"></i> 1. Tentang Kebijakan Ini</h2>
    <p>Kebijakan Privasi ini berlaku untuk platform LuxBid yang dioperasikan oleh TEAM HUNTERS. Dengan mendaftar dan menggunakan layanan LuxBid, Anda menyetujui pengumpulan dan penggunaan informasi sebagaimana dijelaskan dalam dokumen ini.</p>
    <p>Kami mendorong Anda untuk membaca kebijakan ini secara menyeluruh. Jika Anda tidak menyetujui ketentuan yang ada, harap hentikan penggunaan layanan kami.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-database ico"></i> 2. Data yang Kami Kumpulkan</h2>
    <p>Saat Anda mendaftar dan menggunakan LuxBid, kami mengumpulkan informasi berikut:</p>
    <ul>
      <li><strong>Data Identitas:</strong> Nama lengkap dan username yang Anda pilih.</li>
      <li><strong>Data Kontak:</strong> Nomor telepon aktif yang digunakan untuk verifikasi dan komunikasi.</li>
      <li><strong>Data Akun:</strong> Password yang disimpan dalam bentuk terenkripsi (bcrypt hash).</li>
      <li><strong>Data Aktivitas:</strong> Riwayat penawaran, lelang yang diikuti, dan waktu aktivitas.</li>
      <li><strong>Data Teknis:</strong> Informasi sesi login untuk keperluan keamanan.</li>
    </ul>
    <p>Kami <strong>tidak</strong> mengumpulkan data kartu kredit, rekening bank, atau informasi keuangan sensitif lainnya secara langsung melalui platform ini.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-cogs ico"></i> 3. Penggunaan Data</h2>
    <p>Data yang kami kumpulkan digunakan untuk tujuan berikut:</p>
    <ul>
      <li>Membuat dan mengelola akun pengguna Anda.</li>
      <li>Memproses dan mencatat penawaran lelang secara akurat.</li>
      <li>Menghubungi Anda terkait hasil lelang atau informasi penting lainnya.</li>
      <li>Memverifikasi identitas saat proses reset password.</li>
      <li>Meningkatkan keamanan platform dan mencegah penyalahgunaan.</li>
      <li>Menghasilkan laporan dan statistik lelang untuk keperluan operasional.</li>
    </ul>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-share-alt ico"></i> 4. Berbagi Data dengan Pihak Ketiga</h2>
    <p>LuxBid <strong>tidak menjual, menyewakan, atau memperdagangkan</strong> data pribadi Anda kepada pihak ketiga untuk tujuan komersial.</p>
    <p>Data Anda hanya dapat dibagikan dalam kondisi berikut:</p>
    <ul>
      <li>Atas permintaan resmi dari otoritas hukum yang berwenang sesuai peraturan perundang-undangan yang berlaku.</li>
      <li>Kepada petugas atau administrator platform yang memerlukan data tersebut untuk menjalankan fungsi operasional lelang.</li>
    </ul>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-shield-alt ico"></i> 5. Keamanan Data</h2>
    <p>Kami menerapkan langkah-langkah teknis dan organisasi yang wajar untuk melindungi data Anda, antara lain:</p>
    <ul>
      <li>Password disimpan menggunakan algoritma hashing bcrypt yang tidak dapat dibalik.</li>
      <li>Sesi login dikelola dengan mekanisme token yang aman.</li>
      <li>Akses ke data pengguna dibatasi hanya untuk personel yang berwenang.</li>
      <li>Sistem diperbarui secara berkala untuk menutup celah keamanan.</li>
    </ul>
    <p>Meskipun demikian, tidak ada sistem yang 100% aman. Kami menyarankan Anda untuk menggunakan password yang kuat dan tidak membagikan kredensial akun kepada siapapun.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-user-shield ico"></i> 6. Hak Pengguna</h2>
    <p>Sebagai pengguna LuxBid, Anda memiliki hak-hak berikut terkait data pribadi Anda:</p>
    <ul>
      <li><strong>Hak Akses:</strong> Melihat data pribadi yang tersimpan melalui halaman profil akun Anda.</li>
      <li><strong>Hak Koreksi:</strong> Memperbarui nama lengkap, nomor telepon, dan foto profil kapan saja melalui pengaturan akun.</li>
      <li><strong>Hak Penghapusan:</strong> Mengajukan permintaan penghapusan akun dengan menghubungi tim kami. Data akan dihapus dalam 30 hari kerja.</li>
      <li><strong>Hak Portabilitas:</strong> Meminta salinan data aktivitas Anda dalam format yang dapat dibaca.</li>
    </ul>
    <p>Untuk menggunakan hak-hak di atas, silakan hubungi kami melalui <a href="/kontak" style="color:var(--gold)">halaman Kontak</a>.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-cookie-bite ico"></i> 7. Cookie dan Penyimpanan Lokal</h2>
    <p>LuxBid menggunakan cookie sesi untuk menjaga status login Anda selama menggunakan platform. Cookie ini bersifat sementara dan akan dihapus saat Anda logout atau menutup browser.</p>
    <p>Kami juga menggunakan <code>localStorage</code> browser untuk menyimpan preferensi tampilan (mode gelap/terang) Anda. Data ini tidak dikirim ke server kami.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-child ico"></i> 8. Pengguna di Bawah Umur</h2>
    <p>Layanan LuxBid ditujukan untuk pengguna berusia 17 tahun ke atas. Kami tidak secara sengaja mengumpulkan data dari anak-anak di bawah usia tersebut. Jika Anda mengetahui adanya akun yang dibuat oleh pengguna di bawah umur, harap segera laporkan kepada kami.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-edit ico"></i> 9. Perubahan Kebijakan</h2>
    <p>Kami berhak memperbarui Kebijakan Privasi ini sewaktu-waktu. Perubahan signifikan akan diinformasikan melalui pengumuman di platform. Tanggal pembaruan terakhir selalu tercantum di bagian atas dokumen ini.</p>
    <p>Penggunaan layanan LuxBid setelah perubahan kebijakan diterbitkan dianggap sebagai persetujuan Anda terhadap kebijakan yang diperbarui.</p>
  </div>

  <div class="policy-section">
    <h2><i class="fas fa-envelope ico"></i> 10. Hubungi Kami</h2>
    <p>Jika Anda memiliki pertanyaan, kekhawatiran, atau permintaan terkait kebijakan privasi ini, silakan hubungi kami:</p>
    <ul>
      <li>Email: <a href="mailto:support@luxbid.id" style="color:var(--gold)">support@luxbid.id</a></li>
      <li>WhatsApp: <a href="https://wa.me/6285869074622" style="color:var(--gold)" target="_blank" rel="noopener">+62 858-6907-4622</a></li>
      <li>Halaman Kontak: <a href="/kontak" style="color:var(--gold)">luxbid.id/kontak</a></li>
    </ul>
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
