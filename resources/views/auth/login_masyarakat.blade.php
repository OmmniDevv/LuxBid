<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Masuk — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    body{display:flex;min-height:100vh;background:var(--bg);overflow-x:hidden;margin:0;padding:0}

    /* ── Left panel (form) ── */
    .auth-left{
      flex:1;display:flex;align-items:center;justify-content:center;
      padding:2.5rem 1.5rem;overflow-y:auto;
    }
    .auth-box{width:100%;max-width:400px}

    /* ── Right panel (brand) ── */
    .auth-right{
      flex:0 0 440px;position:relative;overflow:hidden;
      background:var(--ink);
      display:flex;flex-direction:column;justify-content:space-between;
      padding:3rem 3rem 2.5rem;
    }
    [data-theme="dark"] .auth-right{background:#0A0806}

    /* Decorative rings */
    .auth-right::before{
      content:'';position:absolute;
      width:520px;height:520px;border-radius:50%;
      border:1px solid rgba(202,138,4,.12);
      top:-150px;left:-100px;pointer-events:none;
    }
    .auth-right::after{
      content:'';position:absolute;
      width:320px;height:320px;border-radius:50%;
      background:radial-gradient(circle,rgba(202,138,4,.08) 0%,transparent 70%);
      bottom:-80px;right:-80px;pointer-events:none;
    }

    .ar-brand{
      font-family:var(--font-serif);font-size:1.5rem;font-weight:700;
      color:#FAF9F8;text-decoration:none;
      position:relative;z-index:1;
    }
    .ar-brand span{color:var(--gold)}

    .ar-body{position:relative;z-index:1}
    .ar-body h2{
      font-family:var(--font-serif);font-size:2.1rem;font-weight:700;
      color:#FAF9F8;line-height:1.12;margin-bottom:.9rem;
    }
    .ar-body h2 em{font-style:italic;color:var(--gold-l)}
    .ar-body p{font-size:.85rem;color:rgba(250,249,248,.4);line-height:1.75}

    .ar-stats{
      display:grid;grid-template-columns:1fr 1fr;gap:.75rem;
      margin-top:2rem;position:relative;z-index:1;
    }
    .ar-stat{
      background:rgba(255,255,255,.04);
      border:1px solid rgba(202,138,4,.12);
      border-radius:10px;padding:.85rem;
    }
    .ar-stat-n{
      font-family:var(--font-serif);font-size:1.5rem;
      color:var(--gold-l);display:block;line-height:1;
    }
    .ar-stat-l{font-size:.65rem;color:rgba(250,249,248,.35);margin-top:.2rem;text-transform:uppercase;letter-spacing:.07em}

    .ar-copy{font-size:.68rem;color:rgba(250,249,248,.2);position:relative;z-index:1}

    /* ── Auth form ── */
    .auth-header{margin-bottom:2rem}
    .auth-icon{
      width:52px;height:52px;border-radius:13px;
      background:var(--accent-p);border:2px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:1.4rem;margin-bottom:1.1rem;
      color:var(--accent);
    }
    .auth-title{
      font-family:var(--font-serif);font-size:1.9rem;font-weight:700;
      color:var(--text);margin-bottom:.3rem;letter-spacing:-.02em;
    }
    .auth-sub{font-size:.85rem;color:var(--text-2);line-height:1.6}

    .form-group-m{margin-bottom:1.1rem}
    .form-label-m{
      display:block;font-size:.73rem;font-weight:600;
      color:var(--text-2);margin-bottom:.4rem;letter-spacing:.02em;text-transform:uppercase;
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
      color:var(--text-2);font-size:.85rem;pointer-events:none;
      transition:color .2s;
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

    .btn-auth-sec{
      width:100%;padding:.78rem;
      font-family:var(--font-sans);font-size:.85rem;font-weight:500;
      background:transparent;color:var(--text);
      border:1.5px solid var(--border-2);border-radius:100px;
      cursor:pointer;transition:all .25s;
      display:flex;align-items:center;justify-content:center;gap:.5rem;
      margin-top:.65rem;text-decoration:none;
    }
    .btn-auth-sec:hover{
      background:var(--surface-2);border-color:var(--accent-ln);
      color:var(--text);text-decoration:none;
    }

    .sep{
      display:flex;align-items:center;gap:.75rem;
      margin:1.3rem 0;color:var(--text-3);font-size:.73rem;
    }
    .sep::before,.sep::after{content:'';flex:1;height:1px;background:var(--border-2)}

    .auth-link{
      text-align:right;margin-top:.35rem;
    }
    .auth-link a{
      font-size:.73rem;color:var(--accent);font-weight:600;
      text-decoration:none;
    }
    .auth-link a:hover{text-decoration:underline}

    .auth-back{
      text-align:center;margin-top:1.25rem;
      font-size:.78rem;color:var(--text-2);
    }
    .auth-back a{color:var(--accent);font-weight:600;text-decoration:none}
    .auth-back a:hover{text-decoration:underline}

    /* Alert */
    .alert-m{
      display:flex;align-items:flex-start;gap:.65rem;
      padding:.9rem 1.1rem;border-radius:var(--rss);
      font-size:.83rem;margin-bottom:1.25rem;
      border-left:3px solid;
    }
    .alert-warn-m{background:var(--warn-bg);color:var(--warn);border-color:var(--warn)}
    .alert-success-m{background:var(--success-bg);color:var(--success);border-color:var(--success)}
    .alert-info-m{background:var(--info-bg);color:var(--info);border-color:var(--info)}

    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
    .auth-box>*{animation:fadeUp .4s ease both}
    .auth-box>*:nth-child(2){animation-delay:.05s}
    .auth-box>*:nth-child(3){animation-delay:.1s}
    .auth-box>*:nth-child(4){animation-delay:.15s}

    @media(max-width:768px){.auth-right{display:none}}
    @media(max-width:480px){.auth-left{padding:1.5rem 1rem}.auth-box{max-width:100%}}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>

  <div class="auth-left">
    <div class="auth-box">
      <div class="auth-header">
        <div class="auth-icon"><i class="fas fa-gavel"></i></div>
        <h1 class="auth-title">Selamat Datang</h1>
        <p class="auth-sub">Masuk ke akun peserta dan mulai ikuti lelang eksklusif hari ini.</p>
      </div>

      @if(request('info') === 'gagal')
        <div class="alert-m alert-warn-m">
          <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Username atau password tidak sesuai. Silakan coba lagi.</span>
        </div>
      @elseif(request('info') === 'logout')
        <div class="alert-m alert-success-m">
          <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Anda berhasil logout. Sampai jumpa kembali!</span>
        </div>
      @elseif(request('info') === 'login')
        <div class="alert-m alert-info-m">
          <i class="fas fa-info-circle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Silakan login untuk mengakses halaman tersebut.</span>
        </div>
      @elseif(request('info') === 'daftar')
        <div class="alert-m alert-success-m">
          <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Pendaftaran berhasil! Silakan login dengan akun baru Anda.</span>
        </div>
      @elseif(request('info') === 'belum_verif')
        <div class="alert-m alert-warn-m">
          <i class="fas fa-envelope" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>Akun Anda belum terverifikasi. Silakan cek email dan verifikasi terlebih dahulu.</span>
        </div>
      @endif

      <form action="{{ route('login.masyarakat.post') }}" method="post">
        @csrf
        <div class="form-group-m">
          <label class="form-label-m" for="username-field">Username</label>
          <div class="input-wrap">
            <i class="fas fa-user input-icon"></i>
            <input type="text" id="username-field" name="username" class="form-control-m"
              placeholder="Masukkan username Anda" autocomplete="username" required>
          </div>
        </div>

        <div class="form-group-m">
          <label class="form-label-m" for="pwd-mas">Password</label>
          <div class="input-wrap">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="pwd-mas" name="password" class="form-control-m"
              placeholder="Masukkan password" autocomplete="current-password" required>
            <button type="button" class="eye-toggle" onclick="togglePwd('pwd-mas',this)" aria-label="Tampilkan password">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="auth-link">
            <a href="{{ route('lupa.password') }}">Lupa Password?</a>
          </div>
        </div>

        <button type="submit" class="btn-auth">
          <i class="fas fa-sign-in-alt"></i> Masuk ke LuxBid
        </button>
      </form>

      <div class="sep">Belum punya akun?</div>
      <a href="{{ route('daftar.masyarakat') }}" class="btn-auth-sec">
        <i class="fas fa-user-plus"></i> Daftar Gratis Sekarang
      </a>

      <div class="auth-back">
        <a href="{{ route('home') }}">← Kembali ke Beranda</a>
      </div>
    </div>
  </div>

  <div class="auth-right">
    <a href="{{ route('home') }}" class="ar-brand">Lux<span>Bid</span></a>
    <div class="ar-body">
      <h2>Ikuti Lelang,<br>Raih Barang <em>Impian</em></h2>
      <p>Platform pelelangan daring yang transparan, real-time, dan terpercaya untuk semua kalangan.</p>
      <div class="ar-stats">
        <div class="ar-stat"><span class="ar-stat-n">2.4K+</span><div class="ar-stat-l">Peserta Aktif</div></div>
        <div class="ar-stat"><span class="ar-stat-n">890+</span><div class="ar-stat-l">Lelang Selesai</div></div>
        <div class="ar-stat"><span class="ar-stat-n">50+</span><div class="ar-stat-l">Kategori Barang</div></div>
        <div class="ar-stat"><span class="ar-stat-n">99%</span><div class="ar-stat-l">Transaksi Sukses</div></div>
      </div>
    </div>
    <div class="ar-copy">&copy; {{ date('Y') }} LuxBid &middot; Platform Pelelangan Online</div>
  </div>

  <script>
    function togglePwd(id, btn) {
      const input = document.getElementById(id);
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
      } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
      }
    }
  </script>
  <script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
