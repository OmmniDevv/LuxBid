<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Panel Admin — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    body{display:flex;min-height:100vh;background:var(--bg);margin:0;padding:0}

    /* Dark brand panel — LEFT */
    .auth-left{
      flex:0 0 420px;position:relative;overflow:hidden;
      background:var(--ink);
      display:flex;flex-direction:column;justify-content:space-between;
      padding:3rem 2.75rem 2.5rem;
    }
    [data-theme="dark"] .auth-left{background:#0A0806}

    .auth-left::before{
      content:'';position:absolute;
      width:480px;height:480px;border-radius:50%;
      border:1px solid rgba(202,138,4,.10);
      top:-140px;right:-160px;pointer-events:none;
    }
    .auth-left::after{
      content:'';position:absolute;
      width:260px;height:260px;border-radius:50%;
      background:radial-gradient(circle,rgba(202,138,4,.07) 0%,transparent 70%);
      bottom:-60px;left:-60px;pointer-events:none;
    }

    .al-brand{
      font-family:var(--font-serif);font-size:1.45rem;font-weight:700;
      color:#FAF9F8;text-decoration:none;position:relative;z-index:1;
    }
    .al-brand span{color:var(--gold)}

    .al-body{position:relative;z-index:1}
    .al-body h2{
      font-family:var(--font-serif);font-size:2rem;font-weight:700;
      color:#FAF9F8;line-height:1.12;margin-bottom:.8rem;
    }
    .al-body h2 em{font-style:italic;color:var(--gold-l)}
    .al-body p{font-size:.84rem;color:rgba(250,249,248,.38);line-height:1.75}

    .al-features{
      display:flex;flex-direction:column;gap:.65rem;
      margin-top:1.75rem;position:relative;z-index:1;
    }
    .al-feat{
      display:flex;align-items:center;gap:.7rem;
      font-size:.82rem;color:rgba(250,249,248,.5);
    }
    .al-feat-dot{
      width:6px;height:6px;border-radius:50%;
      background:var(--gold);flex-shrink:0;
    }

    .al-copy{font-size:.68rem;color:rgba(250,249,248,.18);position:relative;z-index:1}

    /* Form panel — RIGHT */
    .auth-right{
      flex:1;display:flex;align-items:center;justify-content:center;
      padding:2.5rem 1.5rem;overflow-y:auto;
    }
    .auth-box{width:100%;max-width:380px}

    .auth-header{margin-bottom:2rem;text-align:center}
    .auth-icon{
      width:54px;height:54px;border-radius:14px;
      background:var(--accent-p);border:2px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:1.4rem;margin:0 auto 1rem;color:var(--accent);
    }
    .auth-title{
      font-family:var(--font-serif);font-size:1.75rem;font-weight:700;
      color:var(--text);margin-bottom:.3rem;letter-spacing:-.02em;
    }
    .auth-sub{font-size:.84rem;color:var(--text-2)}

    .alert-m{
      display:flex;align-items:flex-start;gap:.65rem;
      padding:.9rem 1.1rem;border-radius:var(--rss);
      font-size:.83rem;margin-bottom:1.25rem;border-left:3px solid;
    }
    .alert-warn-m{background:var(--warn-bg);color:var(--warn);border-color:var(--warn)}
    .alert-success-m{background:var(--success-bg);color:var(--success);border-color:var(--success)}
    .alert-info-m{background:var(--info-bg);color:var(--info);border-color:var(--info)}

    .form-group-m{margin-bottom:1.1rem}
    .form-label-m{
      display:block;font-size:.73rem;font-weight:600;
      color:var(--text-2);margin-bottom:.4rem;
      letter-spacing:.02em;text-transform:uppercase;
    }
    .input-wrap{position:relative}
    .form-control-m{
      width:100%;padding:.78rem 1rem .78rem 2.9rem;
      font-family:var(--font-sans);font-size:.88rem;
      color:var(--text);background:var(--surface-2);
      border:1.5px solid var(--border-2);border-radius:var(--rs);
      transition:border-color .25s,box-shadow .25s,background .25s;outline:none;
    }
    .form-control-m::placeholder{color:var(--text-3)}
    .form-control-m:focus{
      border-color:var(--accent);background:var(--surface);
      box-shadow:0 0 0 3px var(--gold-glow);
    }
    .input-icon{
      position:absolute;left:.9rem;top:50%;transform:translateY(-50%);
      color:var(--text-2);font-size:.85rem;pointer-events:none;transition:color .2s;
    }
    .input-wrap:focus-within .input-icon{color:var(--accent)}
    .eye-toggle{
      position:absolute;right:.85rem;top:50%;transform:translateY(-50%);
      background:none;border:none;cursor:pointer;
      color:var(--text-2);font-size:.9rem;padding:0;
      transition:color .2s;line-height:1;
    }
    .eye-toggle:hover{color:var(--accent)}

    .btn-auth{
      width:100%;padding:.85rem;
      font-family:var(--font-sans);font-size:.9rem;font-weight:600;
      background:var(--ink);color:var(--cream);
      border:none;border-radius:100px;cursor:pointer;
      transition:background .25s,transform .25s,box-shadow .25s;
      box-shadow:0 4px 16px rgba(28,25,23,.18);
      display:flex;align-items:center;justify-content:center;gap:.5rem;
      margin-top:.5rem;
    }
    .btn-auth:hover{
      background:var(--accent);color:var(--ink);
      transform:translateY(-2px);box-shadow:0 6px 22px rgba(202,138,4,.28);
    }
    [data-theme="dark"] .btn-auth{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .btn-auth:hover{background:var(--accent-l);transform:translateY(-2px)}

    .sep{
      display:flex;align-items:center;gap:.75rem;
      margin:1.3rem 0;color:var(--text-3);font-size:.73rem;
    }
    .sep::before,.sep::after{content:'';flex:1;height:1px;background:var(--border-2)}

    .auth-back{text-align:center;font-size:.8rem;color:var(--text-2)}
    .auth-back a{color:var(--accent);font-weight:600;text-decoration:none}
    .auth-back a:hover{text-decoration:underline}

    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
    .auth-box>*{animation:fadeUp .4s ease both}
    .auth-box>*:nth-child(2){animation-delay:.06s}
    .auth-box>*:nth-child(3){animation-delay:.12s}

    @media(max-width:768px){.auth-left{display:none}}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>

  <div class="auth-left">
    <a href="{{ route('home') }}" class="al-brand">Lux<span>Bid</span></a>
    <div class="al-body">
      <h2>Panel <em>Admin</em> &<br>Petugas Lelang</h2>
      <p>Kelola seluruh aktivitas lelang dari satu dashboard yang aman, terorganisir, dan efisien.</p>
      <div class="al-features">
        <div class="al-feat"><div class="al-feat-dot"></div>Kelola data barang & sesi lelang</div>
        <div class="al-feat"><div class="al-feat-dot"></div>Aktivasi & pantau lelang secara real-time</div>
        <div class="al-feat"><div class="al-feat-dot"></div>Verifikasi dan manajemen peserta</div>
        <div class="al-feat"><div class="al-feat-dot"></div>Laporan lengkap & ekspor PDF</div>
      </div>
    </div>
    <div class="al-copy">&copy; {{ date('Y') }} LuxBid &middot; Akses Terbatas</div>
  </div>

  <div class="auth-right">
    <div class="auth-box">
      <div class="auth-header">
        <div class="auth-icon"><i class="fas fa-shield-alt"></i></div>
        <h1 class="auth-title">Masuk ke Panel</h1>
        <p class="auth-sub">Gunakan kredensial resmi untuk mengakses dashboard.</p>
      </div>

      @if(request('info') === 'gagal')
        <div class="alert-m alert-warn-m">
          <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Username atau password salah. Silakan periksa kembali.</span>
        </div>
      @elseif(request('info') === 'logout')
        <div class="alert-m alert-success-m">
          <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Anda berhasil logout. Sampai jumpa!</span>
        </div>
      @elseif(request('info') === 'login')
        <div class="alert-m alert-info-m">
          <i class="fas fa-info-circle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Silakan login terlebih dahulu untuk mengakses halaman ini.</span>
        </div>
      @endif

      <form action="{{ route('login.petugas.post') }}" method="post">
        @csrf
        <div class="form-group-m">
          <label class="form-label-m" for="admin-username">Username</label>
          <div class="input-wrap">
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="admin-username" name="username" class="form-control-m"
              placeholder="Masukkan username" autocomplete="username" required>
          </div>
        </div>

        <div class="form-group-m">
          <label class="form-label-m" for="pwd-admin">Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="pwd-admin" name="password" class="form-control-m"
              placeholder="Masukkan password" autocomplete="current-password" required>
            <button type="button" class="eye-toggle" onclick="togglePwd('pwd-admin',this)" aria-label="Tampilkan password">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-auth">
          <i class="fas fa-sign-in-alt"></i> Masuk ke Panel Admin
        </button>
      </form>

      <div class="sep">atau</div>
      <div class="auth-back"><a href="{{ route('home') }}">← Kembali ke Beranda</a></div>
    </div>
  </div>

  <script>
    function togglePwd(id, btn) {
      const input = document.getElementById(id);
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text'; icon.className = 'fas fa-eye-slash';
      } else {
        input.type = 'password'; icon.className = 'fas fa-eye';
      }
    }
  </script>
  <script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
