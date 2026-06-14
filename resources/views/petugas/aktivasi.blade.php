
@extends('layouts.petugas')
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Aktivasi Lelang</h1><p class="page-sub">Kelola sesi lelang — buka dan tutup lelang, pantau pemenang secara real-time.</p></div>
  <button class="btn-m btn-primary-m" onclick="openModal('modal-tambah')"><i class="fas fa-plus"></i> Tambah Lelang</button>
</div>

@if(request('info')=='simpan')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Data lelang berhasil ditambahkan.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='update')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Status lelang berhasil diperbarui.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif

<div class="card-m fade-up delay-1">
  <div class="card-m-header"><div class="card-m-title"><i class="bi bi-lightning-charge"></i> Daftar Sesi Lelang</div></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Barang</th><th>Tgl Lelang</th><th>Penawaran Tertinggi</th><th>Pemenang</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($rows_lelang as $i=>$d)
        <tr>
          <td style="color:var(--ink-l);font-size:.8rem">{{ $i+1 }}</td>
          <td><strong style="color:var(--ink)">{{ $d->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
          <td style="color:var(--ink-m)">{{ $d->tgl_lelang ?? '—' }}</td>
          <td style="font-weight:600;color:var(--success)">@if($d->_harga_tertinggi)Rp {{ number_format($d->_harga_tertinggi, 0, ',', '.') }}@else<span style="color:var(--ink-l)">Belum ada</span>@endif</td>
          <td>
            @if($d->status=='dibuka')<span style="color:var(--ink-l);font-size:.8rem">— (Berlangsung)</span>
            @elseif($d->_pemenang)<span style="font-size:.82rem;color:var(--ink-s);font-weight:500"><i class="bi bi-trophy"></i> {{ $d->_pemenang }}</span>
            @else<span style="color:var(--ink-l);font-size:.8rem">Tidak ada pemenang</span>@endif
          </td>
          <td>
            @if($d->status=='dibuka')<span class="badge-m badge-open"><i class="fas fa-circle" style="font-size:.45rem"></i> Dibuka</span>
            @elseif($d->status=='ditutup')<span class="badge-m badge-closed">Ditutup</span>
            @else<span class="badge-m badge-pending">Belum Aktif</span>@endif
          </td>
          <td>
            <div style="display:flex;gap:.4rem;flex-wrap:wrap">
              <button class="btn-m btn-success-m btn-sm-m" onclick="openModal('modal-buka{{ $d->id_lelang }}')"><i class="fas fa-play"></i> Buka</button>
              <button class="btn-m btn-danger-m btn-sm-m" onclick="openModal('modal-tutup{{ $d->id_lelang }}')"><i class="fas fa-stop"></i> Tutup</button>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--ink-m)"><div style="font-size:2rem;opacity:.25;margin-bottom:.5rem"><i class="bi bi-lightning-charge"></i></div>Belum ada sesi lelang</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@foreach($rows_lelang as $d)
<div class="modal-m-overlay" id="modal-buka{{ $d->id_lelang }}">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Buka Sesi Lelang</span><button class="modal-m-close" onclick="closeModal('modal-buka{{ $d->id_lelang }}')">×</button></div>
  <div class="modal-m-body" style="text-align:center;padding:1.5rem"><div style="font-size:2.5rem;margin-bottom:.75rem"><i class="bi bi-unlock"></i></div><p style="font-size:.9rem;color:var(--ink-s)">Buka sesi lelang untuk barang <strong>{{ $d->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong>?</p></div>
  <form method="post" action="{{ route('petugas.aktivasi.buka') }}">@csrf<input type="hidden" name="id_lelang" value="{{ $d->id_lelang }}">
  <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-buka{{ $d->id_lelang }}')">Batal</button><button type="submit" class="btn-m btn-success-m"><i class="fas fa-play"></i> Ya, Buka Lelang</button></div>
  </form></div>
</div>
<div class="modal-m-overlay" id="modal-tutup{{ $d->id_lelang }}">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Tutup Sesi Lelang</span><button class="modal-m-close" onclick="closeModal('modal-tutup{{ $d->id_lelang }}')">×</button></div>
  <div class="modal-m-body" style="text-align:center;padding:1.5rem">
    <div style="font-size:2.5rem;margin-bottom:.75rem"><i class="bi bi-lock"></i></div>
    <p style="font-size:.9rem;color:var(--ink-s)">Tutup sesi lelang <strong>{{ $d->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong>? Pemenang ditetapkan berdasarkan penawaran tertinggi.</p>
    @if($d->_pemenang)<div style="margin-top:1rem;background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:.85rem;font-size:.85rem;color:var(--ink-s)"><i class="bi bi-trophy" style="color:var(--gold)"></i> Pemenang saat ini: <strong>{{ $d->_pemenang }}</strong> — <strong>Rp {{ number_format($d->_harga_tertinggi, 0, ',', '.') }}</strong></div>@endif
  </div>
  <form method="post" action="{{ route('petugas.aktivasi.tutup') }}">@csrf
    <input type="hidden" name="id_lelang" value="{{ $d->id_lelang }}">
    <input type="hidden" name="id_user" value="{{ $d->_id_user_pw }}">
    <input type="hidden" name="harga_akhir" value="{{ $d->_harga_tertinggi }}">
    <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-tutup{{ $d->id_lelang }}')">Batal</button><button type="submit" class="btn-m btn-danger-m"><i class="fas fa-stop"></i> Ya, Tutup Lelang</button></div>
  </form></div>
</div>
@endforeach

<div class="card-m fade-up delay-2">
  <div class="card-m-header"><div class="card-m-title"><i class="bi bi-broadcast"></i> Penawaran Real-Time <span style="font-size:.7rem;font-weight:400;color:var(--gold);margin-left:.5rem;animation:blink 2s infinite">● LIVE</span></div></div>
  <div id="realtime-div" style="padding:.5rem 0">
    @include('petugas.isi')
  </div>
</div>

<div class="modal-m-overlay" id="modal-tambah">
  <div class="modal-m"><div class="modal-m-header"><span class="modal-m-title">Tambah Sesi Lelang</span><button class="modal-m-close" onclick="closeModal('modal-tambah')">×</button></div>
  <form method="post" action="{{ route('petugas.aktivasi.simpan') }}">@csrf
    <div class="modal-m-body">
      <div class="form-group-m"><label class="form-label-m">Pilih Barang</label>
        <select name="id_barang" class="form-control-m" style="padding-left:1rem" required>
          <option value="" disabled selected>— Pilih Barang —</option>
          @foreach($barang_list as $b)<option value="{{ $b->id_barang }}">{{ $b->nama_barang }} — Rp {{ number_format($b->harga_awal, 0, ',', '.') }}</option>@endforeach
        </select>
      </div>
      <input type="hidden" name="id_petugas" value="{{ $petugas_session->id_petugas ?? '' }}">
    </div>
    <div class="modal-m-footer"><button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-tambah')">Batal</button><button type="submit" class="btn-m btn-primary-m"><i class="fas fa-plus"></i> Buat Sesi Lelang</button></div>
  </form></div>
</div>

<style>@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}</style>
@endsection
@push('scripts')
<script>
function openModal(id){document.getElementById(id).classList.add('show');document.body.style.overflow='hidden'}
function closeModal(id){document.getElementById(id).classList.remove('show');document.body.style.overflow=''}
document.querySelectorAll('.modal-m-overlay').forEach(o=>o.addEventListener('click',function(e){if(e.target===this)closeModal(this.id)}));
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.querySelectorAll('.modal-m-overlay.show').forEach(m=>closeModal(m.id))});
setInterval(function(){fetch('{{ route("petugas.isi") }}').then(r=>r.text()).then(html=>{document.getElementById('realtime-div').innerHTML=html})},3000);
</script>
@endpush
