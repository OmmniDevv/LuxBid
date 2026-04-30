<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin — Lux Bid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--gold:#B8860B;--gold-l:#D4A017;--gold-p:#FDF8EE;--gold-ln:rgba(184,134,11,.2);--ink:#1C1A15;--ink-s:#3A3527;--ink-m:#7A7260;--ink-l:#B5AFA3;--cream:#FAF7F0;--cream-d:#EDE8DC;--cream-dd:#DDD7CC;--white:#FFFFFF;--r:14px;--rs:9px;--ease:.22s cubic-bezier(.4,0,.2,1);--danger:#C0392B;--success:#1D6A47;--warn:#A85B00;--info:#1E5A8A;--success-bg:#EDFAF3;--danger-bg:#FEF0EE;--warn-bg:#FFF4E5;--info-bg:#EEF5FC;}
    body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;background:var(--cream);color:var(--ink)}
    .split-left{flex:0 0 420px;background:var(--ink);display:flex;flex-direction:column;justify-content:space-between;padding:3rem 2.5rem;position:relative;overflow:hidden}
    .split-left::before{content:'';position:absolute;width:480px;height:480px;border-radius:50%;border:1px solid rgba(184,134,11,.12);top:-120px;right:-160px}
    .split-left::after{content:'';position:absolute;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(184,134,11,.06) 0%,transparent 70%);bottom:-60px;left:-60px}
    .left-brand{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--cream);text-decoration:none;position:relative;z-index:1}
    .left-brand span{color:var(--gold-l)}
    .left-content{position:relative;z-index:1}
    .left-content h2{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--cream);line-height:1.1;margin-bottom:.75rem}
    .left-content h2 em{font-style:italic;color:var(--gold-l)}
    .left-content p{font-size:.88rem;color:rgba(250,247,240,.4);line-height:1.7}
    .left-features{display:flex;flex-direction:column;gap:.6rem;margin-top:1.6rem;position:relative;z-index:1}
    .left-feat{display:flex;align-items:center;gap:.65rem;font-size:.82rem;color:rgba(250,247,240,.55)}
    .left-feat::before{content:'';width:6px;height:6px;border-radius:50%;background:var(--gold);flex-shrink:0}
    .left-copy{font-size:.7rem;color:rgba(250,247,240,.2);position:relative;z-index:1}
    .split-right{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;overflow-y:auto}
    .auth-box{width:100%;max-width:400px}
    .auth-header{margin-bottom:2rem;text-align:center}
    .auth-icon{width:54px;height:54px;border-radius:14px;background:var(--gold-p);border:2px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin:0 auto 1rem}
    .auth-title{font-family:'Playfair Display',serif;font-size:1.7rem;font-weight:700;color:var(--ink);margin-bottom:.3rem}
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
    .btn-auth:hover{background:var(--gold);color:var(--ink);transform:translateY(-1px);box-shadow:0 6px 20px rgba(184,134,11,.25)}
    .sep{display:flex;align-items:center;gap:.75rem;margin:1.4rem 0;color:var(--ink-l);font-size:.75rem}
    .sep::before,.sep::after{content:'';flex:1;height:1px;background:var(--cream-dd)}
    .auth-back{text-align:center;font-size:.8rem;color:var(--ink-m)}
    .auth-back a{color:var(--gold);font-weight:600;text-decoration:none}
    .auth-back a:hover{text-decoration:underline}
    @keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
    .auth-box>*{animation:fadeUp .4s ease both}
    @media(max-width:768px){.split-left{display:none}}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <div class="split-left">
    <a href="{{ route('home') }}" class="left-brand">Lux<span>Bid</span></a>
    <div class="left-content">
      <h2>Panel <em>Khusus</em> Admin & Petugas</h2>
      <p>Kelola seluruh aktivitas lelang dari satu tempat yang aman dan terpercaya.</p>
      <div class="left-features">
        <div class="left-feat">Kelola data barang & peserta lelang</div>
        <div class="left-feat">Aktivasi & pantau sesi lelang aktif</div>
        <div class="left-feat">Verifikasi akun masyarakat baru</div>
        <div class="left-feat">Laporan & statistik lelang lengkap</div>
      </div>
    </div>
    <div class="left-copy">&copy; {{ date('Y') }} Lux Bid &middot; Akses Terbatas</div>
  </div>
  <div class="split-right">
    <div class="auth-box">
      <div class="auth-header">
        <div class="auth-icon">🛡️</div>
        <h1 class="auth-title">Masuk sebagai Admin</h1>
        <p class="auth-sub">Gunakan kredensial resmi untuk mengakses panel</p>
      </div>
      @if(request('info') === 'gagal')
        <div class="alert-m alert-warn-m"><i class="fas fa-exclamation-triangle"></i><span>Login gagal! Username atau password salah.</span></div>
      @elseif(request('info') === 'logout')
        <div class="alert-m alert-success-m"><i class="fas fa-check-circle"></i><span>Anda telah berhasil logout. Sampai jumpa!</span></div>
      @elseif(request('info') === 'login')
        <div class="alert-m alert-info-m"><i class="fas fa-info-circle"></i><span>Silakan login terlebih dahulu untuk mengakses halaman ini.</span></div>
      @endif
      <form action="{{ route('login.petugas.post') }}" method="post">
        @csrf
        <div class="form-group-m">
          <label class="form-label-m">Username</label>
          <div class="input-wrap">
            <i class="fas fa-user input-icon"></i>
            <input type="text" name="username" class="form-control-m" placeholder="Masukkan username" autocomplete="username" required>
          </div>
        </div>
        <div class="form-group-m">
          <label class="form-label-m">Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control-m" placeholder="Masukkan password" autocomplete="current-password" required id="pwd-admin">
            <button type="button" class="eye-toggle" onclick="togglePwd('pwd-admin',this)"><i class="fas fa-eye"></i></button>
          </div>
        </div>
        <button type="submit" class="btn-auth"><i class="fas fa-sign-in-alt"></i> Masuk ke Panel Admin</button>
      </form>
      <div class="sep">atau</div>
      <div class="auth-back"><a href="{{ route('home') }}">← Kembali ke Beranda</a></div>
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
