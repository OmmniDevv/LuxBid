<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Daftar Akun — Lux Bid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--gold:#B8860B;--gold-l:#D4A017;--gold-p:#FDF8EE;--gold-ln:rgba(184,134,11,.2);--ink:#1C1A15;--ink-s:#3A3527;--ink-m:#7A7260;--ink-l:#B5AFA3;--cream:#FAF7F0;--cream-d:#EDE8DC;--cream-dd:#DDD7CC;--white:#FFFFFF;--r:14px;--rs:9px;--ease:.22s cubic-bezier(.4,0,.2,1);}
    body{font-family:'DM Sans',sans-serif;min-height:100vh;background:var(--cream);color:var(--ink);display:flex;align-items:flex-start;justify-content:center;padding:3rem 1rem}
    .reg-wrap{width:100%;max-width:860px;display:grid;grid-template-columns:1fr 380px;gap:2.5rem;align-items:start}
    .reg-header{margin-bottom:2rem}
    .reg-back{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--ink-m);text-decoration:none;margin-bottom:1.5rem;transition:color .22s}
    .reg-back:hover{color:var(--gold)}
    .reg-icon{width:52px;height:52px;border-radius:13px;background:var(--gold-p);border:2px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1rem}
    .reg-title{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--ink);margin-bottom:.3rem;letter-spacing:-.025em}
    .reg-sub{font-size:.85rem;color:var(--ink-m);line-height:1.6}
    .reg-card{background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:2rem;box-shadow:0 4px 18px rgba(28,26,21,.06)}
    .form-group-m{margin-bottom:1.15rem}
    .form-label-m{display:block;font-size:.78rem;font-weight:600;color:var(--ink-s);margin-bottom:.4rem;letter-spacing:.01em}
    .input-wrap{position:relative}
    .form-control-m{width:100%;padding:.72rem 1rem .72rem 2.8rem;font-family:'DM Sans',sans-serif;font-size:.92rem;color:var(--ink);background:var(--cream);border:1.5px solid var(--cream-dd);border-radius:9px;transition:border-color .22s,box-shadow .22s,background .22s;outline:none}
    .form-control-m::placeholder{color:var(--ink-l)}
    .form-control-m:focus{border-color:var(--gold);background:var(--white);box-shadow:0 0 0 3px rgba(184,134,11,.1)}
    .input-icon{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--ink-l);font-size:.85rem;pointer-events:none;transition:color .22s}
    .input-wrap:focus-within .input-icon{color:var(--gold)}
    .eye-toggle{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--ink-l);font-size:.85rem;padding:0}
    .eye-toggle:hover{color:var(--ink)}
    .form-hint{font-size:.73rem;color:var(--ink-l);margin-top:.3rem}
    .btn-reg{width:100%;padding:.85rem;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:600;background:var(--ink);color:var(--cream);border:none;border-radius:100px;cursor:pointer;transition:all .22s;display:flex;align-items:center;justify-content:center;gap:.5rem;box-shadow:0 4px 14px rgba(28,26,21,.14);margin-top:.25rem}
    .btn-reg:hover{background:var(--gold);color:var(--ink);transform:translateY(-1px)}
    .reg-login{text-align:center;margin-top:1.1rem;font-size:.8rem;color:var(--ink-m)}
    .reg-login a{color:var(--gold);font-weight:600;text-decoration:none}
    .reg-login a:hover{text-decoration:underline}
    .reg-side{display:flex;flex-direction:column;gap:1rem;position:sticky;top:3rem}
    .side-card{background:var(--ink);border-radius:var(--r);padding:1.75rem;overflow:hidden;position:relative}
    .side-card::before{content:'';position:absolute;width:180px;height:180px;border-radius:50%;background:radial-gradient(circle,rgba(184,134,11,.1) 0%,transparent 70%);bottom:-40px;right:-40px}
    .side-card h3{font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--cream);margin-bottom:.4rem;position:relative;z-index:1}
    .side-card p{font-size:.8rem;color:rgba(250,247,240,.38);line-height:1.65;position:relative;z-index:1}
    .side-steps{display:flex;flex-direction:column;gap:.65rem;margin-top:1.1rem;position:relative;z-index:1}
    .side-step{display:flex;align-items:center;gap:.65rem;font-size:.82rem;color:rgba(250,247,240,.5)}
    .side-step-n{width:22px;height:22px;border-radius:50%;background:rgba(184,134,11,.2);border:1px solid rgba(184,134,11,.3);display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:700;color:var(--gold-l);flex-shrink:0}
    .side-info{background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--r);padding:1.25rem}
    .side-info h4{font-size:.85rem;font-weight:600;color:var(--ink-s);margin-bottom:.4rem}
    .side-info ul{list-style:none;display:flex;flex-direction:column;gap:.35rem}
    .side-info li{font-size:.78rem;color:var(--ink-m);display:flex;align-items:center;gap:.45rem}
    .side-info li::before{content:'✓';font-size:.7rem;background:rgba(184,134,11,.15);color:var(--gold);width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
    .reg-wrap>*{animation:fadeUp .4s ease both}
    .reg-wrap>*:nth-child(2){animation-delay:.1s}
    @media(max-width:768px){.reg-wrap{grid-template-columns:1fr}.reg-side{display:none}}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <div class="reg-wrap">
    <div class="reg-form-side">
      <div class="reg-header">
        <a href="{{ route('home') }}" class="reg-back"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        <div class="reg-icon">📝</div>
        <h1 class="reg-title">Buat Akun Baru</h1>
        <p class="reg-sub">Daftar gratis dan mulai ikuti lelang dalam hitungan menit.</p>
      </div>
      @if(request('info') === 'telp_invalid')
        <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:9px;padding:.85rem 1rem;margin-bottom:1rem;font-size:.85rem;color:#856404;">
          <i class="fas fa-exclamation-triangle"></i> Nomor telepon tidak valid. Gunakan format 08xx atau +62xx (8–12 digit).
        </div>
      @elseif(request('info') === 'username_exists')
        <div style="background:#f8d7da;border:1px solid #f5c2c7;border-radius:9px;padding:.85rem 1rem;margin-bottom:1rem;font-size:.85rem;color:#842029;">
          <i class="fas fa-times-circle"></i> Username sudah digunakan. Silakan pilih username lain.
        </div>
      @endif
      <div class="reg-card">
        <form action="{{ route('daftar.masyarakat.post') }}" method="post">
          @csrf
          <div class="form-group-m">
            <label class="form-label-m">Nama Lengkap</label>
            <div class="input-wrap">
              <i class="fas fa-id-card input-icon"></i>
              <input type="text" name="nama_lengkap" class="form-control-m" placeholder="Nama lengkap sesuai KTP" required>
            </div>
          </div>
          <div class="form-group-m">
            <label class="form-label-m">Username</label>
            <div class="input-wrap">
              <i class="fas fa-at input-icon"></i>
              <input type="text" name="username" class="form-control-m" placeholder="Pilih username unik" autocomplete="username" required>
            </div>
            <div class="form-hint">Username digunakan untuk login. Tidak bisa diubah setelah didaftar.</div>
          </div>
          <div class="form-group-m">
            <label class="form-label-m">Password</label>
            <div class="input-wrap">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" name="password" class="form-control-m" placeholder="Buat password yang kuat" autocomplete="new-password" id="reg-pwd" required>
              <button type="button" class="eye-toggle" onclick="togglePwd('reg-pwd',this)"><i class="fas fa-eye"></i></button>
            </div>
            <div class="form-hint">Minimal 6 karakter, kombinasi huruf dan angka.</div>
          </div>
          <div class="form-group-m">
            <label class="form-label-m">Nomor Telepon</label>
            <div class="input-wrap">
              <i class="fas fa-phone input-icon"></i>
              <input type="tel" name="telp" class="form-control-m" placeholder="08xx atau +62xx" pattern="^(?:\+62|08)[1-9][0-9]{7,11}$" required>
            </div>
            <div class="form-hint">Format: 08xx-xxxx-xxxx atau +62xxx-xxxx-xxxx</div>
          </div>
          <div class="form-group-m">
            <label class="form-label-m">Email <span style="font-weight:400;color:var(--ink-l)">(opsional)</span></label>
            <div class="input-wrap">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email" name="email" class="form-control-m" placeholder="contoh@email.com">
            </div>
          </div>
          <button type="submit" class="btn-reg"><i class="fas fa-user-plus"></i> Daftar Sekarang — Gratis</button>
        </form>
        <div class="reg-login">Sudah punya akun? <a href="{{ route('login.masyarakat') }}">Masuk di sini →</a></div>
      </div>
    </div>
    <div class="reg-side">
      <div class="side-card">
        <h3>Cara Bergabung</h3>
        <p>Proses pendaftaran mudah dan cepat</p>
        <div class="side-steps">
          <div class="side-step"><div class="side-step-n">1</div>Isi formulir pendaftaran dengan data valid</div>
          <div class="side-step"><div class="side-step-n">2</div>Tunggu verifikasi dari petugas kami</div>
          <div class="side-step"><div class="side-step-n">3</div>Login dan mulai ikuti lelang aktif</div>
          <div class="side-step"><div class="side-step-n">4</div>Menangkan lelang dan raih barang impian</div>
        </div>
      </div>
      <div class="side-info">
        <h4>Keuntungan Bergabung</h4>
        <ul>
          <li>Akses semua lelang aktif gratis</li>
          <li>Ajukan penawaran kapan saja</li>
          <li>Riwayat transaksi lengkap & aman</li>
          <li>Notifikasi status lelang real-time</li>
          <li>Dukungan petugas profesional</li>
        </ul>
      </div>
    </div>
  </div>
  <script>
    function togglePwd(id, btn) {
      const input = document.getElementById(id);
      const icon = btn.querySelector('i');
      if (input.type === 'password') { input.type = 'text'; icon.className = 'fas fa-eye-slash'; }
      else { input.type = 'password'; icon.className = 'fas fa-eye'; }
    }
  </script>

<script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
