<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Verifikasi Kode — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    body{min-height:100vh;background:var(--bg);display:flex;align-items:center;justify-content:center;padding:2.5rem 1rem;overflow-x:hidden;margin:0}
    .auth-wrap{width:100%;max-width:440px}
    .auth-back{display:inline-flex;align-items:center;gap:.45rem;font-size:.8rem;color:var(--text-2);text-decoration:none;margin-bottom:2rem;transition:color .2s}
    .auth-back:hover{color:var(--accent);text-decoration:none}
    .auth-icon{width:54px;height:54px;border-radius:14px;background:var(--accent-p);border:2px solid var(--accent-ln);display:flex;align-items:center;justify-content:center;font-size:1.4rem;margin-bottom:1.1rem;color:var(--accent)}
    .auth-title{font-family:var(--font-serif);font-size:1.85rem;font-weight:700;color:var(--text);margin-bottom:.35rem;letter-spacing:-.02em}
    .auth-sub{font-size:.85rem;color:var(--text-2);line-height:1.65;margin-bottom:1.75rem}
    .step-bar{display:flex;align-items:center;gap:.4rem;margin-bottom:1.75rem}
    .step-dot{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0}
    .step-dot.active{background:var(--ink);color:var(--cream)}
    .step-dot.done{background:var(--success);color:#fff}
    .step-dot.pending{background:var(--surface-2);color:var(--text-3)}
    [data-theme="dark"] .step-dot.active{background:var(--accent);color:var(--ink)}
    .step-line{flex:1;height:2px;border-radius:2px;background:var(--border-2)}
    .step-line.done{background:var(--success)}
    .card-auth{background:var(--surface);border:1px solid var(--border);border-radius:var(--r);padding:1.75rem;box-shadow:var(--shadow)}
    .alert-m{display:flex;align-items:flex-start;gap:.65rem;padding:.9rem 1.1rem;border-radius:var(--rss);font-size:.83rem;margin-bottom:1.25rem;border-left:3px solid}
    .alert-warn-m{background:var(--warn-bg);color:var(--warn);border-color:var(--warn)}
    .alert-success-m{background:var(--success-bg);color:var(--success);border-color:var(--success-border)}
    .form-group-m{margin-bottom:1.1rem}
    .form-label-m{display:block;font-size:.73rem;font-weight:600;color:var(--text-2);margin-bottom:.4rem;letter-spacing:.02em;text-transform:uppercase}
    .form-hint{font-size:.72rem;color:var(--text-3);margin-top:.3rem;line-height:1.5}
    .code-input{width:100%;padding:.85rem 1rem;text-align:center;font-size:1.8rem;font-weight:700;font-family:monospace;letter-spacing:.5rem;color:var(--text);background:var(--surface-2);border:1.5px solid var(--border-2);border-radius:var(--rs);outline:none;transition:border-color .25s,box-shadow .25s}
    .code-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--gold-glow);background:var(--surface)}
    .btn-auth{width:100%;padding:.85rem;font-family:var(--font-sans);font-size:.9rem;font-weight:600;background:var(--ink);color:var(--cream);border:none;border-radius:100px;cursor:pointer;transition:all .25s;box-shadow:0 4px 16px rgba(28,25,23,.16);display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.5rem}
    .btn-auth:hover{background:var(--accent);color:var(--ink);transform:translateY(-2px)}
    [data-theme="dark"] .btn-auth{background:var(--accent);color:var(--ink)}
    .btn-resend{background:none;border:none;color:var(--accent);font-size:.82rem;cursor:pointer;padding:0;font-family:var(--font-sans);text-decoration:underline}
    .btn-resend:hover{color:var(--ink)}
    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
    .auth-wrap>*{animation:fadeUp .4s ease both}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>

  <div class="auth-wrap">
    <a href="{{ route('lupa.password') }}" class="auth-back">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="auth-icon"><i class="fas fa-shield-alt"></i></div>
    <h1 class="auth-title">Verifikasi Kode</h1>
    <p class="auth-sub">Masukkan kode 6 digit yang telah dikirim ke email Anda{{ session('reset_email_hint') ? ' ('.session('reset_email_hint').')' : '' }}.</p>

    <div class="step-bar">
      <div class="step-dot done"><i class="fas fa-check" style="font-size:.65rem"></i></div>
      <div class="step-line done"></div>
      <div class="step-dot active">2</div>
      <div class="step-line"></div>
      <div class="step-dot pending">3</div>
    </div>

    <div class="card-auth">
      @if(session('error'))
        <div class="alert-m alert-warn-m">
          <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif
      @if(session('info'))
        <div class="alert-m alert-success-m">
          <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:.1rem"></i>
          <span>{{ session('info') }}</span>
        </div>
      @endif

      <form method="POST" action="{{ route('lupa.password.verifikasi.post') }}">
        @csrf
        <div class="form-group-m">
          <label class="form-label-m">Kode Verifikasi</label>
          <input type="text" name="kode" class="code-input" maxlength="6"
            placeholder="______" required autofocus autocomplete="off"
            oninput="this.value=this.value.replace(/\D/g,'')">
          <div class="form-hint">Kode berlaku selama 10 menit sejak dikirim.</div>
        </div>
        <button type="submit" class="btn-auth">
          <i class="fas fa-check-circle"></i> Verifikasi
        </button>
      </form>

      <div style="text-align:center;margin-top:1.25rem;font-size:.82rem;color:var(--text-3)">
        Tidak menerima kode?
        <form method="POST" action="{{ route('lupa.password.kirimulang') }}" style="display:inline">
          @csrf
          <button type="submit" class="btn-resend">Kirim Ulang</button>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
