
@extends('layouts.masyarakat')
@push('styles')
<style>
.auction-card-img{width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:10px 10px 0 0;display:block}
.auction-card-img-placeholder{width:100%;aspect-ratio:16/9;background:linear-gradient(135deg,var(--cream-d),var(--cream-dd));display:flex;align-items:center;justify-content:center;border-radius:10px 10px 0 0;font-size:2.5rem}
.gallery-main{width:100%;aspect-ratio:16/9;object-fit:cover;border-radius:10px;margin-bottom:.6rem;cursor:zoom-in}
.gallery-thumbs{display:flex;gap:.5rem;flex-wrap:wrap}
.gallery-thumb{width:60px;height:60px;object-fit:cover;border-radius:7px;cursor:pointer;border:2px solid transparent;opacity:.65;transition:all .2s}
.gallery-thumb:hover,.gallery-thumb.active{border-color:var(--gold);opacity:1}
.lightbox-overlay{position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:none;align-items:center;justify-content:center}
.lightbox-overlay.open{display:flex}
.lightbox-overlay img{max-width:90vw;max-height:90vh;border-radius:8px;object-fit:contain}
.lightbox-close{position:fixed;top:1.2rem;right:1.5rem;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer;z-index:10000}
.timer-badge{display:inline-flex;align-items:center;gap:.35rem;background:#FFF4E5;color:#A85B00;border:1px solid #FFDBA0;border-radius:100px;padding:.25rem .75rem;font-size:.78rem;font-weight:700;font-variant-numeric:tabular-nums}
.timer-badge.urgent{background:#FEF0EE;color:#C0392B;border-color:#F5C2C7;animation:pulse-urgent 1s ease-in-out infinite}
.timer-badge.ended{background:#EDFAF3;color:#1D6A47;border-color:#A8DFC0}
@keyframes pulse-urgent{0%,100%{opacity:1}50%{opacity:.6}}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.3}}
.peserta-row{display:flex;align-items:center;justify-content:space-between;padding:.55rem .75rem;border-radius:var(--rs);background:var(--cream);margin-bottom:.35rem;font-size:.82rem}
.peserta-row:first-child{background:var(--gold-p);border:1px solid var(--gold-ln)}
.peserta-rank{width:22px;height:22px;border-radius:50%;background:var(--cream-d);display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:700;flex-shrink:0;margin-right:.6rem}
.peserta-row:first-child .peserta-rank{background:var(--gold);color:var(--cream)}
</style>
@endpush
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Penawaran Lelang</h1><p class="page-sub">Ikuti lelang aktif dan ajukan penawaran terbaik Anda sebelum waktu habis.</p></div>
</div>

<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()">×</button>
  <img src="" id="lightbox-img" alt="">
</div>

@if(request('info')=='simpan')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Penawaran berhasil dikirim!</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='update')<div class="alert-m alert-success-m fade-up"><i class="fas fa-check-circle alert-m-icon"></i><span>Penawaran berhasil diperbarui.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='hapus')<div class="alert-m alert-warn-m fade-up"><i class="fas fa-exclamation-triangle alert-m-icon"></i><span>Penawaran berhasil dihapus.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='ditutup')<div class="alert-m alert-warn-m fade-up"><i class="fas fa-exclamation-triangle alert-m-icon"></i><span>Lelang sudah ditutup. Penawaran tidak dapat diterima.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif

@if($lelang_aktif->isNotEmpty())
<div class="fade-up delay-1" style="margin-bottom:.75rem">
  <h2 style="font-family:'Playfair Display',serif;font-size:1.15rem;color:var(--ink);display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
    <span style="width:8px;height:8px;border-radius:50%;background:var(--success);animation:blink 2s infinite;display:inline-block"></span>
    Lelang Sedang Berlangsung <span class="badge-m badge-open">{{ $lelang_aktif->count() }} Aktif</span>
  </h2>
</div>
<div class="auction-grid fade-up delay-1">
@foreach($lelang_aktif as $d)
@php $thumb = $d->barang->gambar->first(); @endphp
<div class="auction-card" style="padding:0;overflow:hidden">
  @if($thumb)
    <img src="{{ asset('uploads/barang/'.$thumb->nama_file) }}" class="auction-card-img" onclick="openDetail({{ $d->id_lelang }})" style="cursor:pointer">
  @else
    <div class="auction-card-img-placeholder" onclick="openDetail({{ $d->id_lelang }})" style="cursor:pointer">📦</div>
  @endif
  <div style="padding:1rem">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem">
      <span class="auction-card-lot">Lot #{{ str_pad($d->id_lelang,4,'0',STR_PAD_LEFT) }}</span>
      <span class="badge-m badge-open" style="font-size:.68rem">Live</span>
    </div>
    <div class="auction-card-name">{{ $d->barang->nama_barang }}</div>
    <div class="auction-card-info">
      <div class="auction-card-row"><span class="auction-card-row-label">Harga Awal</span><span class="auction-card-row-val">Rp {{ number_format($d->barang->harga_awal) }}</span></div>
      <div class="auction-card-row"><span class="auction-card-row-label">Penawaran</span><span class="auction-card-row-val">{{ $d->jumlah_penawar }} penawar</span></div>
      @if($d->penawaran_tertinggi)
      <div class="auction-card-row" style="margin-top:.25rem;padding-top:.5rem;border-top:1px solid var(--gold-ln2)">
        <span class="auction-card-row-label" style="font-weight:600;color:var(--success)">Tertinggi</span>
        <span class="auction-card-price">Rp {{ number_format($d->penawaran_tertinggi) }}</span>
      </div>
      @endif
    </div>
    @if($d->timer_end)
    <div style="margin-top:.6rem">
      <span class="timer-badge" id="timer-card-{{ $d->id_lelang }}" data-end="{{ $d->timer_end->timestamp * 1000 }}">
        <i class="fas fa-clock"></i> <span class="timer-val">--:--</span>
      </span>
    </div>
    @endif
  </div>
  <div class="auction-card-footer" style="padding:.75rem 1rem">
    <div style="display:flex;gap:.5rem">
      <button class="btn-m btn-outline-m" style="flex:1;padding:.6rem" onclick="openDetail({{ $d->id_lelang }})"><i class="fas fa-eye"></i> Detail</button>
      <button class="btn-m btn-primary-m" style="flex:2" id="btn-tawar-{{ $d->id_lelang }}" onclick="openModal('modal-tawar{{ $d->id_lelang }}')"><i class="fas fa-gavel"></i> Tawar</button>
    </div>
  </div>
</div>
@endforeach
</div>

{{-- Modals outside grid --}}
@foreach($lelang_aktif as $d)
@php $gambar_arr = $d->barang->gambar; @endphp

<div class="modal-m-overlay" id="modal-detail{{ $d->id_lelang }}" style="z-index:1100">
  <div class="modal-m" style="max-width:580px">
    <div class="modal-m-header"><span class="modal-m-title">📦 Detail Barang Lelang</span><button class="modal-m-close" onclick="closeModal('modal-detail{{ $d->id_lelang }}')">×</button></div>
    <div class="modal-m-body">
      @if($gambar_arr->isNotEmpty())
      <div style="margin-bottom:1rem">
        <img src="{{ asset('uploads/barang/'.$gambar_arr->first()->nama_file) }}" class="gallery-main" id="gallery-main-{{ $d->id_lelang }}" onclick="openLightbox(this.src)" alt="">
        @if($gambar_arr->count()>1)
        <div class="gallery-thumbs">
          @foreach($gambar_arr as $gi=>$g)
          <img src="{{ asset('uploads/barang/'.$g->nama_file) }}" class="gallery-thumb {{ $gi==0?'active':'' }}" onclick="switchGallery(this,'gallery-main-{{ $d->id_lelang }}')" alt="">
          @endforeach
        </div>
        @endif
      </div>
      @else
      <div style="width:100%;aspect-ratio:16/9;background:var(--cream-d);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:3rem;margin-bottom:1rem">📦</div>
      @endif

      <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:1rem;margin-bottom:1rem">
        <div style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:.6rem">
          {{ $d->barang->nama_barang }}
          <span style="font-size:.75rem;font-weight:400;font-family:inherit;color:var(--ink-m);margin-left:.5rem">Lot #{{ str_pad($d->id_lelang,4,'0',STR_PAD_LEFT) }}</span>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;font-size:.83rem">
          <div><span style="color:var(--ink-m)">Harga Awal</span><br><strong>Rp {{ number_format($d->barang->harga_awal) }}</strong></div>
          <div><span style="color:var(--ink-m)">Penawaran Tertinggi</span><br><strong style="color:var(--success)">{{ $d->penawaran_tertinggi ? 'Rp '.number_format($d->penawaran_tertinggi) : '—' }}</strong></div>
          <div><span style="color:var(--ink-m)">Total Penawar</span><br><strong>{{ $d->jumlah_penawar }} orang</strong></div>
          <div><span style="color:var(--ink-m)">Sisa Waktu</span><br>
            @if($d->timer_end)<span class="timer-badge" id="timer-modal-{{ $d->id_lelang }}" data-end="{{ $d->timer_end->timestamp * 1000 }}"><i class="fas fa-clock"></i> <span class="timer-val">--:--</span></span>
            @else<strong>—</strong>@endif
          </div>
        </div>
        @if($d->barang->deskripsi_barang)
        <div style="margin-top:.75rem;padding-top:.75rem;border-top:1px solid var(--gold-ln);font-size:.83rem;color:var(--ink-s);line-height:1.6">
          <span style="color:var(--ink-m);display:block;margin-bottom:.2rem">Deskripsi</span>
          {{ $d->barang->deskripsi_barang }}
        </div>
        @endif
      </div>

      {{-- Peserta list --}}
      @if($d->peserta->isNotEmpty())
      <div style="margin-bottom:.5rem">
        <div style="font-size:.8rem;font-weight:600;color:var(--ink-s);margin-bottom:.5rem"><i class="fas fa-users" style="color:var(--gold);margin-right:.35rem"></i> Daftar Penawar ({{ $d->peserta->count() }} peserta)</div>
        @foreach($d->peserta as $pi=>$p)
        <div class="peserta-row">
          <div style="display:flex;align-items:center">
            <div class="peserta-rank">{{ $pi+1 }}</div>
            <span style="font-weight:{{ $pi==0?'600':'400' }};color:var(--ink)">{{ $p->nama_lengkap }}</span>
            @if($pi==0)<span style="font-size:.65rem;background:var(--gold);color:var(--cream);padding:.1rem .4rem;border-radius:100px;margin-left:.4rem;font-weight:700">Tertinggi</span>@endif
          </div>
          <span style="font-weight:600;color:{{ $pi==0?'var(--success)':'var(--ink)' }}">Rp {{ number_format($p->penawaran_harga) }}</span>
        </div>
        @endforeach
      </div>
      @else
      <div style="text-align:center;padding:1rem;color:var(--ink-m);font-size:.82rem;background:var(--cream);border-radius:var(--rs)"><i class="fas fa-gavel" style="opacity:.3;margin-right:.4rem"></i>Belum ada penawaran</div>
      @endif
    </div>
    <div class="modal-m-footer">
      <button class="btn-m btn-outline-m" onclick="closeModal('modal-detail{{ $d->id_lelang }}')">Tutup</button>
      <button class="btn-m btn-gold-m" id="btn-detail-tawar-{{ $d->id_lelang }}" onclick="closeModal('modal-detail{{ $d->id_lelang }}');openModal('modal-tawar{{ $d->id_lelang }}')"><i class="fas fa-gavel"></i> Ajukan Penawaran</button>
    </div>
  </div>
</div>

<div class="modal-m-overlay" id="modal-tawar{{ $d->id_lelang }}" style="z-index:1100">
  <div class="modal-m">
    <div class="modal-m-header"><span class="modal-m-title">Ajukan Penawaran</span><button class="modal-m-close" onclick="closeModal('modal-tawar{{ $d->id_lelang }}')">×</button></div>
    <form method="post" action="{{ route('masyarakat.penawaran.simpan') }}">
      @csrf
      <div class="modal-m-body">
        <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:1rem;margin-bottom:1.25rem">
          <div style="font-size:.8rem;color:var(--ink-m);margin-bottom:.2rem">Barang</div>
          <div style="font-weight:700;color:var(--ink);font-family:'Playfair Display',serif">{{ $d->barang->nama_barang }}</div>
          <div style="margin-top:.5rem;display:flex;justify-content:space-between;font-size:.8rem;flex-wrap:wrap;gap:.25rem">
            <span style="color:var(--ink-m)">Harga Awal: <strong>Rp {{ number_format($d->barang->harga_awal) }}</strong></span>
            @if($d->penawaran_tertinggi)<span style="color:var(--success)">Tertinggi: <strong>Rp {{ number_format($d->penawaran_tertinggi) }}</strong></span>@endif
          </div>
          @if($d->timer_end)
          <div style="margin-top:.5rem"><span class="timer-badge" id="timer-tawar-{{ $d->id_lelang }}" data-end="{{ $d->timer_end->timestamp * 1000 }}"><i class="fas fa-clock"></i> <span class="timer-val">--:--</span></span></div>
          @endif
        </div>
        <input type="hidden" name="id_lelang" value="{{ $d->id_lelang }}">
        <input type="hidden" name="id_barang" value="{{ $d->id_barang }}">
        <input type="hidden" name="id_user" value="{{ $mas->id_user ?? '' }}">
        <div class="form-group-m">
          <label class="form-label-m">Nominal Penawaran (Rp)</label>
          <input type="number" class="form-control-m" style="padding-left:1rem;font-size:1.1rem;font-weight:600"
                 name="penawaran_harga" placeholder="Masukkan jumlah tawaran..."
                 min="{{ ($d->penawaran_tertinggi ?? $d->barang->harga_awal) + 1 }}" required>
          <div style="font-size:.72rem;color:var(--ink-l);margin-top:.3rem">
            Minimal: Rp {{ number_format(($d->penawaran_tertinggi ?? $d->barang->harga_awal) + 1) }}
          </div>
        </div>
      </div>
      <div class="modal-m-footer">
        <button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-tawar{{ $d->id_lelang }}')">Batal</button>
        <button type="submit" class="btn-m btn-gold-m"><i class="fas fa-gavel"></i> Kirim Penawaran</button>
      </div>
    </form>
  </div>
</div>
@endforeach

@else
<div class="card-m fade-up delay-1" style="margin-bottom:2rem">
  <div class="card-m-body"><div class="empty-state"><div class="empty-icon">🔍</div><h4>Tidak Ada Lelang Aktif</h4><p>Saat ini tidak ada lelang yang sedang berlangsung. Pantau terus untuk lelang berikutnya!</p></div></div>
</div>
@endif

{{-- History table --}}
<div class="card-m fade-up delay-2">
  <div class="card-m-header"><div class="card-m-title"><span>📋</span> Riwayat Penawaran Saya</div></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Barang</th><th>Harga Awal</th><th>Penawaran Saya</th><th>Hasil</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($history as $i=>$h)
        <tr>
          <td style="color:var(--ink-l)">{{ $i+1 }}</td>
          <td><strong style="color:var(--ink)">{{ $h->barang->nama_barang }}</strong></td>
          <td style="color:var(--ink-m)">Rp {{ number_format($h->barang->harga_awal) }}</td>
          <td style="font-weight:600;color:var(--ink)">Rp {{ number_format($h->penawaran_harga) }}</td>
          <td>
            @if($h->penawaran_harga == $h->lelang->harga_akhir && $h->lelang->harga_akhir > 0)
              <span class="win-badge">🏆 Pemenang!</span>
            @elseif($h->lelang->status == 'ditutup')
              <span class="badge-m badge-closed">Kalah</span>
            @else
              <span class="badge-m badge-open">Berlangsung</span>
            @endif
          </td>
          <td>
            @if($h->lelang->status == 'dibuka')
            <div style="display:flex;gap:.4rem">
              <button class="btn-m btn-warn-m btn-sm-m" onclick="openModal('modal-ubah{{ $h->id_history }}')"><i class="fas fa-edit"></i> Edit</button>
              <button class="btn-m btn-danger-m btn-sm-m" onclick="openModal('modal-hapus{{ $h->id_history }}')"><i class="fas fa-trash"></i></button>
            </div>
            @else<span style="color:var(--ink-l);font-size:.78rem">—</span>@endif
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--ink-m)"><div style="font-size:2rem;opacity:.25;margin-bottom:.5rem">📋</div>Anda belum memiliki riwayat penawaran.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Edit/Hapus modals for history (outside table) --}}
@foreach($history as $h)
@if($h->lelang->status == 'dibuka')
<div class="modal-m-overlay" id="modal-ubah{{ $h->id_history }}">
  <div class="modal-m">
    <div class="modal-m-header"><span class="modal-m-title">Edit Penawaran</span><button class="modal-m-close" onclick="closeModal('modal-ubah{{ $h->id_history }}')">×</button></div>
    <form method="post" action="{{ route('masyarakat.penawaran.update') }}">
      @csrf
      <div class="modal-m-body">
        <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:.85rem;margin-bottom:1rem;font-size:.83rem">Barang: <strong>{{ $h->barang->nama_barang }}</strong></div>
        <input type="hidden" name="id_history" value="{{ $h->id_history }}">
        <div class="form-group-m">
          <label class="form-label-m">Penawaran Baru (Rp)</label>
          <input type="number" class="form-control-m" style="padding-left:1rem" name="penawaran_harga" value="{{ $h->penawaran_harga }}" required>
        </div>
      </div>
      <div class="modal-m-footer">
        <button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-ubah{{ $h->id_history }}')">Batal</button>
        <button type="submit" class="btn-m btn-primary-m"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<div class="modal-m-overlay" id="modal-hapus{{ $h->id_history }}">
  <div class="modal-m">
    <div class="modal-m-header"><span class="modal-m-title">Hapus Penawaran</span><button class="modal-m-close" onclick="closeModal('modal-hapus{{ $h->id_history }}')">×</button></div>
    <div class="modal-m-body" style="text-align:center;padding:1.5rem"><div style="font-size:2.5rem;margin-bottom:.75rem">🗑️</div><p style="font-size:.9rem;color:var(--ink-s)">Hapus penawaran untuk <strong>{{ $h->barang->nama_barang }}</strong>?</p></div>
    <div class="modal-m-footer">
      <button class="btn-m btn-outline-m" onclick="closeModal('modal-hapus{{ $h->id_history }}')">Batal</button>
      <a href="{{ route('masyarakat.penawaran.hapus', ['id_history'=>$h->id_history]) }}" class="btn-m btn-danger-m">Ya, Hapus</a>
    </div>
  </div>
</div>
@endif
@endforeach

@endsection
@push('scripts')
<script>
function openModal(id){document.getElementById(id).classList.add('show');document.body.style.overflow='hidden'}
function closeModal(id){document.getElementById(id).classList.remove('show');if(!document.querySelector('.modal-m-overlay.show'))document.body.style.overflow=''}
function closeAllModals(){document.querySelectorAll('.modal-m-overlay.show').forEach(m=>m.classList.remove('show'));document.body.style.overflow=''}
function openDetail(id){closeAllModals();openModal('modal-detail'+id)}
document.querySelectorAll('.modal-m-overlay').forEach(o=>o.addEventListener('click',function(e){if(e.target===this)closeModal(this.id)}));
document.addEventListener('keydown',e=>{if(e.key==='Escape'){document.querySelectorAll('.modal-m-overlay.show').forEach(m=>closeModal(m.id));closeLightbox()}});
function switchGallery(thumb,mainId){const main=document.getElementById(mainId);if(!main)return;main.src=thumb.src;thumb.closest('.gallery-thumbs').querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('active'));thumb.classList.add('active')}
function openLightbox(src){document.getElementById('lightbox-img').src=src;document.getElementById('lightbox').classList.add('open');document.body.style.overflow='hidden'}
function closeLightbox(){document.getElementById('lightbox').classList.remove('open');document.body.style.overflow=''}

// Countdown timers
function updateTimers(){
  document.querySelectorAll('.timer-badge[data-end]').forEach(function(el){
    const end = parseInt(el.dataset.end);
    const now = Date.now();
    const diff = Math.max(0, Math.floor((end - now) / 1000));
    const m = Math.floor(diff / 60);
    const s = diff % 60;
    const val = el.querySelector('.timer-val');
    if(val) val.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    el.classList.remove('urgent','ended');
    if(diff === 0){
      el.classList.add('ended'); if(val) val.textContent = 'Selesai';
      // Disable bid buttons for this auction
      const id = el.id.replace('timer-card-','').replace('timer-modal-','').replace('timer-tawar-','');
      ['btn-tawar-','btn-detail-tawar-'].forEach(function(pfx){
        const b=document.getElementById(pfx+id);
        if(b){b.disabled=true;b.style.opacity='.4';b.style.cursor='not-allowed';b.onclick=null;b.title='Lelang telah berakhir';}
      });
      // Auto-close via server
      fetch('/check-timer').catch(function(){});
    }
    else if(diff <= 60){ el.classList.add('urgent'); }
  });
}
updateTimers();
setInterval(updateTimers, 1000);

// Poll timer check every 10s to auto-close expired auctions
setInterval(function(){
  fetch('/petugas/check-timer').catch(()=>{});
}, 10000);
</script>
@endpush
