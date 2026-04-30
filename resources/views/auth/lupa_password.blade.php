<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lupa Password — Lux Bid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modern.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--gold:#B8860B;--gold-l:#D4A017;--gold-p:#FDF8EE;--gold-ln:rgba(184,134,11,.2);--ink:#1C1A15;--ink-s:#3A3527;--ink-m:#7A7260;--ink-l:#B5AFA3;--cream:#FAF7F0;--cream-d:#EDE8DC;--cream-dd:#DDD7CC;--white:#FFFFFF;--r:14px;--rs:9px;--ease:.22s cubic-bezier(.4,0,.2,1);--success:#1D6A47;--success-bg:#EDFAF3;--warn-bg:#FFF4E5;--warn:#A85B00;--danger:#C0392B;--info:#1E5A8A;--info-bg:#EEF5FC;}
    body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--cream);color:var(--ink);padding:2rem 1rem}
    .auth-wrap{width:100%;max-width:420px}
    .auth-back{display:inline-flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--ink-m);text-decoration:none;margin-bottom:1.75rem;transition:color .22s}
    .auth-back:hover{color:var(--gold)}
    .auth-icon{width:52px;height:52px;border-radius:13px;background:var(--gold-p);border:2px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem}
    .auth-title{font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--ink);margin-bottom:.3rem}
    .auth-sub{font-size:.85rem;color:var(--ink-m);line-height:1.6;margin-bottom:1.75rem}
    .card-auth{background:var(--white);border:1px solid var(--gold-ln);border-radius:var(--r);padding:1.75rem;box-shadow:0 4px 18px rgba(28,26,21,.07)}
    .step-indicator{display:flex;align-items:center;gap:.4rem;margin-bottom:1.5rem}
    .step-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;transition:all .3s}
    .step-dot.active{background:var(--ink);color:var(--cream)}
    .step-dot.done{background:var(--success);color:#fff}
    .step-dot.pending{background:var(--cream-d);color:var(--ink-l)}
    .step-line{flex:1;height:2px;background:var(--cream-dd);border-radius:2px;transition:background .3s}
    .step-line.done{background:var(--success)}
    .alert-m{display:flex;align-items:flex-start;gap:.65rem;padding:.9rem 1.1rem;border-radius:9px;font-size:.84rem;margin-bottom:1.25rem;border-left:3px solid;animation:fadeUp .3s ease both}
    .alert-warn-m{background:var(--warn-bg);color:var(--warn);border-color:var(--warn)}
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
    .btn-auth{width:100%;padding:.82rem;font-family:'DM Sans',sans-serif;font-size:.95rem;font-weight:600;background:var(--ink);color:var(--cream);border:none;border-radius:100px;cursor:pointer;transition:all .22s;box-shadow:0 4px 14px rgba(28,26,21,.16);display:flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.5rem}
    .btn-auth:hover{background:var(--gold);color:var(--ink);transform:translateY(-1px)}
    .form-hint{font-size:.73rem;color:var(--ink-l);margin-top:.3rem;line-height:1.5}
    @keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:none}}
    .auth-wrap>*{animation:fadeUp .4s ease both}
    .success-box{text-align:center;padding:1.5rem 0}
    .success-box .big-icon{font-size:3rem;margin-bottom:.75rem}
    .success-box h3{font-family:'Playfair Display',serif;font-size:1.35rem;color:var(--ink);margin-bottom:.4rem}
    .success-box p{font-size:.85rem;color:var(--ink-m);line-height:1.65}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>
<script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
<div class="auth-wrap">
  <a href="{{ route('login.masyarakat') }}" class="auth-back"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
  <div class="auth-icon">🔑</div>
  <h1 class="auth-title">Lupa Password</h1>
  <p class="auth-sub">Masukkan username dan nomor telepon terdaftar untuk mereset password Anda.</p>

  @php $step = $step ?? 1; @endphp

  <div class="step-indicator">
    <div class="step-dot {{ $step > 1 ? 'done' : 'active' }}">{{ $step > 1 ? '✓' : '1' }}</div>
    <div class="step-line {{ $step > 1 ? 'done' : '' }}"></div>
    <div class="step-dot {{ $step == 2 ? 'active' : ($step > 2 ? 'done' : 'pending') }}">{{ $step > 2 ? '✓' : '2' }}</div>
    <div class="step-line {{ $step > 2 ? 'done' : '' }}"></div>
    <div class="step-dot {{ $step == 3 ? 'done' : 'pending' }}">3</div>
  </div>

  <div class="card-auth">
    @if(isset($msg) && $msg)
      <div class="alert-m alert-warn-m"><i class="fas fa-exclamation-triangle"></i><span>{{ $msg }}</span></div>
    @endif

    @if($step == 1)
    <form method="post" action="{{ route('lupa.password.step1') }}">
      @csrf
      <div class="form-group-m">
        <label class="form-label-m">Username Akun</label>
        <div class="input-wrap">
          <i class="fas fa-user input-icon"></i>
          <input type="text" name="username" class="form-control-m" placeholder="Masukkan username Anda" required autofocus>
        </div>
      </div>
      <div class="form-group-m">
        <label class="form-label-m">Nomor Telepon Terdaftar</label>
        <div class="input-wrap">
          <i class="fas fa-phone input-icon"></i>
          <input type="text" name="telp" class="form-control-m" placeholder="08xx atau +62xx" required>
        </div>
        <div class="form-hint"><i class="fas fa-info-circle"></i> Gunakan nomor telepon yang didaftarkan saat membuat akun.</div>
      </div>
      <button type="submit" class="btn-auth"><i class="fas fa-search"></i> Cari Akun Saya</button>
    </form>

    @elseif($step == 2 && isset($found_user))
    <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:.9rem 1.1rem;margin-bottom:1.25rem;font-size:.84rem;color:var(--ink-s)">
      <i class="fas fa-user-check" style="color:var(--gold);margin-right:.4rem"></i>
      Akun ditemukan: <strong>{{ $found_user->nama_lengkap }}</strong>
    </div>
    <form method="post" action="{{ route('lupa.password.step2') }}">
      @csrf
      <input type="hidden" name="username_hidden" value="{{ $found_user->username }}">
      <div class="form-group-m">
        <label class="form-label-m">Password Baru</label>
        <div class="input-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="new_password" id="pwd-new" class="form-control-m" placeholder="Minimal 6 karakter" required>
          <button type="button" class="eye-toggle" onclick="togglePwd('pwd-new',this)"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <div class="form-group-m">
        <label class="form-label-m">Konfirmasi Password Baru</label>
        <div class="input-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="confirm_password" id="pwd-conf" class="form-control-m" placeholder="Ulangi password baru" required>
          <button type="button" class="eye-toggle" onclick="togglePwd('pwd-conf',this)"><i class="fas fa-eye"></i></button>
        </div>
        <div class="form-hint">Pastikan kedua password sama persis.</div>
      </div>
      <button type="submit" class="btn-auth"><i class="fas fa-key"></i> Simpan Password Baru</button>
    </form>

    @elseif($step == 3)
    <div class="success-box">
      <div class="big-icon">🎉</div>
      <h3>Password Berhasil Direset!</h3>
      <p>Password akun Anda telah berhasil diperbarui. Silakan masuk menggunakan password baru Anda.</p>
      <a href="{{ route('login.masyarakat') }}" style="display:inline-flex;align-items:center;gap:.5rem;margin-top:1.5rem;padding:.8rem 2rem;background:var(--ink);color:var(--cream);border-radius:100px;font-weight:600;font-size:.9rem;text-decoration:none;transition:all .22s" onmouseover="this.style.background='var(--gold)';this.style.color='var(--ink)'" onmouseout="this.style.background='var(--ink)';this.style.color='var(--cream)'">
        <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
      </a>
    </div>
    @endif
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
