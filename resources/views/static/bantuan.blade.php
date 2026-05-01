<!DOCTYPE html>
<html lang="id">
<head>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Bantuan — Lux Bid</title>
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
.inner{max-width:800px;margin:0 auto;padding:0 1.5rem 6rem}
.sec-title{font-family:'Playfair Display',serif;font-size:1.5rem;color:var(--ink);margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:2px solid var(--gold-ln)}
/* Steps */
.steps{display:flex;flex-direction:column;gap:1rem;margin-bottom:4rem}
.step-item{display:flex;gap:1.25rem;background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:1.5rem}
.step-num{width:36px;height:36px;min-width:36px;background:var(--ink);color:var(--cream);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1rem;font-weight:700}
.step-body h4{font-size:.95rem;font-weight:600;color:var(--ink);margin-bottom:.35rem}
.step-body p{font-size:.85rem;color:var(--ink-m);line-height:1.65}
/* FAQ Accordion */
.faq{display:flex;flex-direction:column;gap:.6rem}
.faq-item{background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);overflow:hidden}
.faq-q{width:100%;background:none;border:none;padding:1.1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;cursor:pointer;font-family:'Inter',sans-serif;font-size:.92rem;font-weight:600;color:var(--ink);text-align:left;gap:1rem;transition:background var(--ease)}
.faq-q:hover{background:var(--gold-p)}
.faq-q .chevron{font-size:.75rem;color:var(--gold);transition:transform .3s;flex-shrink:0}
.faq-q[aria-expanded="true"]{background:var(--gold-p)}
.faq-q[aria-expanded="true"] .chevron{transform:rotate(180deg)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease,padding .35s ease}
.faq-a.open{max-height:300px}
.faq-a p{padding:.25rem 1.25rem 1.1rem;font-size:.85rem;color:var(--ink-m);line-height:1.75}
/* Footer */
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
    <li><a href="/bantuan" class="active">Bantuan</a></li>
    <li><a href="/kontak">Kontak</a></li>
    <li><a href="{{ route('login.masyarakat') }}" class="ln-cta">Masuk</a></li>
  </ul>
</nav>

<div class="page-hero">
  <div class="lbl">Pusat Bantuan</div>
  <h1 class="ttl">Ada yang Bisa Kami Bantu?</h1>
  <p class="dsc">Temukan panduan lengkap cara menggunakan LuxBid dan jawaban atas pertanyaan yang paling sering ditanyakan.</p>
</div>

<div class="inner">

  <h2 class="sec-title"><i class="fas fa-map-signs" style="color:var(--gold);margin-right:.5rem"></i>Panduan Penggunaan LuxBid</h2>
  <div class="steps">
    <div class="step-item">
      <div class="step-num">1</div>
      <div class="step-body">
        <h4>Buat Akun Gratis</h4>
        <p>Kunjungi halaman <a href="{{ route('daftar.masyarakat') }}" style="color:var(--gold)">Daftar</a>, isi nama lengkap, username unik, nomor telepon aktif, dan password. Akun Anda langsung aktif setelah pendaftaran berhasil.</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">2</div>
      <div class="step-body">
        <h4>Login ke Akun Anda</h4>
        <p>Masuk menggunakan username dan password yang telah didaftarkan. Jika lupa password, gunakan fitur <a href="{{ route('lupa.password') }}" style="color:var(--gold)">Lupa Password</a> dengan memasukkan username dan nomor telepon terdaftar.</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">3</div>
      <div class="step-body">
        <h4>Jelajahi Lelang Aktif</h4>
        <p>Setelah login, Anda akan melihat daftar semua lelang yang sedang berjalan beserta foto barang, harga awal, dan sisa waktu lelang. Klik kartu lelang untuk melihat detail lengkap.</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">4</div>
      <div class="step-body">
        <h4>Ajukan Penawaran</h4>
        <p>Masukkan nominal penawaran Anda — minimal harus lebih tinggi dari penawaran tertinggi saat ini. Setiap penawaran baru akan mereset timer lelang selama 6 menit untuk memberi kesempatan peserta lain merespons.</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">5</div>
      <div class="step-body">
        <h4>Pantau Posisi Anda</h4>
        <p>Halaman lelang diperbarui secara otomatis setiap beberapa detik. Anda dapat melihat daftar semua penawar beserta peringkat masing-masing secara real-time.</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">6</div>
      <div class="step-body">
        <h4>Tunggu Hasil Lelang</h4>
        <p>Lelang berakhir saat timer habis tanpa penawaran baru. Penawar dengan harga tertinggi ditetapkan sebagai pemenang. Hasil dapat dilihat di halaman Riwayat Penawaran Anda.</p>
      </div>
    </div>
  </div>

  <h2 class="sec-title"><i class="fas fa-question-circle" style="color:var(--gold);margin-right:.5rem"></i>Pertanyaan yang Sering Ditanyakan</h2>
  <div class="faq">

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Apakah mendaftar di LuxBid gratis?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Ya, pendaftaran akun di LuxBid sepenuhnya gratis. Anda hanya perlu menyiapkan nama lengkap, username, nomor telepon aktif, dan password untuk mulai berpartisipasi dalam lelang.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Bagaimana cara kerja timer lelang?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Setiap sesi lelang memiliki timer 6 menit. Setiap kali ada penawaran baru masuk, timer akan direset kembali ke 6 menit. Lelang berakhir ketika timer habis tanpa ada penawaran baru yang masuk. Sistem ini memastikan semua peserta mendapat kesempatan yang adil.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Bisakah saya mengubah atau membatalkan penawaran?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Ya, Anda dapat mengedit atau menghapus penawaran selama lelang masih berlangsung dan penawaran Anda belum menjadi yang tertinggi. Setelah lelang ditutup, penawaran tidak dapat diubah.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Apa yang terjadi jika saya memenangkan lelang?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Jika penawaran Anda tertinggi saat timer habis, Anda ditetapkan sebagai pemenang. Status kemenangan akan tercatat di halaman Riwayat Penawaran Anda. Tim petugas akan menghubungi Anda melalui nomor telepon terdaftar untuk proses selanjutnya.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Bagaimana jika saya lupa password?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Gunakan fitur <a href="{{ route('lupa.password') }}" style="color:var(--gold)">Lupa Password</a> di halaman login. Masukkan username dan nomor telepon yang terdaftar — sistem akan otomatis membuat password baru dan menampilkannya sekali. Segera ganti password setelah berhasil masuk.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Apakah data pribadi saya aman di LuxBid?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Keamanan data Anda adalah prioritas kami. Password disimpan dalam bentuk terenkripsi (bcrypt) dan tidak pernah disimpan dalam bentuk teks biasa. Kami tidak membagikan data pribadi Anda kepada pihak ketiga tanpa izin. Baca selengkapnya di <a href="/kebijakan-privasi" style="color:var(--gold)">Kebijakan Privasi</a> kami.</p>
      </div>
    </div>

    <div class="faq-item">
      <button class="faq-q" aria-expanded="false" onclick="toggleFaq(this)">
        Berapa penawaran minimum yang bisa saya ajukan?
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="faq-a">
        <p>Penawaran Anda harus lebih tinggi dari penawaran tertinggi yang ada saat ini (minimal selisih Rp 1). Sistem akan menolak penawaran yang sama atau lebih rendah dari penawaran tertinggi untuk menjaga keadilan lelang.</p>
      </div>
    </div>

  </div>

  <div style="margin-top:3rem;background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:2rem;text-align:center">
    <p style="font-size:.95rem;color:var(--ink-m);margin-bottom:1rem">Tidak menemukan jawaban yang Anda cari?</p>
    <a href="/kontak" style="display:inline-flex;align-items:center;gap:.5rem;background:var(--ink);color:var(--cream);padding:.75rem 1.75rem;border-radius:100px;font-size:.9rem;font-weight:600;text-decoration:none;transition:all var(--ease)" onmouseover="this.style.background='var(--gold)';this.style.color='var(--ink)'" onmouseout="this.style.background='var(--ink)';this.style.color='var(--cream)'">
      <i class="fas fa-headset"></i> Hubungi Tim Support
    </a>
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

<script>
function toggleFaq(btn) {
  const answer = btn.nextElementSibling;
  const isOpen = btn.getAttribute('aria-expanded') === 'true';
  // close all
  document.querySelectorAll('.faq-q').forEach(b => {
    b.setAttribute('aria-expanded', 'false');
    b.nextElementSibling.classList.remove('open');
  });
  if (!isOpen) {
    btn.setAttribute('aria-expanded', 'true');
    answer.classList.add('open');
  }
}
</script>
<script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
