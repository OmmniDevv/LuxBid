<!DOCTYPE html>
<html lang="id">
<head>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Lux Bid</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
<link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--gold:#B8860B;--gold-l:#D4A017;--gold-p:#FDF8EE;--gold-ln:rgba(184,134,11,.2);--ink:#1C1A15;--ink-s:#3A3527;--ink-m:#7A7260;--cream:#FAF7F0;--cream-d:#EDE8DC;--white:#FFFFFF;--r:12px;--rs:7px;--ease:.24s cubic-bezier(.4,0,.2,1);}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--cream);color:var(--ink);overflow-x:hidden}
.ln{position:fixed;inset:0 0 auto 0;z-index:200;display:flex;align-items:center;justify-content:space-between;padding:0 3rem;height:64px;background:rgba(250,247,240,.88);backdrop-filter:blur(14px);border-bottom:1px solid var(--gold-ln)}
.ln-logo{font-family:'Playfair Display',serif;font-size:1.25rem;font-weight:700;color:var(--ink);text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.ln-logo img{width:44px;height:44px;object-fit:contain;border-radius:8px}
.ln-logo span{color:var(--gold)}
.ln-links{display:flex;align-items:center;gap:.25rem;list-style:none}
.ln-links a{font-size:.85rem;font-weight:500;color:var(--ink-m);text-decoration:none;padding:.45rem .9rem;border-radius:100px;transition:color var(--ease),background var(--ease)}
.ln-links a:hover{color:var(--ink);background:var(--cream-d)}
.ln-cta{background:var(--ink)!important;color:var(--cream)!important;padding:.45rem 1.2rem!important}
.ln-cta:hover{background:var(--gold)!important;color:var(--ink)!important}
.hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:7rem 1.5rem 5rem;position:relative}
.hero::before{content:'';position:absolute;width:640px;height:640px;border-radius:50%;border:1px solid var(--gold-ln);top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none}
.badge{display:inline-flex;align-items:center;gap:.45rem;background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:100px;padding:.3rem 1rem;font-size:.72rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--gold);margin-bottom:1.6rem}
.badge::before{content:'';width:6px;height:6px;border-radius:50%;background:var(--gold);animation:blink 2s ease-in-out infinite}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.25}}
.h1{font-family:'Playfair Display',serif;font-size:clamp(2.6rem,6.5vw,5rem);font-weight:700;line-height:1.06;letter-spacing:-.03em;color:var(--ink);max-width:760px}
.h1 em{font-style:italic;color:var(--gold)}
.hsub{margin-top:1.4rem;font-size:1rem;color:var(--ink-m);max-width:480px;line-height:1.75}
.hbtns{display:flex;gap:.9rem;margin-top:2.4rem;flex-wrap:wrap;justify-content:center}
.btn-p{display:inline-flex;align-items:center;gap:.45rem;background:var(--ink);color:var(--cream);padding:.8rem 2rem;border-radius:100px;font-size:.9rem;font-weight:500;text-decoration:none;transition:background var(--ease),transform var(--ease);box-shadow:0 4px 18px rgba(28,26,21,.18)}
.btn-p:hover{background:var(--gold);color:var(--ink);transform:translateY(-2px);text-decoration:none}
.btn-o{display:inline-flex;align-items:center;gap:.45rem;background:transparent;color:var(--ink);padding:.78rem 1.8rem;border-radius:100px;font-size:.9rem;font-weight:500;text-decoration:none;border:1.5px solid rgba(28,26,21,.18);transition:all var(--ease)}
.btn-o:hover{border-color:var(--gold);background:var(--gold-p);transform:translateY(-2px);text-decoration:none;color:var(--ink)}
.stats{background:var(--ink);display:flex;justify-content:center;flex-wrap:wrap}
.stat{text-align:center;padding:2.4rem 3.5rem;border-right:1px solid rgba(255,255,255,.07)}
.stat:last-child{border-right:none}
.stat-n{font-family:'Playfair Display',serif;font-size:2.2rem;color:var(--gold-l);display:block}
.stat-l{font-size:.72rem;color:rgba(250,247,240,.4);text-transform:uppercase;letter-spacing:.1em;margin-top:.2rem}
.sec{position:relative}
.inner{max-width:1080px;margin:0 auto;padding:6rem 1.5rem}
.lbl{display:inline-block;font-size:.68rem;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--gold);margin-bottom:.75rem}
.ttl{font-family:'Playfair Display',serif;font-size:clamp(1.85rem,3.5vw,2.8rem);line-height:1.12;color:var(--ink)}
.dsc{margin-top:.9rem;font-size:.95rem;color:var(--ink-m);max-width:480px;line-height:1.75}
.rv{opacity:0;transform:translateY(26px);transition:opacity .6s ease,transform .6s ease}
.rv.in{opacity:1;transform:none}
#ck{background:var(--cream)}
.steps{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin-top:3rem}
.step{background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:1.75rem;position:relative;overflow:hidden;transition:transform var(--ease),box-shadow var(--ease)}
.step:hover{transform:translateY(-4px);box-shadow:0 10px 32px rgba(184,134,11,.1)}
.step-n{font-family:'Playfair Display',serif;font-size:3.5rem;color:var(--cream-d);position:absolute;top:.4rem;right:.9rem;line-height:1}
.step-i{width:42px;height:42px;background:var(--gold-p);border-radius:var(--rs);display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin-bottom:1rem}
.step h4{font-size:.95rem;font-weight:600;color:var(--ink);margin-bottom:.4rem}
.step p{font-size:.82rem;color:var(--ink-m);line-height:1.65}
#ft{background:var(--gold-p)}
.ftgrid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center;margin-top:2.8rem}
.ftlist{display:flex;flex-direction:column;gap:1rem}
.fti{display:flex;gap:.9rem;align-items:flex-start;background:var(--white);border:1px solid rgba(184,134,11,.1);border-radius:var(--rs);padding:1.1rem;transition:transform var(--ease)}
.fti:hover{transform:translateX(4px)}
.fti-ic{width:36px;height:36px;flex-shrink:0;background:var(--gold-p);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:1rem}
.fti h5{font-size:.9rem;font-weight:600;margin-bottom:.2rem;color:var(--ink)}
.fti p{font-size:.8rem;color:var(--ink-m);line-height:1.6}
.mock{background:var(--white);border-radius:var(--r);border:1px solid rgba(184,134,11,.18);padding:1.4rem;box-shadow:0 18px 54px rgba(28,26,21,.07)}
.mock-bar{display:flex;align-items:center;gap:.5rem;margin-bottom:1.1rem}
.mock-dot{width:9px;height:9px;border-radius:50%}
.mock-t{font-size:.72rem;color:var(--ink-m);margin-left:.4rem;font-weight:500}
.lot{background:var(--cream);border-radius:var(--rs);padding:1rem;margin-bottom:.75rem}
.lot-cat{font-size:.68rem;color:var(--ink-m);text-transform:uppercase;letter-spacing:.08em}
.lot-name{font-weight:600;font-size:.9rem;color:var(--ink);margin:.2rem 0}
.lot-row{display:flex;align-items:center;justify-content:space-between;margin-top:.75rem}
.lot-price{font-family:'Playfair Display',serif;font-size:1.35rem;color:#1D6A47}
.lot-timer{font-size:.72rem;background:#FFF4E5;color:#A85B00;padding:.22rem .55rem;border-radius:100px;font-weight:500}
.lot-btn{width:100%;margin-top:.9rem;background:var(--ink);color:var(--cream);border:none;border-radius:100px;padding:.65rem;font-size:.82rem;font-weight:500;cursor:pointer;font-family:'Inter',sans-serif;transition:background var(--ease);display:block;text-align:center;text-decoration:none}
.lot-btn:hover{background:var(--gold);color:var(--ink);text-decoration:none}
#lelang{background:var(--white)}
.lalst{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;margin-top:2.5rem}
.lal-card{background:var(--white);border:1.5px solid var(--gold-ln);border-radius:var(--r);display:flex;flex-direction:column;transition:transform var(--ease),box-shadow var(--ease),border-color var(--ease);overflow:hidden}
.lal-card:hover{transform:translateY(-4px);box-shadow:0 12px 36px rgba(184,134,11,.1);border-color:var(--gold)}
.lal-top{display:flex;align-items:center;justify-content:space-between}
.lal-badge{font-size:.68rem;font-weight:600;color:#1D6A47;background:#E8F5EE;padding:.2rem .65rem;border-radius:100px}
.lal-lot{font-size:.7rem;color:var(--ink-m);font-weight:500}
.lal-name{font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);line-height:1.3}
.lal-desc{font-size:.8rem;color:var(--ink-m);line-height:1.6;margin:0}
.lal-meta{display:flex;gap:1rem;font-size:.74rem;color:var(--ink-m)}
.lal-meta i{color:var(--gold);margin-right:.3rem}
.lal-price-wrap{display:flex;justify-content:space-between;align-items:flex-end;background:var(--cream);border-radius:var(--rs);padding:.9rem 1rem;margin-top:.25rem}
.lal-price-lbl{font-size:.68rem;color:var(--ink-m);margin-bottom:.1rem}
.lal-price{font-family:'Playfair Display',serif;font-size:1.3rem;color:#1D6A47;font-weight:600}
.lal-btn{display:block;width:100%;padding:.7rem;background:var(--ink);color:var(--cream);border:none;border-radius:100px;font-size:.88rem;font-weight:600;text-align:center;text-decoration:none;cursor:pointer;transition:background var(--ease)}
.lal-btn:hover{background:var(--gold);color:var(--ink);text-decoration:none}
.lal-gate{background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:1rem;text-align:center}
.lal-gate p{font-size:.78rem;color:var(--ink-m);margin-bottom:.65rem}
.lal-gate-btns{display:flex;gap:.5rem;justify-content:center}
.lal-btn-login,.lal-btn-daftar{flex:1;padding:.55rem .9rem;border-radius:100px;font-size:.82rem;font-weight:600;text-align:center;text-decoration:none;transition:all var(--ease)}
.lal-btn-login{background:var(--ink);color:var(--cream)}
.lal-btn-login:hover{background:var(--gold);color:var(--ink);text-decoration:none}
.lal-btn-daftar{background:transparent;color:var(--ink);border:1.5px solid rgba(28,26,21,.2)}
.lal-btn-daftar:hover{border-color:var(--gold);background:var(--gold-p);text-decoration:none;color:var(--ink)}
#masuk{background:var(--white)}
.cards{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:3rem}
.card-ld{border-radius:var(--r);padding:2.2rem;border:1.5px solid var(--gold-ln);transition:transform var(--ease),border-color var(--ease),box-shadow var(--ease)}
.card-ld:hover{transform:translateY(-4px);border-color:var(--gold);box-shadow:0 12px 36px rgba(184,134,11,.1)}
.c-mas{background:var(--gold-p)}.c-adm{background:var(--ink)}
.card-ico{width:50px;height:50px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;margin-bottom:1.1rem}
.c-mas .card-ico{background:rgba(184,134,11,.12)}.c-adm .card-ico{background:rgba(250,247,240,.08)}
.card-ld h3{font-family:'Playfair Display',serif;font-size:1.45rem;margin-bottom:.4rem}
.c-mas h3{color:var(--ink)}.c-adm h3{color:var(--cream)}
.card-ld>p{font-size:.83rem;line-height:1.65;margin-bottom:1.3rem}
.c-mas>p{color:var(--ink-m)}.c-adm>p{color:rgba(250,247,240,.45)}
.chk{list-style:none;display:flex;flex-direction:column;gap:.45rem;margin-bottom:1.8rem}
.chk li{font-size:.8rem;display:flex;align-items:center;gap:.5rem}
.c-mas .chk li{color:var(--ink-s)}.c-adm .chk li{color:rgba(250,247,240,.6)}
.chk li::before{content:'✓';font-size:.65rem;font-weight:700;width:17px;height:17px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;background:var(--gold-p);color:var(--gold);border:1px solid rgba(184,134,11,.25)}
.c-adm .chk li::before{background:rgba(250,247,240,.08);color:var(--gold-l)}
.cbtn{display:flex;align-items:center;justify-content:center;gap:.4rem;padding:.8rem 1.6rem;border-radius:100px;font-size:.88rem;font-weight:500;text-decoration:none;width:100%;transition:all var(--ease)}
.c-mas .cbtn{background:var(--ink);color:var(--cream)}.c-mas .cbtn:hover{background:var(--gold);color:var(--ink);text-decoration:none}
.c-adm .cbtn{background:var(--gold);color:var(--ink)}.c-adm .cbtn:hover{background:var(--gold-l);text-decoration:none;color:var(--ink)}
.reg-link{text-align:center;margin-top:1rem;font-size:.78rem;color:var(--ink-m)}
.reg-link a{color:var(--gold);font-weight:600;text-decoration:none}
.footer{background:var(--ink);padding:2.8rem 3rem 1.8rem}
.fi{max-width:1080px;margin:0 auto;display:flex;justify-content:space-between;align-items:flex-start;gap:2rem;flex-wrap:wrap}
.flogo{font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--cream);text-decoration:none;display:inline-flex;align-items:center;gap:6px}
.flogo img{width:28px;height:28px;object-fit:contain;border-radius:5px;opacity:.85}
.flogo span{color:var(--gold-l)}
.ftag{font-size:.75rem;color:rgba(250,247,240,.3);margin-top:.3rem}
.flinks{display:flex;flex-direction:column;gap:.4rem}
.flinks a{font-size:.8rem;color:rgba(250,247,240,.35);text-decoration:none;transition:color var(--ease)}
.flinks a:hover{color:var(--gold-l)}
.fbot{max-width:1080px;margin:2rem auto 0;padding-top:1.4rem;border-top:1px solid rgba(255,255,255,.06);display:flex;justify-content:space-between;font-size:.72rem;color:rgba(250,247,240,.2);flex-wrap:wrap;gap:.4rem}
@keyframes up{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:none}}
@media(max-width:768px){.ln{padding:0 1.25rem}.ln-links{display:none}.stat{padding:1.8rem 2rem}.inner{padding:4rem 1.25rem}.ftgrid{grid-template-columns:1fr}.mock{display:none}.cards{grid-template-columns:1fr}.footer{padding:2rem 1.25rem 1.5rem}}
</style>
</head>
<body>
@php $is_logged_in = session('status') === 'login'; @endphp

<nav class="ln">
  <a href="{{ route('home') }}" class="ln-logo">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Lux Bid">
    Lux<span>Bid</span>
  </a>
  <div style="display:flex;align-items:center;gap:.25rem">
    <ul class="ln-links">
      <li><a href="#ck">Cara Kerja</a></li>
      <li><a href="#lelang">Lelang Aktif</a></li>
      <li><a href="#ft">Fitur</a></li>
      @if($is_logged_in)
        <li><a href="{{ route('masyarakat.index') }}">👋 {{ session('username') }}</a></li>
        <li><a href="{{ route('logout') }}" class="ln-cta">Logout</a></li>
      @else
        <li><a href="{{ route('login.masyarakat') }}">Login</a></li>
        <li><a href="{{ route('daftar.masyarakat') }}" class="ln-cta">Daftar Gratis</a></li>
      @endif
    </ul>
    <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode"><i class="fas fa-moon"></i></button>
  </div>
</nav>

<section class="hero">
  <div class="badge">Platform Pelelangan Resmi &amp; Terpercaya</div>
  <h1 class="h1">Ikuti Lelang, Dapatkan Barang <em>Impianmu</em></h1>
  <p class="hsub">Pelelangan online yang transparan, aman, dan mudah diakses. Daftar gratis dan mulai menawar sekarang.</p>
  <div class="hbtns">
    <a href="{{ route('daftar.masyarakat') }}" class="btn-p">Daftar Sekarang &rarr;</a>
    <a href="#ck" class="btn-o">Pelajari Cara Kerja</a>
  </div>
</section>

<div class="stats">
  <div class="stat"><span class="stat-n">2.400+</span><div class="stat-l">Pengguna Terdaftar</div></div>
  <div class="stat"><span class="stat-n">890+</span><div class="stat-l">Lelang Selesai</div></div>
  <div class="stat"><span class="stat-n">99%</span><div class="stat-l">Transaksi Sukses</div></div>
  <div class="stat"><span class="stat-n">50+</span><div class="stat-l">Kategori Barang</div></div>
</div>

<section class="sec" id="ck">
  <div class="inner">
    <span class="lbl rv">Proses Mudah</span>
    <h2 class="ttl rv">Cara Kerja Lelang</h2>
    <p class="dsc rv">Hanya beberapa langkah untuk mulai mengikuti lelang dan mendapatkan barang incaran Anda.</p>
    <div class="steps">
      <div class="step rv"><div class="step-n">01</div><div class="step-i">📝</div><h4>Daftar Akun</h4><p>Buat akun gratis dengan data diri. Verifikasi dilakukan cepat oleh petugas kami.</p></div>
      <div class="step rv"><div class="step-n">02</div><div class="step-i">🔍</div><h4>Cari Barang Lelang</h4><p>Telusuri daftar barang yang sedang dilelang. Filter sesuai kategori dan harga.</p></div>
      <div class="step rv"><div class="step-n">03</div><div class="step-i">💰</div><h4>Ajukan Penawaran</h4><p>Masukkan nominal penawaran Anda. Pantau terus karena waktu lelang terbatas!</p></div>
      <div class="step rv"><div class="step-n">04</div><div class="step-i">🏆</div><h4>Menang &amp; Selesai</h4><p>Penawar tertinggi saat waktu habis menjadi pemenang dan proses selesai.</p></div>
    </div>
  </div>
</section>

<section class="sec" id="ft">
  <div class="inner">
    <span class="lbl rv">Mengapa Kami</span>
    <h2 class="ttl rv">Fitur Unggulan Platform</h2>
    <p class="dsc rv">Dirancang untuk pengalaman lelang yang transparan, aman, dan menyenangkan.</p>
    <div class="ftgrid">
      <div class="ftlist">
        <div class="fti rv"><div class="fti-ic">🔒</div><div><h5>Keamanan Terjamin</h5><p>Data &amp; transaksi Anda terlindungi. Semua pengguna terverifikasi oleh petugas resmi.</p></div></div>
        <div class="fti rv"><div class="fti-ic">⚡</div><div><h5>Penawaran Real-Time</h5><p>Lihat penawaran terbaru secara langsung dan jangan sampai kalah dari pesaing.</p></div></div>
        <div class="fti rv"><div class="fti-ic">📊</div><div><h5>Riwayat Transparan</h5><p>Semua histori penawaran dan transaksi tercatat dan dapat diakses kapan saja.</p></div></div>
        <div class="fti rv"><div class="fti-ic">📱</div><div><h5>Akses dari Mana Saja</h5><p>Platform responsif, nyaman digunakan dari HP, tablet, maupun komputer.</p></div></div>
      </div>
      <div class="mock rv">
        <div class="mock-bar">
          <div class="mock-dot" style="background:#FF6058"></div>
          <div class="mock-dot" style="background:#FFBC2E"></div>
          <div class="mock-dot" style="background:#29CB41"></div>
          <span class="mock-t">Lux Bid — Lelang Aktif</span>
        </div>
        @if($lelang_aktif->isEmpty())
          <div class="lot" style="text-align:center;padding:2rem 1rem;color:var(--ink-m)">
            <div style="font-size:2rem;margin-bottom:.5rem">📦</div>
            <div style="font-size:.85rem">Belum ada lelang aktif saat ini.</div>
          </div>
        @else
          @foreach($lelang_aktif->take(2) as $i => $l)
          @php $harga_tampil = $l->penawaran_tertinggi ?? $l->barang->harga_awal; @endphp
          <div class="lot" @if($i>0) style="opacity:.85" @endif>
            <div class="lot-cat">Lot #{{ str_pad($l->id_lelang,4,'0',STR_PAD_LEFT) }} · {{ \Carbon\Carbon::parse($l->tgl_lelang)->format('d M Y') }}</div>
            <div class="lot-name">{{ $l->barang->nama_barang }}</div>
            @if($l->barang->deskripsi_barang)
              <div style="font-size:.73rem;color:var(--ink-m);margin:.15rem 0">{{ Str::limit($l->barang->deskripsi_barang,55) }}</div>
            @endif
            <div style="font-size:.72rem;color:var(--ink-m)">{{ $l->jumlah_penawar }} penawar</div>
            <div class="lot-row">
              <div>
                <div style="font-size:.68rem;color:var(--ink-m)">{{ $l->penawaran_tertinggi ? 'Penawaran tertinggi' : 'Harga awal' }}</div>
                <div class="lot-price">Rp {{ number_format($harga_tampil,0,',','.') }}</div>
              </div>
              <div class="lot-timer">🟢 Aktif</div>
            </div>
            @if($i===0)
              @if($is_logged_in)
                <a href="{{ route('masyarakat.penawaran') }}" class="lot-btn">Ajukan Penawaran &rarr;</a>
              @else
                <a href="#masuk" class="lot-btn" onclick="highlightLogin(event)">Login untuk Menawar</a>
              @endif
            @endif
          </div>
          @endforeach
          @if($lelang_aktif->count() > 2)
            <div style="text-align:center;font-size:.75rem;color:var(--ink-m);margin-top:.5rem">+{{ $lelang_aktif->count()-2 }} lelang aktif lainnya</div>
          @endif
        @endif
      </div>
    </div>
  </div>
</section>

<section class="sec" id="lelang">
  <div class="inner">
    <span class="lbl rv">Live Sekarang</span>
    <h2 class="ttl rv">Lelang Aktif</h2>
    <p class="dsc rv">Barang-barang berikut sedang dalam proses lelang. Daftar atau login untuk mengajukan penawaran.</p>

    @if($lelang_aktif->isEmpty())
      <div class="rv" style="margin-top:2.5rem;text-align:center;padding:4rem 2rem;background:var(--white);border-radius:var(--r);border:1px solid var(--gold-ln)">
        <div style="font-size:3rem;margin-bottom:1rem">📦</div>
        <h3 style="font-family:'Playfair Display',serif;color:var(--ink);margin-bottom:.5rem">Belum Ada Lelang Aktif</h3>
        <p style="color:var(--ink-m);font-size:.9rem">Saat ini belum ada lelang yang sedang berjalan. Pantau terus untuk update terbaru.</p>
      </div>
    @else
      <div class="lalst rv">
        @foreach($lelang_aktif as $l)
        @php $harga_tampil = $l->penawaran_tertinggi ?? $l->barang->harga_awal; $ada_penawaran = !is_null($l->penawaran_tertinggi); @endphp
        <div class="lal-card">
          @if($l->foto)
            <img src="{{ asset('uploads/barang/'.$l->foto) }}" style="width:100%;height:160px;object-fit:cover;display:block" alt="{{ $l->barang->nama_barang }}">
          @else
            <div style="width:100%;height:160px;background:linear-gradient(135deg,var(--cream-d),var(--gold-p));display:flex;align-items:center;justify-content:center;font-size:3rem">📦</div>
          @endif
          <div style="padding:1.4rem;display:flex;flex-direction:column;gap:.75rem;flex:1">
            <div class="lal-top">
              <div class="lal-badge">🟢 Aktif</div>
              <div class="lal-lot">Lot #{{ str_pad($l->id_lelang,4,'0',STR_PAD_LEFT) }}</div>
            </div>
            <div class="lal-name">{{ $l->barang->nama_barang }}</div>
            @if($l->barang->deskripsi_barang)
              <p class="lal-desc">{{ Str::limit($l->barang->deskripsi_barang,80) }}</p>
            @endif
            <div class="lal-meta">
              <span><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($l->tgl_lelang)->format('d M Y') }}</span>
              <span><i class="fas fa-users"></i> {{ $l->jumlah_penawar }} penawar</span>
            </div>
            <div class="lal-price-wrap">
              <div>
                <div class="lal-price-lbl">{{ $ada_penawaran ? 'Penawaran tertinggi' : 'Harga awal' }}</div>
                <div class="lal-price">Rp {{ number_format($harga_tampil,0,',','.') }}</div>
              </div>
              @if($ada_penawaran)
                <div style="font-size:.72rem;color:var(--ink-m);text-align:right">Harga awal<br><span style="color:var(--ink-s);font-weight:500">Rp {{ number_format($l->barang->harga_awal,0,',','.') }}</span></div>
              @endif
            </div>
            @if($is_logged_in)
              <a href="{{ route('masyarakat.penawaran') }}" class="lal-btn"><i class="fas fa-gavel"></i> Ajukan Penawaran</a>
            @else
              <div class="lal-gate">
                <p><i class="fas fa-lock"></i> Harus login untuk menawar</p>
                <div class="lal-gate-btns">
                  <a href="{{ route('login.masyarakat') }}" class="lal-btn-login">Login</a>
                  <a href="{{ route('daftar.masyarakat') }}" class="lal-btn-daftar">Daftar Gratis</a>
                </div>
              </div>
            @endif
          </div>
        </div>
        @endforeach
      </div>
      @if(!$is_logged_in)
        <div class="rv" style="margin-top:2rem;text-align:center">
          <p style="color:var(--ink-m);font-size:.88rem;margin-bottom:1rem">Sudah punya akun? Langsung masuk dan ikuti lelang.</p>
          <a href="{{ route('login.masyarakat') }}" class="btn-p" style="display:inline-flex"><i class="fas fa-sign-in-alt"></i> Login Sekarang</a>
          <span style="margin:0 .75rem;color:var(--ink-m);font-size:.85rem">atau</span>
          <a href="{{ route('daftar.masyarakat') }}" class="btn-o" style="display:inline-flex">Daftar Akun Gratis</a>
        </div>
      @endif
    @endif
  </div>
</section>

<section class="sec" id="masuk">
  <div class="inner">
    <span class="lbl rv">Akses Platform</span>
    <h2 class="ttl rv">Login</h2>
    <p class="dsc rv">Pilih jenis akun sesuai peran Anda untuk mulai menggunakan platform pelelangan daring.</p>
    <div class="cards">
      <div class="card-ld c-mas rv">
        <div class="card-ico">👤</div>
        <h3>Masyarakat / Peserta</h3>
        <p>Ikuti lelang, ajukan penawaran, dan menangkan barang incaran Anda.</p>
        <ul class="chk">
          <li>Lihat semua lelang aktif</li><li>Ajukan penawaran kapan saja</li>
          <li>Pantau riwayat penawaran</li><li>Proses cepat &amp; mudah</li>
        </ul>
        <a href="{{ route('login.masyarakat') }}" class="cbtn">Masuk sebagai Peserta &rarr;</a>
        <div class="reg-link">Belum punya akun? <a href="{{ route('daftar.masyarakat') }}">Daftar di sini</a></div>
      </div>
      <div class="card-ld c-adm rv">
        <div class="card-ico">🛡️</div>
        <h3>Admin / Petugas</h3>
        <p>Kelola barang lelang, verifikasi peserta, dan pantau jalannya seluruh lelang dari panel khusus.</p>
        <ul class="chk">
          <li>Kelola data peserta</li><li>Tambah &amp; atur item lelang</li>
          <li>Pantau semua penawaran</li><li>Laporan &amp; statistik lelang</li>
        </ul>
        <a href="{{ route('login.petugas') }}" class="cbtn">Masuk sebagai Admin &rarr;</a>
      </div>
    </div>
  </div>
</section>

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
      <a href="{{ route('login.masyarakat') }}">Login Masyarakat</a>
      <a href="{{ route('daftar.masyarakat') }}">Daftar Akun</a>
      <a href="{{ route('login.petugas') }}">Admin Panel</a>
    </div>
  </div>
  <div class="fbot">
    <span>&copy; 2026 Lux Bid. Hak cipta dilindungi.</span>
    <span>Made by TEAM HUNTERS &middot; MIT License</span>
  </div>
</footer>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/theme.js') }}"></script>
<script>
const rvEls = document.querySelectorAll('.rv');
const obs = new IntersectionObserver((entries) => {
  entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('in'); obs.unobserve(e.target); } });
}, {threshold:.12});
rvEls.forEach(el => obs.observe(el));

function highlightLogin(e) {
  e.preventDefault();
  document.querySelector('#masuk').scrollIntoView({behavior:'smooth'});
  setTimeout(() => {
    document.querySelectorAll('.card-ld.c-mas').forEach(c => {
      c.style.borderColor='var(--gold)';c.style.boxShadow='0 0 0 4px rgba(184,134,11,.25)';
      setTimeout(()=>{c.style.borderColor='';c.style.boxShadow='';},2000);
    });
  }, 600);
}
</script>
</body>
</html>
