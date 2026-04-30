
@extends('layouts.petugas')
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Manajemen Petugas</h1><p class="page-sub">Kelola akun petugas dan admin yang memiliki akses ke panel kontrol.</p></div>
  <button class="btn-m btn-primary-m" onclick="openModal('modal-tambah')"><i class="fas fa-user-plus"></i> Tambah Petugas</button>
</div>

@if(request('info')=='hapus')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Data petugas berhasil dihapus.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='simpan')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Petugas baru berhasil ditambahkan.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='update')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Data petugas berhasil diperbarui.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif

<div class="card-m fade-up delay-1">
  <div class="card-m-header"><div class="card-m-title"><span>👥</span> Daftar Petugas & Admin</div></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Petugas</th><th>Username</th><th>Level Akses</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($tb_petugas as $i=>$d)
        <tr>
          <td style="color:var(--ink-l)">{{ $i+1 }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:.65rem">
              <div style="width:34px;height:34px;border-radius:50%;background:var(--gold-p);border:2px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:var(--gold)">{{ strtoupper(substr($d->nama_petugas,0,1)) }}</div>
              <strong style="color:var(--ink)">{{ $d->nama_petugas }}</strong>
              @if(session('username')==$d->username)<span style="font-size:.65rem;background:var(--gold-p);color:var(--gold);border:1px solid var(--gold-ln);padding:.1rem .45rem;border-radius:100px;font-weight:600">Anda</span>@endif
            </div>
          </td>
          <td style="color:var(--ink-m);font-family:monospace;font-size:.85rem">@{{ $d->username }}</td>
          <td>@if($d->id_level==1)<span class="badge-m badge-info"><i class="fas fa-crown" style="font-size:.6rem"></i> Admin</span>@else<span class="badge-m badge-pending">Petugas</span>@endif</td>
          <td>
            <div style="display:flex;gap:.4rem">
              <button class="btn-m btn-warn-m btn-sm-m" onclick="openModal('modal-ubah{{ $d->id_petugas }}')"><i class="fas fa-edit"></i> Edit</button>
              @if(session('username')!=$d->username)<button class="btn-m btn-danger-m btn-sm-m" onclick="openModal('modal-hapus{{ $d->id_petugas }}')"><i class="fas fa-trash"></i></button>@endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:3rem;color:var(--ink-m)">Belum ada data petugas.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@foreach($tb_petugas as $d)
<div class="modal-m-overlay" id="modal-hapus{{ $d->id_petugas }}">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Hapus Petugas</span><button class="modal-m-close" onclick="closeModal('modal-hapus{{ $d->id_petugas }}')">×</button></div>
  <div class="modal-m-body" style="text-align:center;padding:1.5rem"><div style="font-size:2.5rem;margin-bottom:.75rem">⚠️</div><p style="font-size:.9rem;color:var(--ink-s)">Hapus akun <strong>{{ $d->nama_petugas }}</strong>?</p></div>
  <div class="modal-m-footer"><button class="btn-m btn-outline-m" onclick="closeModal('modal-hapus{{ $d->id_petugas }}')">Batal</button><form method="post" action="{{ route('administrator.petugas.hapus') }}" style="display:inline">@csrf<input type="hidden" name="id_petugas" value="{{ $d->id_petugas }}"><button type="submit" class="btn-m btn-danger-m">Ya, Hapus</button></form></div></div>
</div>
<div class="modal-m-overlay" id="modal-ubah{{ $d->id_petugas }}">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Edit Petugas</span><button class="modal-m-close" onclick="closeModal('modal-ubah{{ $d->id_petugas }}')">×</button></div>
  <form method="post" action="{{ route('administrator.petugas.update') }}">@csrf
    <div class="modal-m-body">
      <input type="hidden" name="id_petugas" value="{{ $d->id_petugas }}">
      <div class="form-group-m"><label class="form-label-m">Nama Petugas</label><input type="text" class="form-control-m" name="nama_petugas" value="{{ $d->nama_petugas }}" required></div>
      <div class="form-group-m"><label class="form-label-m">Username</label><input type="text" class="form-control-m" name="username" value="{{ $d->username }}" required></div>
      <div class="form-group-m"><label class="form-label-m">Password Baru</label><input type="password" class="form-control-m" name="password" value="{{ $d->password }}" placeholder="Isi untuk mengganti password"></div>
      <div class="form-group-m"><label class="form-label-m">Level</label>
        <select name="id_level" class="form-control-m" style="padding-left:1rem">
          @foreach($tb_level as $l)<option value="{{ $l->id_level }}" {{ $l->id_level==$d->id_level?'selected':'' }}>{{ $l->level }}</option>@endforeach
        </select>
      </div>
    </div>
    <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-ubah{{ $d->id_petugas }}')">Batal</button><button type="submit" class="btn-m btn-primary-m"><i class="fas fa-save"></i> Simpan</button></div>
  </form></div>
</div>
@endforeach

<div class="modal-m-overlay" id="modal-tambah">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Tambah Petugas Baru</span><button class="modal-m-close" onclick="closeModal('modal-tambah')">×</button></div>
  <form method="post" action="{{ route('administrator.petugas.simpan') }}">@csrf
    <div class="modal-m-body">
      <div class="form-group-m"><label class="form-label-m">Nama Petugas</label><input type="text" class="form-control-m" name="nama_petugas" placeholder="Nama lengkap" required></div>
      <div class="form-group-m"><label class="form-label-m">Username</label><input type="text" class="form-control-m" name="username" placeholder="Username login" required></div>
      <div class="form-group-m"><label class="form-label-m">Password</label><input type="password" class="form-control-m" name="password" placeholder="Password akun" required></div>
      <div class="form-group-m"><label class="form-label-m">Level Akses</label>
        <select class="form-control-m" style="padding-left:1rem" name="id_level" required>
          <option value="">— Pilih Level —</option><option value="1">Admin</option><option value="2">Petugas</option>
        </select>
      </div>
    </div>
    <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-tambah')">Batal</button><button type="submit" class="btn-m btn-primary-m"><i class="fas fa-user-plus"></i> Tambah</button></div>
  </form></div>
</div>
@endsection
@push('scripts')
<script>
function openModal(id){document.getElementById(id).classList.add('show');document.body.style.overflow='hidden'}
function closeModal(id){document.getElementById(id).classList.remove('show');document.body.style.overflow=''}
document.querySelectorAll('.modal-m-overlay').forEach(o=>o.addEventListener('click',function(e){if(e.target===this)closeModal(this.id)}));
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.querySelectorAll('.modal-m-overlay.show').forEach(m=>closeModal(m.id))});
</script>
@endpush
