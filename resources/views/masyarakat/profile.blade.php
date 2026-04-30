@extends('layouts.masyarakat')
@push('styles')
<style>
.profile-avatar{width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid var(--gold-ln);display:block}
.profile-avatar-placeholder{width:100px;height:100px;border-radius:50%;background:var(--gold-p);border:3px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:2.5rem;font-weight:700;color:var(--gold)}
.profile-foto-wrap{position:relative;display:inline-block}
.profile-foto-btn{position:absolute;bottom:0;right:0;width:28px;height:28px;border-radius:50%;background:var(--ink);color:var(--cream);border:2px solid var(--cream);display:flex;align-items:center;justify-content:center;font-size:.7rem;cursor:pointer;transition:background .2s}
.profile-foto-btn:hover{background:var(--gold)}
/* Eye toggle fix */
.profile-pw-wrap{position:relative;display:flex;align-items:center}
.profile-pw-wrap .form-control-m{padding-left:2.8rem;padding-right:2.6rem}
.profile-pw-wrap .input-icon{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);color:var(--ink-l);font-size:.85rem;pointer-events:none;transition:color .2s}
.profile-pw-wrap:focus-within .input-icon{color:var(--gold)}
.profile-pw-wrap .eye-toggle{position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;padding:0;cursor:pointer;color:var(--ink-l);font-size:1.1rem;line-height:1;display:flex;align-items:center;justify-content:center;width:20px;height:20px;transition:color .2s}
.profile-pw-wrap .eye-toggle:hover,.profile-pw-wrap .eye-toggle.active{color:var(--gold)}
</style>
@endpush
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Profil Saya</h1><p class="page-sub">Kelola informasi akun dan keamanan Anda.</p></div>
</div>

{{-- Foto Profil --}}
<div class="card-m fade-up" style="margin-bottom:1.5rem">
  <div class="card-m-header"><div class="card-m-title"><span>📷</span> Foto Profil</div></div>
  <div class="card-m-body" style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap">
    @if(session('info_profile'))
      <div class="alert-m alert-{{ session('info_type','success') }}-m" style="width:100%">
        <span>{{ session('info_profile') }}</span>
        <button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button>
      </div>
    @endif
    <form method="post" action="{{ route('masyarakat.profile.foto') }}" enctype="multipart/form-data" id="foto-form">
      @csrf
      <div class="profile-foto-wrap">
        @if($user->foto)
          <img src="{{ asset('uploads/profile/'.$user->foto) }}" class="profile-avatar" alt="Foto Profil">
        @else
          <div class="profile-avatar-placeholder">{{ strtoupper(substr($user->nama_lengkap,0,1)) }}</div>
        @endif
        <label class="profile-foto-btn" title="Ganti foto" for="foto-input"><i class="fas fa-camera"></i></label>
        <input type="file" id="foto-input" name="foto" accept="image/*" style="display:none" onchange="document.getElementById('foto-form').submit()">
      </div>
    </form>
    <div>
      <div style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:700;color:var(--ink)">{{ $user->nama_lengkap }}</div>
      <div style="font-size:.85rem;color:var(--ink-m)">@<span>{{ $user->username }}</span></div>
      <div style="font-size:.75rem;color:var(--ink-l);margin-top:.25rem">Klik ikon kamera untuk ganti foto (maks. 2MB)</div>
    </div>
  </div>
</div>

{{-- Edit Profil --}}
<div class="card-m fade-up delay-1" style="margin-bottom:1.5rem">
  <div class="card-m-header"><div class="card-m-title"><span>✏️</span> Edit Profil</div></div>
  <div class="card-m-body">
    <form method="post" action="{{ route('masyarakat.profile.update') }}">
      @csrf
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1rem;margin-bottom:1rem">
        <div class="form-group-m">
          <label class="form-label-m">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control-m" value="{{ $user->nama_lengkap }}" required>
        </div>
        <div class="form-group-m">
          <label class="form-label-m">Username</label>
          <input type="text" name="username" class="form-control-m" value="{{ $user->username }}" required>
        </div>
        <div class="form-group-m">
          <label class="form-label-m">Email</label>
          <input type="email" name="email" class="form-control-m" value="{{ $user->email }}" placeholder="Opsional">
        </div>
        <div class="form-group-m">
          <label class="form-label-m">Nomor Telepon</label>
          <input type="tel" name="telp" class="form-control-m" value="{{ $user->telp }}" required>
        </div>
      </div>
      <div class="form-group-m" style="max-width:320px">
        <label class="form-label-m">Konfirmasi Password <span style="color:var(--danger)">*</span></label>
        <div class="profile-pw-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="confirm_password" id="pw-confirm" class="form-control-m" placeholder="Masukkan password untuk konfirmasi" required>
          <button type="button" class="eye-toggle" onclick="togglePwd('pw-confirm',this)"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <button type="submit" class="btn-m btn-primary-m"><i class="fas fa-save"></i> Simpan Perubahan</button>
    </form>
  </div>
</div>

{{-- Ganti Password --}}
<div class="card-m fade-up delay-2">
  <div class="card-m-header"><div class="card-m-title"><span>🔒</span> Ganti Password</div></div>
  <div class="card-m-body">
    @if(session('info_password'))
      <div class="alert-m alert-{{ session('info_type_pw','success') }}-m" style="margin-bottom:1rem">
        <span>{{ session('info_password') }}</span>
        <button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button>
      </div>
    @endif
    <form method="post" action="{{ route('masyarakat.profile.password') }}" style="max-width:400px">
      @csrf
      <div class="form-group-m">
        <label class="form-label-m">Password Lama</label>
        <div class="profile-pw-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="old_password" id="pw-old" class="form-control-m" placeholder="Password saat ini" required>
          <button type="button" class="eye-toggle" onclick="togglePwd('pw-old',this)"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <div class="form-group-m">
        <label class="form-label-m">Password Baru</label>
        <div class="profile-pw-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="new_password" id="pw-new" class="form-control-m" placeholder="Minimal 6 karakter" required>
          <button type="button" class="eye-toggle" onclick="togglePwd('pw-new',this)"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <div class="form-group-m">
        <label class="form-label-m">Konfirmasi Password Baru</label>
        <div class="profile-pw-wrap">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="confirm_new_password" id="pw-new2" class="form-control-m" placeholder="Ulangi password baru" required>
          <button type="button" class="eye-toggle" onclick="togglePwd('pw-new2',this)"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <button type="submit" class="btn-m btn-primary-m"><i class="fas fa-key"></i> Ganti Password</button>
    </form>
  </div>
</div>
@endsection
@push('scripts')
<script>
function togglePwd(id,btn){const i=document.getElementById(id),ic=btn.querySelector('i');i.type=i.type==='password'?'text':'password';ic.className=i.type==='password'?'fas fa-eye':'fas fa-eye-slash';btn.classList.toggle('active',i.type==='text');}
</script>
@endpush
