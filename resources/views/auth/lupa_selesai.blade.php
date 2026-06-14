<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Password Baru — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    body{min-height:100vh;background:var(--bg);display:flex;align-items:center;justify-content:center;padding:2.5rem 1rem;overflow-x:hidden;margin:0}
    .auth-wrap{width:100%;max-width:440px}
    .auth-icon{width:64px;height:64px;border-radius:50%;background:var(--success-bg);border:2px solid var(--success-border);display:flex;align-items:center;justify-content:center;font-size:1.75rem;color:var(--success);margin-bottom:1.1rem}
    .auth-title{font-family:var(--font-serif);font-size:1.85rem;font-weight:700;color:var(--text);margin-bottom:.35rem;letter-spacing:-.02em}
    .auth-sub{font-size:.85rem;color:var(--text-2);line-height:1.65;margin-bottom:1.75rem}
    .step-bar{display:flex;align-items:center;gap:.4rem;margin-bottom:1.75rem}
    .step-dot{width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0}
    .step-dot.done{background:var(--success);color:#fff}
    .step-line{flex:1;height:2px;border-radius:2px;background:var(--success)}
    .card-auth{background:var(--surface);border:1px solid var(--border);border-radius:var(--r);padding:1.75rem;box-shadow:var(--shadow);text-align:center}
    .pwd-reveal{display:flex;align-items:center;gap:.6rem;background:var(--accent-p);border:1.5px solid var(--accent-ln);border-radius:var(--rs);padding:.85rem 1rem;margin:1rem 0}
    .pwd-reveal code{flex:1;font-size:1.4rem;font-weight:800;color:var(--text);letter-spacing:.1rem;font-family:monospace}
    .btn-copy{background:var(--ink);color:var(--cream);border:none;border-radius:var(--rss);padding:.45rem .8rem;cursor:pointer;font-size:.78rem;white-space:nowrap;transition:all .2s;font-family:var(--font-sans)}
    .btn-copy:hover{background:var(--success)}
    [data-theme="dark"] .btn-copy{background:var(--accent);color:var(--ink)}
    .pwd-warning{font-size:.82rem;color:var(--warn);background:var(--warn-bg);border-radius:var(--rss);padding:.65rem .9rem;text-align:left;line-height:1.6;margin-bottom:1.25rem}
    .btn-goto{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.82rem 2rem;background:var(--ink);color:var(--cream);border-radius:100px;font-weight:600;font-size:.9rem;text-decoration:none;font-family:var(--font-sans);transition:all .25s}
    .btn-goto:hover{background:var(--accent);color:var(--ink);text-decoration:none;transform:translateY(-2px)}
    [data-theme="dark"] .btn-goto{background:var(--accent);color:var(--ink)}
    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
    .auth-wrap>*{animation:fadeUp .4s ease both}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>

  <div class="auth-wrap">
    <div class="auth-icon"><i class="fas fa-check"></i></div>
    <h1 class="auth-title">Password Berhasil Direset</h1>
    <p class="auth-sub">Gunakan password sementara di bawah untuk masuk ke akun Anda.</p>

    <div class="step-bar">
      <div class="step-dot done"><i class="fas fa-check" style="font-size:.65rem"></i></div>
      <div class="step-line"></div>
      <div class="step-dot done"><i class="fas fa-check" style="font-size:.65rem"></i></div>
      <div class="step-line"></div>
      <div class="step-dot done"><i class="fas fa-check" style="font-size:.65rem"></i></div>
    </div>

    <div class="card-auth">
      <p style="font-size:.88rem;color:var(--text-2);margin-bottom:.5rem">Password sementara Anda:</p>

      <div class="pwd-reveal">
        <code id="new-pwd">{{ $password }}</code>
        <button type="button" id="copy-btn" onclick="copyPassword()" class="btn-copy">
          <i class="fas fa-copy"></i> Salin
        </button>
      </div>

      <div class="pwd-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Penting:</strong> Segera ganti password Anda setelah login. Password ini hanya ditampilkan sekali dan tidak akan dikirim ulang.
      </div>

      <a href="{{ route('login.masyarakat') }}" class="btn-goto">
        <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
      </a>
    </div>
  </div>

  <script>
    function copyPassword() {
      navigator.clipboard.writeText(document.getElementById('new-pwd').textContent.trim()).then(function() {
        const btn = document.getElementById('copy-btn');
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        btn.style.background = 'var(--success)';
        setTimeout(function() { btn.innerHTML = '<i class="fas fa-copy"></i> Salin'; btn.style.background = ''; }, 2500);
      });
    }
  </script>
  <script src="{{ asset('assets/theme.js') }}"></script>
</body>
</html>
