<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Lupa Password — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    body{
      min-height:100vh;background:var(--bg);
      display:flex;align-items:center;justify-content:center;
      padding:2.5rem 1rem;overflow-x:hidden;margin:0;
    }
    .auth-wrap{width:100%;max-width:440px}

    .auth-back{
      display:inline-flex;align-items:center;gap:.45rem;
      font-size:.8rem;color:var(--text-2);text-decoration:none;
      margin-bottom:2rem;transition:color .2s;
    }
    .auth-back:hover{color:var(--accent);text-decoration:none}

    .auth-icon{
      width:54px;height:54px;border-radius:14px;
      background:var(--accent-p);border:2px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:1.4rem;margin-bottom:1.1rem;color:var(--accent);
    }
    .auth-title{
      font-family:var(--font-serif);font-size:1.85rem;font-weight:700;
      color:var(--text);margin-bottom:.35rem;letter-spacing:-.02em;
    }
    .auth-sub{font-size:.85rem;color:var(--text-2);line-height:1.65;margin-bottom:1.75rem}

    /* Steps indicator */
    .step-bar{display:flex;align-items:center;gap:.4rem;margin-bottom:1.75rem}
    .step-dot{
      width:30px;height:30px;border-radius:50%;
      display:flex;align-items:center;justify-content:center;
      font-size:.72rem;font-weight:700;transition:all .3s;
      flex-shrink:0;
    }
    .step-dot.active{background:var(--ink);color:var(--cream)}
    .step-dot.done{background:var(--success);color:#fff}
    .step-dot.pending{background:var(--surface-2);color:var(--text-3)}
    [data-theme="dark"] .step-dot.active{background:var(--accent);color:var(--ink)}
    .step-line{
      flex:1;height:2px;border-radius:2px;
      background:var(--border-2);transition:background .3s;
    }
    .step-line.done{background:var(--success)}

    .card-auth{
      background:var(--surface);border:1px solid var(--border);
      border-radius:var(--r);padding:1.75rem;box-shadow:var(--shadow);
    }

    .alert-m{
      display:flex;align-items:flex-start;gap:.65rem;
      padding:.9rem 1.1rem;border-radius:var(--rss);
      font-size:.83rem;margin-bottom:1.25rem;border-left:3px solid;
    }
    .alert-warn-m{background:var(--warn-bg);color:var(--warn);border-color:var(--warn)}

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
      color:var(--text-3);font-size:.82rem;pointer-events:none;transition:color .2s;
    }
    .input-wrap:focus-within .input-icon{color:var(--accent)}
    .form-hint{font-size:.72rem;color:var(--text-3);margin-top:.3rem;line-height:1.5}

    .btn-auth{
      width:100%;padding:.85rem;
      font-family:var(--font-sans);font-size:.9rem;font-weight:600;
      background:var(--ink);color:var(--cream);
      border:none;border-radius:100px;cursor:pointer;
      transition:background .25s,transform .25s,box-shadow .25s;
      box-shadow:0 4px 16px rgba(28,25,23,.16);
      display:flex;align-items:center;justify-content:center;gap:.5rem;
      margin-top:.5rem;
    }
    .btn-auth:hover{
      background:var(--accent);color:var(--ink);
      transform:translateY(-2px);box-shadow:0 6px 22px rgba(202,138,4,.28);
    }
    [data-theme="dark"] .btn-auth{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .btn-auth:hover{background:var(--accent-l);transform:translateY(-2px)}

    /* Success state */
    .success-box{text-align:center;padding:1.25rem 0}
    .success-icon{
      width:64px;height:64px;border-radius:50%;
      background:var(--success-bg);border:2px solid var(--success-border);
      display:flex;align-items:center;justify-content:center;
      font-size:1.75rem;color:var(--success);
      margin:0 auto 1rem;
    }
    .success-box h3{
      font-family:var(--font-serif);font-size:1.35rem;
      color:var(--text);margin-bottom:.4rem;
    }
    .success-box p{font-size:.85rem;color:var(--text-2);line-height:1.65}

    .pwd-reveal{
      display:flex;align-items:center;gap:.6rem;
      background:var(--accent-p);border:1.5px solid var(--accent-ln);
      border-radius:var(--rs);padding:.85rem 1rem;
      margin:1rem 0;
    }
    .pwd-reveal code{
      flex:1;font-size:1rem;font-weight:700;
      color:var(--text);letter-spacing:.04em;
      word-break:break-all;font-family:monospace;
    }
    .btn-copy{
      background:var(--ink);color:var(--cream);
      border:none;border-radius:var(--rss);
      padding:.45rem .8rem;cursor:pointer;
      font-size:.78rem;white-space:nowrap;
      transition:all .2s;font-family:var(--font-sans);
    }
    .btn-copy:hover{background:var(--success)}
    [data-theme="dark"] .btn-copy{background:var(--accent);color:var(--ink)}

    .pwd-warning{
      font-size:.8rem;color:var(--warn);
      background:var(--warn-bg);border-radius:var(--rss);
      padding:.65rem .9rem;text-align:left;line-height:1.6;
      margin-bottom:1.25rem;
    }

    .btn-goto{
      display:inline-flex;align-items:center;justify-content:center;gap:.5rem;
      padding:.82rem 2rem;
      background:var(--ink);color:var(--cream);
      border-radius:100px;font-weight:600;
      font-size:.9rem;text-decoration:none;
      font-family:var(--font-sans);
      transition:all .25s;
    }
    .btn-goto:hover{
      background:var(--accent);color:var(--ink);
      text-decoration:none;transform:translateY(-2px);
    }
    [data-theme="dark"] .btn-goto{background:var(--accent);color:var(--ink)}

    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
    .auth-wrap>*{animation:fadeUp .4s ease both}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>

  <div class="auth-wrap">
    <a href="{{ route('login.masyarakat') }}" class="auth-back">
      <i class="fas fa-arrow-left"></i> Kembali ke Login
    </a>

    <div class="auth-icon"><i class="fas fa-key"></i></div>
    <h1 class="auth-title">Lupa Password</h1>
    <p class="auth-sub">Masukkan username dan nomor telepon terdaftar untuk mereset password Anda.</p>

    @php $step = $step ?? 1; @endphp

    <div class="step-bar">
      <div class="step-dot {{ $step >= 1 ? 'done' : 'active' }}">
        @if($step >= 1) <i class="fas fa-check" style="font-size:.65rem"></i> @else 1 @endif
      </div>
      <div class="step-line {{ $step >= 2 ? 'done' : '' }}"></div>
      <div class="step-dot {{ $step == 3 ? 'done' : ($step == 2 ? 'active' : 'pending') }}">
        @if($step == 3) <i class="fas fa-check" style="font-size:.65rem"></i> @else 2 @endif
      </div>
    </div>

    <div class="card-auth">
      @if(isset($msg) && $msg)
        <div class="alert-m alert-warn-m">
          <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>{{ $msg }}</span>
        </div>
      @endif

      @if($step == 1)
        <form method="post" action="{{ route('lupa.password.step1') }}">
          @csrf
          <div class="form-group-m">
            <label class="form-label-m" for="username-fp">Username Akun</label>
            <div class="input-wrap">
              <i class="fas fa-user input-icon"></i>
              <input type="text" id="username-fp" name="username" class="form-control-m"
                placeholder="Masukkan username Anda" required autofocus>
            </div>
          </div>
          <div class="form-group-m">
            <label class="form-label-m" for="telp-fp">Nomor Telepon Terdaftar</label>
            <div class="input-wrap">
              <i class="fas fa-phone input-icon"></i>
              <input type="text" id="telp-fp" name="telp" class="form-control-m"
                placeholder="08xx atau +62xx" required>
            </div>
            <div class="form-hint">Gunakan nomor telepon yang didaftarkan saat membuat akun.</div>
          </div>
          <button type="submit" class="btn-auth">
            <i class="fas fa-key"></i> Proses Reset Password
          </button>
        </form>

      @elseif($step == 3)
        <div class="success-box">
          <div class="success-icon"><i class="fas fa-check"></i></div>
          <h3>Password Berhasil Direset</h3>
          <p>Password baru Anda adalah:</p>

          <div class="pwd-reveal">
            <code id="new-pwd">{{ $new_password }}</code>
            <button type="button" id="copy-btn" onclick="copyPassword()" class="btn-copy">
              <i class="fas fa-copy"></i> Salin
            </button>
          </div>

          <div class="pwd-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Segera ganti password setelah login. Password ini hanya ditampilkan sekali.
          </div>

          <a href="{{ route('login.masyarakat') }}" class="btn-goto">
            <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
          </a>
        </div>
      @endif
    </div>
  </div>

  <script>
    function copyPassword() {
      const pwd = document.getElementById('new-pwd').textContent.trim();
      navigator.clipboard.writeText(pwd).then(function() {
        const btn = document.getElementById('copy-btn');
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        btn.style.background = 'var(--success)';
        setTimeout(function() {
          btn.innerHTML = '<i class="fas fa-copy"></i> Salin';
          btn.style.background = '';
        }, 2500);
      });
    }
  </script>
  <script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
