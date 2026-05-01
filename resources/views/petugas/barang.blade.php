
@extends('layouts.petugas')
@push('styles')
<style>
.img-upload-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-top:.5rem}
.img-slot{position:relative;border:2px dashed var(--cream-dd);border-radius:10px;aspect-ratio:1;overflow:hidden;cursor:pointer;transition:border-color .22s,background .22s}
.img-slot:hover{border-color:var(--gold);background:var(--gold-p)}
.img-slot input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;z-index:2}
.img-slot-placeholder{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;gap:.4rem;color:var(--ink-l);font-size:.75rem;pointer-events:none}
.img-slot-placeholder i{font-size:1.4rem;color:var(--cream-dd)}
.img-slot-preview{position:absolute;inset:0;object-fit:cover;width:100%;height:100%;z-index:1}
.img-slot-badge{position:absolute;top:.35rem;left:.35rem;background:var(--ink);color:var(--cream);font-size:.62rem;font-weight:700;padding:.15rem .4rem;border-radius:4px;z-index:3}
.img-slot-remove{position:absolute;top:.35rem;right:.35rem;background:var(--danger);color:#fff;border:none;border-radius:50%;width:22px;height:22px;font-size:.75rem;cursor:pointer;z-index:3;display:none;align-items:center;justify-content:center}
.img-slot-remove.visible{display:flex}
/* Fix modal scroll untuk form panjang */
.modal-tall .modal-m-body{max-height:calc(100vh - 200px);overflow-y:auto}
.modal-tall{align-items:flex-start;padding-top:2rem;padding-bottom:2rem}
</style>
@endpush
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Pendataan Barang</h1><p class="page-sub">Kelola semua barang yang akan dilelang.</p></div>
  <button class="btn-m btn-primary-m" onclick="openModal('modal-tambah')"><i class="fas fa-plus"></i> Tambah Barang</button>
</div>

@if(request('info')=='hapus')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Data barang berhasil dihapus.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='simpan')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Data barang berhasil disimpan.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='update')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Data barang berhasil diperbarui.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif

<div class="card-m fade-up delay-1">
  <div class="card-m-header"><div class="card-m-title"><span>📦</span> Daftar Barang Lelang</div></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Foto</th><th>Nama Barang</th><th>Penjual</th><th>Tanggal</th><th>Harga Awal</th><th>Deskripsi</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($rows_barang as $i=>$d)
        @php $thumb = $all_gambar[$d->id_barang][1] ?? null; @endphp
        <tr>
          <td style="color:var(--ink-l);font-size:.8rem">{{ $i+1 }}</td>
          <td>
            @if($thumb)<img src="{{ asset('uploads/barang/'.$thumb->nama_file) }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid var(--cream-dd)">
            @else<div style="width:48px;height:48px;background:var(--cream-d);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.2rem">📷</div>@endif
          </td>
          <td><strong style="color:var(--ink)">{{ $d->nama_barang }}</strong></td>
          <td style="color:var(--ink-m)">{{ $d->nama_penjual ?: '—' }}</td>
          <td style="color:var(--ink-m)">{{ $d->tgl }}</td>
          <td style="font-weight:600;color:var(--success)">Rp {{ number_format($d->harga_awal) }}</td>
          <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--ink-m)">{{ $d->deskripsi_barang ?: '—' }}</td>
          <td>
            <div style="display:flex;gap:.4rem;flex-wrap:wrap">
              <button class="btn-m btn-warn-m btn-sm-m" onclick="openModal('modal-ubah{{ $d->id_barang }}')"><i class="fas fa-edit"></i> Edit</button>
              <button class="btn-m btn-danger-m btn-sm-m" onclick="openModal('modal-hapus{{ $d->id_barang }}')"><i class="fas fa-trash"></i> Hapus</button>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--ink-m)"><div style="font-size:2rem;opacity:.25;margin-bottom:.5rem">📦</div>Belum ada data barang</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@foreach($rows_barang as $d)
@php $imgs = $all_gambar[$d->id_barang] ?? collect([]); @endphp
<div class="modal-m-overlay" id="modal-hapus{{ $d->id_barang }}">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Konfirmasi Hapus</span><button class="modal-m-close" onclick="closeModal('modal-hapus{{ $d->id_barang }}')">×</button></div>
  <div class="modal-m-body"><div style="text-align:center;padding:1rem 0"><div style="font-size:2.5rem;margin-bottom:.75rem">🗑️</div><p style="font-size:.9rem;color:var(--ink-s)">Yakin ingin menghapus barang <strong>{{ $d->nama_barang }}</strong>?</p></div></div>
  <div class="modal-m-footer"><button class="btn-m btn-outline-m" onclick="closeModal('modal-hapus{{ $d->id_barang }}')">Batal</button><a href="{{ route('petugas.barang.hapus', ['id_barang'=>$d->id_barang]) }}" class="btn-m btn-danger-m">Ya, Hapus</a></div></div>
</div>
<div class="modal-m-overlay modal-tall" id="modal-ubah{{ $d->id_barang }}">
  <div class="modal-m" style="max-width:520px"><div class="modal-m-header"><span class="modal-m-title">Edit Barang</span><button class="modal-m-close" onclick="closeModal('modal-ubah{{ $d->id_barang }}')">×</button></div>
  <form method="post" action="{{ route('petugas.barang.update') }}" enctype="multipart/form-data">@csrf
    <div class="modal-m-body">
      <input type="hidden" name="id_barang" value="{{ $d->id_barang }}">
      <div class="form-group-m"><label class="form-label-m">Nama Barang</label><input type="text" class="form-control-m" name="nama_barang" value="{{ $d->nama_barang }}" required></div>
      <div class="form-group-m"><label class="form-label-m">Nama Penjual</label><input type="text" class="form-control-m" name="nama_penjual" value="{{ $d->nama_penjual }}" placeholder="Nama penjual / pemilik barang..."></div>
      <div class="form-group-m"><label class="form-label-m">Tanggal</label><input type="date" class="form-control-m" style="padding-left:1rem" name="tgl" value="{{ $d->tgl }}" required></div>
      <div class="form-group-m"><label class="form-label-m">Harga Awal (Rp)</label><input type="number" class="form-control-m" style="padding-left:1rem" name="harga_awal" value="{{ $d->harga_awal }}" min="0" required></div>
      <div class="form-group-m"><label class="form-label-m">Deskripsi</label><textarea class="form-control-m" style="padding-left:1rem;resize:vertical;min-height:80px" name="deskripsi_barang">{{ $d->deskripsi_barang }}</textarea></div>
      <div class="form-group-m"><label class="form-label-m">Foto Barang <span style="color:var(--ink-l);font-weight:400">(maks. 3 foto)</span></label>
        <div class="img-upload-grid">
          @for($s=1;$s<=3;$s++)
          @php $ei=$imgs[$s]??null; @endphp
          <div class="img-slot" id="slot-edit-{{ $d->id_barang }}-{{ $s }}">
            <span class="img-slot-badge">Foto {{ $s }}</span>
            @if($ei)<img src="{{ asset('uploads/barang/'.$ei->nama_file) }}" class="img-slot-preview" id="prev-edit-{{ $d->id_barang }}-{{ $s }}"><input type="hidden" name="hapus_gambar_{{ $s }}" value="" id="hps-{{ $d->id_barang }}-{{ $s }}"><button type="button" class="img-slot-remove visible" onclick="removeImg({{ $d->id_barang }},{{ $s }})"><i class="fas fa-times"></i></button>
            @else<img src="" class="img-slot-preview" id="prev-edit-{{ $d->id_barang }}-{{ $s }}" style="display:none"><button type="button" class="img-slot-remove" id="rmbtn-{{ $d->id_barang }}-{{ $s }}" onclick="clearPreview({{ $d->id_barang }},{{ $s }})"><i class="fas fa-times"></i></button>@endif
            <input type="file" name="gambar_{{ $s }}" accept="image/*" onchange="previewImg(this,{{ $d->id_barang }},{{ $s }})">
            <div class="img-slot-placeholder"><i class="fas fa-camera"></i><span>{{ $ei?'Ganti':'Tambah' }}</span></div>
          </div>
          @endfor
        </div>
      </div>
    </div>
    <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-ubah{{ $d->id_barang }}')">Batal</button><button type="submit" class="btn-m btn-primary-m"><i class="fas fa-save"></i> Simpan Perubahan</button></div>
  </form></div>
</div>
@endforeach

<div class="modal-m-overlay modal-tall" id="modal-tambah">
  <div class="modal-m" style="max-width:520px"><div class="modal-m-header"><span class="modal-m-title">Tambah Barang Baru</span><button class="modal-m-close" onclick="closeModal('modal-tambah')">×</button></div>
  <form method="post" action="{{ route('petugas.barang.simpan') }}" enctype="multipart/form-data">@csrf
    <div class="modal-m-body">
      <div class="form-group-m"><label class="form-label-m">Nama Barang</label><input type="text" class="form-control-m" name="nama_barang" placeholder="Nama barang lelang..." required></div>
      <div class="form-group-m"><label class="form-label-m">Nama Penjual</label><input type="text" class="form-control-m" name="nama_penjual" placeholder="Nama penjual / pemilik barang..."></div>
      <div class="form-group-m"><label class="form-label-m">Tanggal</label><input type="date" class="form-control-m" style="padding-left:1rem" name="tgl" required></div>
      <div class="form-group-m"><label class="form-label-m">Harga Awal (Rp)</label><input type="number" class="form-control-m" style="padding-left:1rem" name="harga_awal" placeholder="0" min="0" required></div>
      <div class="form-group-m"><label class="form-label-m">Deskripsi</label><textarea class="form-control-m" style="padding-left:1rem;resize:vertical;min-height:80px" name="deskripsi_barang" placeholder="Deskripsi singkat..."></textarea></div>
      <div class="form-group-m"><label class="form-label-m">Foto Barang <span style="color:var(--ink-l);font-weight:400">(maks. 3 foto)</span></label>
        <div class="img-upload-grid">
          @for($s=1;$s<=3;$s++)
          <div class="img-slot" id="slot-new-{{ $s }}">
            <span class="img-slot-badge">Foto {{ $s }}</span>
            <img src="" class="img-slot-preview" id="prev-new-{{ $s }}" style="display:none">
            <button type="button" class="img-slot-remove" id="rmbtn-new-{{ $s }}" onclick="clearPreviewNew({{ $s }})"><i class="fas fa-times"></i></button>
            <input type="file" name="gambar_{{ $s }}" accept="image/*" onchange="previewImgNew(this,{{ $s }})">
            <div class="img-slot-placeholder"><i class="fas fa-camera"></i><span>Tambah</span></div>
          </div>
          @endfor
        </div>
      </div>
    </div>
    <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-tambah')">Batal</button><button type="submit" class="btn-m btn-primary-m"><i class="fas fa-plus"></i> Tambah Barang</button></div>
  </form></div>
</div>
@endsection
@push('scripts')
<script>
function openModal(id){document.getElementById(id).classList.add('show');document.body.style.overflow='hidden'}
function closeModal(id){document.getElementById(id).classList.remove('show');document.body.style.overflow=''}
document.querySelectorAll('.modal-m-overlay').forEach(o=>o.addEventListener('click',function(e){if(e.target===this)closeModal(this.id)}));
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.querySelectorAll('.modal-m-overlay.show').forEach(m=>closeModal(m.id))});
function previewImgNew(input,slot){if(!input.files[0])return;const r=new FileReader();r.onload=e=>{const p=document.getElementById('prev-new-'+slot);p.src=e.target.result;p.style.display='block';const b=document.getElementById('rmbtn-new-'+slot);if(b)b.classList.add('visible')};r.readAsDataURL(input.files[0])}
function clearPreviewNew(slot){const p=document.getElementById('prev-new-'+slot);p.src='';p.style.display='none';const b=document.getElementById('rmbtn-new-'+slot);if(b)b.classList.remove('visible');const fi=document.getElementById('slot-new-'+slot).querySelector('input[type=file]');if(fi)fi.value=''}
function previewImg(input,bid,slot){if(!input.files[0])return;const r=new FileReader();r.onload=e=>{const p=document.getElementById('prev-edit-'+bid+'-'+slot);p.src=e.target.result;p.style.display='block';const b=document.getElementById('rmbtn-'+bid+'-'+slot);if(b)b.classList.add('visible')};r.readAsDataURL(input.files[0])}
function clearPreview(bid,slot){const p=document.getElementById('prev-edit-'+bid+'-'+slot);p.src='';p.style.display='none';const b=document.getElementById('rmbtn-'+bid+'-'+slot);if(b)b.classList.remove('visible');const h=document.getElementById('hps-'+bid+'-'+slot);if(h)h.value='1';const fi=document.getElementById('slot-edit-'+bid+'-'+slot).querySelector('input[type=file]');if(fi)fi.value=''}
function removeImg(bid,slot){clearPreview(bid,slot)}
</script>
@endpush
