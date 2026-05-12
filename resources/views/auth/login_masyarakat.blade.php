<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Login Peserta — Lux Bid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--gold:#B8860B;--gold-l:#D4A017;--gold-p:#FDF8EE;--gold-ln:rgba(184,134,11,.2);--ink:#1C1A15;--ink-s:#3A3527;--ink-m:#7A7260;--ink-l:#B5AFA3;--cream:#FAF7F0;--cream-d:#EDE8DC;--cream-dd:#DDD7CC;--white:#FFFFFF;--r:14px;--rs:9px;--ease:.22s cubic-bezier(.4,0,.2,1);--success:#1D6A47;--success-bg:#EDFAF3;--warn-bg:#FFF4E5;--warn:#A85B00;--danger:#C0392B;--info:#1E5A8A;--info-bg:#EEF5FC;}
    body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;background:var(--cream);color:var(--ink)}
    .split-left{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;overflow-y:auto}
    .split-right{flex:0 0 420px;background:linear-gradient(160deg,#2A2418,var(--ink));display:flex;flex-direction:column;justify-content:space-between;padding:3rem 2.5rem;position:relative;overflow:hidden}
    .split-right::before{content:'';position:absolute;width:440px;height:440px;border-radius:50%;background:radial-gradient(circle,rgba(184,134,11,.14) 0%,transparent 65%);bottom:-100px;right:-100px}
    .split-right::after{content:'';position:absolute;width:200px;height:200px;border-radius:50%;border:1px solid rgba(184,134,11,.15);top:60px;left:-60px}
    .right-brand{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--cream);text-decoration:none;position:relative;z-index:1}
    .right-brand span{color:var(--gold-l)}
    .right-content{position:relative;z-index:1}
    .right-content h2{font-family:'Playfair Display',serif;font-size:1.85rem;font-weight:700;color:var(--cream);line-height:1.15;margin-bottom:.75rem}
    .right-content h2 em{font-style:italic;color:var(--gold-l)}
    .right-content p{font-size:.86rem;color:rgba(250,247,240,.38);line-height:1.7}
    .right-stats{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-top:1.75rem;position:relative;z-index:1}
    .right-stat{background:rgba(255,255,255,.04);border:1px solid rgba(184,134,11,.12);border-radius:10px;padding:.85rem}
    .right-stat-n{font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--gold-l);display:block;line-height:1}
    .right-stat-l{font-size:.68rem;color:rgba(250,247,240,.3);margin-top:.2rem;text-transform:uppercase;letter-spacing:.06em}
    .right-copy{font-size:.7rem;color:rgba(250,247,240,.18);position:relative;z-index:1}
    .auth-box{width:100%;max-width:400px}
    .auth-header{margin-bottom:2rem}
    .auth-icon{width:50px;height:50px;border-radius:12px;background:var(--gold-p);border:2px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1rem}
    .auth-title{font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:700;color:var(--ink);margin-bottom:.3rem}
    .auth-sub{font-size:.85rem;color:var(--ink-m)}
    .alert-m{display:flex;align-items:flex-start;gap:.65rem;padding:.9rem 1.1rem;border-radius:9px;font-size:.84rem;margin-bottom:1.25rem;border-left:3px solid;animation:fadeUp .3s ease both}
    .alert-warn-m{background:var(--warn-bg);color:var(--warn);border-color:var(--warn)}
    .alert-success-m{background:var(--success-bg);color:var(--success);border-color:var(--success)}
    .alert-info-m{background:var(--info-bg);color:var(--info);border-color:var(--info)}
    .form-group-m{margin-bottom:1.1rem}
    .form-label-m{display:block;font-size:.78rem;font-weight:600;color:var(--ink-s);margin-bottom:.4rem}
    .input-wrap{position:relative}
    .form-control-m{width:100%;padding:.72rem 1rem .72rem 2.8rem;font-family:'DM Sans',sans-serif;font-size:.92rem;color:var(--ink);background:var(--cream);border:1.5px solid var(--cream-dd);border-radius:9px;transition:border-color .22s,box-shadow .22s,background .22s;outline:none}
    .form-control-m::placeholder{color:var(--ink-l)}
    .form-control-m:focus{border-color:var(--gold);background:var(--white);box-shadow:0 0 0 3px rgba(184,134,11,.1)}
    .input-icon{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--ink-l);font-size:.85rem;pointer-events:none;transition:color .22s}
    .input-wrap:focus-within .input-icon{color:var(--gold)}
    .eye-toggle{position:absolute;right:.9rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--ink-l);font-size:.85rem;padding:0}
    .eye-toggle:hover{color:var(--ink)}
    .btn-auth{width:100%;padding:.82rem;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:600;background:var(--ink);color:var(--cream);border:none;border-radius:100px;cursor:pointer;transition:background .22s,transform .22s,box-shadow .22s;box-shadow:0 4px 14px rgba(28,26,21,.16);display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.5rem}
    .btn-auth:hover{background:var(--gold);color:var(--ink);transform:translateY(-1px)}
    .btn-auth-sec{width:100%;padding:.75rem;font-family:'DM Sans',sans-serif;font-size:.88rem;font-weight:500;background:transparent;color:var(--ink);border:1.5px solid var(--cream-dd);border-radius:100px;cursor:pointer;transition:all .22s;display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.65rem;text-decoration:none}
    .btn-auth-sec:hover{background:var(--cream-d);color:var(--ink);text-decoration:none}
    .sep{display:flex;align-items:center;gap:.75rem;margin:1.25rem 0;color:var(--ink-l);font-size:.75rem}
    .sep::before,.sep::after{content:'';flex:1;height:1px;background:var(--cream-dd)}
    .auth-links{display:flex;justify-content:space-between;margin-top:1.2rem;flex-wrap:wrap;gap:.5rem}
    .auth-links a{font-size:.78rem;color:var(--gold);font-weight:600;text-decoration:none}
    .auth-links a:hover{text-decoration:underline}
    @keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
    .auth-box>*{animation:fadeUp .4s ease both}
    @media(max-width:768px){.split-right{display:none}}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <div class="split-left">
    <div class="auth-box">
      <div class="auth-header">
        <div class="auth-icon"><i class="bi bi-person-circle"></i></div>
        <h1 class="auth-title">Selamat Datang!</h1>
        <p class="auth-sub">Masuk ke akun peserta untuk mulai mengikuti lelang</p>
      </div>
      @if(request('info') === 'gagal')
        <div class="alert-m alert-warn-m"><i class="fas fa-exclamation-triangle"></i><span>Login gagal! Username atau password tidak sesuai.</span></div>
      @elseif(request('info') === 'logout')
        <div class="alert-m alert-success-m"><i class="fas fa-check-circle"></i><span>Anda telah berhasil logout. Sampai jumpa kembali!</span></div>
      @elseif(request('info') === 'login')
        <div class="alert-m alert-info-m"><i class="fas fa-info-circle"></i><span>Anda perlu login untuk mengakses halaman tersebut.</span></div>
      @elseif(request('info') === 'daftar')
        <div class="alert-m alert-success-m"><i class="fas fa-check-circle"></i><span>Pendaftaran berhasil! Silakan login.</span></div>
      @endif
      <form action="{{ route('login.masyarakat.post') }}" method="post">
        @csrf
        <div class="form-group-m">
          <label class="form-label-m">Username</label>
          <div class="input-wrap">
            <i class="fas fa-user input-icon"></i>
            <input type="text" name="username" class="form-control-m" placeholder="Masukkan username Anda" autocomplete="username" required>
          </div>
        </div>
        <div class="form-group-m">
          <label class="form-label-m">Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control-m" placeholder="Masukkan password Anda" autocomplete="current-password" required id="pwd-mas">
            <button type="button" class="eye-toggle" onclick="togglePwd('pwd-mas',this)"><i class="fas fa-eye"></i></button>
          </div>
          <div style="text-align:right;margin-top:.4rem">
            <a href="{{ route('lupa.password') }}" style="font-size:.75rem;color:var(--gold);font-weight:600;text-decoration:none"><i class="fas fa-key" style="font-size:.65rem"></i> Lupa Password?</a>
          </div>
        </div>
        <button type="submit" class="btn-auth"><i class="fas fa-gavel"></i> Masuk & Mulai Lelang</button>
      </form>
      <div class="sep">Belum punya akun?</div>
      <a href="{{ route('daftar.masyarakat') }}" class="btn-auth-sec"><i class="fas fa-user-plus"></i> Daftar Akun Baru — Gratis</a>
      <div class="auth-links">
        <a href="{{ route('home') }}">← Beranda</a>
      </div>
    </div>
  </div>
  <div class="split-right">
    <a href="{{ route('home') }}" class="right-brand">Lux<span>Bid</span></a>
    <div class="right-content">
      <h2>Ikuti Lelang, Raih Barang <em>Impian</em></h2>
      <p>Platform pelelangan daring yang transparan, aman, dan terpercaya.</p>
      <div class="right-stats">
        <div class="right-stat"><span class="right-stat-n">2.4K+</span><div class="right-stat-l">Peserta Aktif</div></div>
        <div class="right-stat"><span class="right-stat-n">890+</span><div class="right-stat-l">Lelang Selesai</div></div>
        <div class="right-stat"><span class="right-stat-n">50+</span><div class="right-stat-l">Kategori Barang</div></div>
        <div class="right-stat"><span class="right-stat-n">99%</span><div class="right-stat-l">Transaksi Sukses</div></div>
      </div>
    </div>
    <div class="right-copy">&copy; {{ date('Y') }} Lux Bid</div>
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
