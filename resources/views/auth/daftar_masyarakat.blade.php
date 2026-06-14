<!DOCTYPE html>
<html lang="id">
<head>
  <script>(function(){var d=localStorage.getItem('theme')==='dark';document.documentElement.setAttribute('data-theme',d?'dark':'light');})()</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Daftar Akun — LuxBid</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/luxbid.css') }}">
  <link rel="icon" href="{{ asset('assets/favicon.jpeg') }}">
  <style>
    body{background:var(--bg);min-height:100vh;padding:2.5rem 1rem 4rem;overflow-x:hidden;margin:0}

    .reg-outer{width:100%;max-width:900px;margin:0 auto}

    /* Back link */
    .reg-back{
      display:inline-flex;align-items:center;gap:.45rem;
      font-size:.8rem;color:var(--text-2);text-decoration:none;
      margin-bottom:2rem;transition:color .2s;
    }
    .reg-back:hover{color:var(--accent);text-decoration:none}

    /* Header */
    .reg-header{margin-bottom:2.25rem}
    .reg-icon{
      width:54px;height:54px;border-radius:14px;
      background:var(--accent-p);border:2px solid var(--accent-ln);
      display:flex;align-items:center;justify-content:center;
      font-size:1.4rem;margin-bottom:1rem;color:var(--accent);
    }
    .reg-title{
      font-family:var(--font-serif);font-size:2.1rem;font-weight:700;
      color:var(--text);margin-bottom:.35rem;letter-spacing:-.025em;
    }
    .reg-sub{font-size:.85rem;color:var(--text-2);line-height:1.65}

    /* Grid */
    .reg-grid{
      display:grid;grid-template-columns:1fr 340px;gap:2.5rem;align-items:start;
    }

    /* Form card */
    .reg-card{
      background:var(--surface);border:1px solid var(--border);
      border-radius:var(--r);padding:2rem 2.25rem;
      box-shadow:var(--shadow);
    }

    .form-group-m{margin-bottom:1.15rem}
    .form-label-m{
      display:block;font-size:.73rem;font-weight:600;
      color:var(--text-2);margin-bottom:.4rem;
      letter-spacing:.02em;text-transform:uppercase;
    }
    .form-label-m .opt{font-weight:400;color:var(--text-3);text-transform:none;font-size:.72rem}
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
    .eye-toggle{
      position:absolute;right:.85rem;top:50%;transform:translateY(-50%);
      background:none;border:none;cursor:pointer;
      color:var(--text-3);font-size:.88rem;padding:0;
      transition:color .2s;line-height:1;
    }
    .eye-toggle:hover{color:var(--text)}
    .form-hint{font-size:.72rem;color:var(--text-3);margin-top:.3rem;line-height:1.5}

    .btn-reg{
      width:100%;padding:.88rem;
      font-family:var(--font-sans);font-size:.9rem;font-weight:600;
      background:var(--ink);color:var(--cream);
      border:none;border-radius:100px;cursor:pointer;
      transition:background .25s,transform .25s,box-shadow .25s;
      box-shadow:0 4px 16px rgba(28,25,23,.16);
      display:flex;align-items:center;justify-content:center;gap:.5rem;
      margin-top:.5rem;
    }
    .btn-reg:hover{
      background:var(--accent);color:var(--ink);
      transform:translateY(-2px);box-shadow:0 6px 22px rgba(202,138,4,.28);
    }
    [data-theme="dark"] .btn-reg{background:var(--accent);color:var(--ink)}
    [data-theme="dark"] .btn-reg:hover{background:var(--accent-l);transform:translateY(-2px)}

    .reg-login{
      text-align:center;margin-top:1.15rem;
      font-size:.8rem;color:var(--text-2);
    }
    .reg-login a{color:var(--accent);font-weight:600;text-decoration:none}
    .reg-login a:hover{text-decoration:underline}

    /* Sidebar */
    .reg-side{display:flex;flex-direction:column;gap:1rem;position:sticky;top:2rem}

    .side-dark-card{
      background:var(--ink);border-radius:var(--r);padding:1.75rem;
      overflow:hidden;position:relative;
    }
    [data-theme="dark"] .side-dark-card{background:#0A0806;border:1px solid var(--border)}
    .side-dark-card::before{
      content:'';position:absolute;
      width:200px;height:200px;border-radius:50%;
      background:radial-gradient(circle,rgba(202,138,4,.1) 0%,transparent 70%);
      bottom:-40px;right:-40px;pointer-events:none;
    }
    .side-dark-card h3{
      font-family:var(--font-serif);font-size:1.1rem;
      color:#FAF9F8;margin-bottom:.4rem;position:relative;z-index:1;
    }
    .side-dark-card p{
      font-size:.8rem;color:rgba(250,249,248,.38);
      line-height:1.65;position:relative;z-index:1;
    }
    .side-steps{
      display:flex;flex-direction:column;gap:.65rem;
      margin-top:1.1rem;position:relative;z-index:1;
    }
    .side-step{display:flex;align-items:center;gap:.65rem;font-size:.82rem;color:rgba(250,249,248,.5)}
    .side-step-n{
      width:22px;height:22px;min-width:22px;border-radius:50%;
      background:rgba(202,138,4,.2);border:1px solid rgba(202,138,4,.3);
      display:flex;align-items:center;justify-content:center;
      font-size:.68rem;font-weight:700;color:var(--gold-l);
    }

    .side-light-card{
      background:var(--accent-p);border:1px solid var(--accent-ln);
      border-radius:var(--r);padding:1.25rem;
    }
    .side-light-card h4{
      font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:.55rem;
    }
    .side-light-card ul{list-style:none;display:flex;flex-direction:column;gap:.35rem}
    .side-light-card li{
      font-size:.78rem;color:var(--text-2);
      display:flex;align-items:center;gap:.5rem;
    }
    .side-light-card li::before{
      content:'';width:16px;height:16px;min-width:16px;border-radius:50%;
      background:rgba(202,138,4,.15);
      background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2 6l3 3 5-5' stroke='%23CA8A04' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
      background-repeat:no-repeat;background-position:center;background-size:10px;
    }

    /* Alert */
    .alert-notice{
      background:var(--warn-bg);border:1px solid var(--warn-border);
      border-radius:var(--rs);padding:.85rem 1rem;
      margin-bottom:1.1rem;font-size:.84rem;color:var(--warn);
      display:flex;align-items:flex-start;gap:.6rem;
    }
    .alert-danger{
      background:var(--danger-bg);border:1px solid var(--danger-border);
      border-radius:var(--rs);padding:.85rem 1rem;
      margin-bottom:1.1rem;font-size:.84rem;color:var(--danger);
      display:flex;align-items:flex-start;gap:.6rem;
    }

    @keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
    .reg-outer>*{animation:fadeUp .4s ease both}
    .reg-grid>*:last-child{animation-delay:.08s}

    @media(max-width:860px){.reg-grid{grid-template-columns:1fr}.reg-side{display:none}}
    @media(max-width:480px){.reg-card{padding:1.5rem}}
  </style>
</head>
<body>
  <button class="dm-toggle" id="dm-toggle" title="Toggle dark mode" style="position:fixed;top:1rem;right:1rem;z-index:999"><i class="fas fa-moon"></i></button>

  <div class="reg-outer">
    <a href="{{ route('home') }}" class="reg-back">
      <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="reg-header">
      <div class="reg-icon"><i class="fas fa-user-plus"></i></div>
      <h1 class="reg-title">Buat Akun Baru</h1>
      <p class="reg-sub">Daftar gratis dan mulai ikuti lelang eksklusif dalam hitungan menit.</p>
    </div>

    <div class="reg-grid">
      <div>
        @if(request('info') === 'telp_invalid')
          <div class="alert-notice">
            <i class="fas fa-exclamation-triangle" style="flex-shrink:0;margin-top:.1rem"></i>
            <span>Nomor telepon tidak valid. Gunakan format 08xx atau +62xx (8–12 digit angka).</span>
          </div>
        @elseif(request('info') === 'username_exists')
          <div class="alert-danger">
            <i class="fas fa-times-circle" style="flex-shrink:0;margin-top:.1rem"></i>
            <span>Username sudah digunakan. Silakan pilih username yang berbeda.</span>
          </div>
        @elseif(request('info') === 'email_required')
          <div class="alert-danger">
            <i class="fas fa-times-circle" style="flex-shrink:0;margin-top:.1rem"></i>
            <span>Email wajib diisi untuk verifikasi akun.</span>
          </div>
        @elseif(request('info') === 'email_exists')
          <div class="alert-danger">
            <i class="fas fa-times-circle" style="flex-shrink:0;margin-top:.1rem"></i>
            <span>Email sudah terdaftar. Gunakan email lain atau <a href="{{ route('login.masyarakat') }}" style="color:var(--danger);font-weight:600">masuk di sini</a>.</span>
          </div>
        @endif

        <div class="reg-card">
          <form action="{{ route('daftar.masyarakat.post') }}" method="post">
            @csrf
            <div class="form-group-m">
              <label class="form-label-m" for="nama-field">Nama Lengkap</label>
              <div class="input-wrap">
                <i class="fas fa-id-card input-icon"></i>
                <input type="text" id="nama-field" name="nama_lengkap" class="form-control-m"
                  placeholder="Nama lengkap sesuai KTP" required>
              </div>
            </div>

            <div class="form-group-m">
              <label class="form-label-m" for="username-field">Username</label>
              <div class="input-wrap">
                <i class="fas fa-at input-icon"></i>
                <input type="text" id="username-field" name="username" class="form-control-m"
                  placeholder="Pilih username unik" autocomplete="username" required>
              </div>
              <div class="form-hint">Username digunakan untuk login dan tidak dapat diubah.</div>
            </div>

            <div class="form-group-m">
              <label class="form-label-m" for="reg-pwd">Password</label>
              <div class="input-wrap">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" id="reg-pwd" name="password" class="form-control-m"
                  placeholder="Buat password yang kuat" autocomplete="new-password" required>
                <button type="button" class="eye-toggle" onclick="togglePwd('reg-pwd',this)" aria-label="Tampilkan password">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <div class="form-hint">Minimal 6 karakter, kombinasikan huruf dan angka.</div>
            </div>

            <div class="form-group-m">
              <label class="form-label-m" for="telp-field">Nomor Telepon</label>
              <div class="input-wrap">
                <i class="fas fa-phone input-icon"></i>
                <input type="tel" id="telp-field" name="telp" class="form-control-m"
                  placeholder="08xx atau +62xx"
                  pattern="^(?:\+62|08)[1-9][0-9]{7,11}$" required>
              </div>
              <div class="form-hint">Format: 08xx-xxxx-xxxx atau +62xxx-xxxx-xxxx</div>
            </div>

            <div class="form-group-m">
              <label class="form-label-m" for="email-field">Email</label>
              <div class="input-wrap">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" id="email-field" name="email" class="form-control-m"
                  placeholder="contoh@email.com" required>
              </div>
              <div class="form-hint">Email digunakan untuk verifikasi akun dan notifikasi lelang.</div>
            </div>

            <button type="submit" class="btn-reg">
              <i class="fas fa-user-plus"></i> Daftar Sekarang — Gratis
            </button>
          </form>

          <div class="reg-login">
            Sudah punya akun? <a href="{{ route('login.masyarakat') }}">Masuk di sini &rarr;</a>
          </div>
        </div>
      </div>

      <div class="reg-side">
        <div class="side-dark-card">
          <h3>Cara Bergabung</h3>
          <p>Proses pendaftaran mudah, cepat, dan gratis</p>
          <div class="side-steps">
            <div class="side-step"><div class="side-step-n">1</div> Isi formulir dengan data valid</div>
            <div class="side-step"><div class="side-step-n">2</div> Verifikasi email dengan kode OTP</div>
            <div class="side-step"><div class="side-step-n">3</div> Login dan ikuti lelang aktif</div>
            <div class="side-step"><div class="side-step-n">4</div> Menangkan dan raih barang impian</div>
          </div>
        </div>

        <div class="side-light-card">
          <h4>Keuntungan Bergabung</h4>
          <ul>
            <li>Akses semua lelang aktif secara gratis</li>
            <li>Ajukan penawaran kapan saja</li>
            <li>Riwayat transaksi lengkap & aman</li>
            <li>Download faktur pemenang resmi (PDF)</li>
            <li>Dukungan petugas profesional</li>
          </ul>
        </div>
      </div>
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
