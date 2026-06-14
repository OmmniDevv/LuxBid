
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
@if(request('info')=='min_bid')<div class="alert-m alert-warn-m fade-up"><i class="fas fa-exclamation-triangle alert-m-icon"></i><span>Penawaran ditolak. Minimal penambahan adalah Rp 1.000 dari penawaran tertinggi saat ini.</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif
@if(request('info')=='max_bid')<div class="alert-m alert-warn-m fade-up"><i class="fas fa-exclamation-triangle alert-m-icon"></i><span>{{ session('error_message') }}</span><button class="alert-close" onclick="this.closest('.alert-m').remove()">×</button></div>@endif

{{-- Search & Filter Form --}}
<div class="card-m fade-up delay-1" style="margin-bottom:1.25rem">
  <div class="card-m-body">
    <form method="GET" action="{{ route('masyarakat.penawaran') }}">
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:.75rem;align-items:end;flex-wrap:wrap">
        <div>
          <label class="form-label-m" style="font-size:.78rem">Cari Barang</label>
          <input type="text" name="search" class="form-control-m" placeholder="Nama barang..." value="{{ $search ?? '' }}">
        </div>
        <div>
          <label class="form-label-m" style="font-size:.78rem">Kategori</label>
          <select name="kategori" class="form-control-m" style="padding-left:1rem">
            <option value="">Semua Kategori</option>
            @foreach($tb_kategori as $k)
              <option value="{{ $k->id_kategori }}" {{ ($kategori ?? '') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="form-label-m" style="font-size:.78rem">Harga Min (Rp)</label>
          <input type="number" name="harga_min" class="form-control-m" placeholder="0" value="{{ $harga_min ?? '' }}" min="0">
        </div>
        <div>
          <label class="form-label-m" style="font-size:.78rem">Harga Maks (Rp)</label>
          <input type="number" name="harga_max" class="form-control-m" placeholder="Tak terbatas" value="{{ $harga_max ?? '' }}" min="0">
        </div>
        <div style="display:flex;gap:.5rem">
          <button type="submit" class="btn-m btn-primary-m" style="white-space:nowrap"><i class="fas fa-search"></i> Cari</button>
          <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-outline-m" style="white-space:nowrap">Reset</a>
        </div>
      </div>
    </form>
  </div>
</div>

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
    <img src="{{ asset('storage/barang/'.$thumb->nama_file) }}" class="auction-card-img" onclick="openDetail({{ $d->id_lelang }})" style="cursor:pointer">
  @else
    <div class="auction-card-img-placeholder" onclick="openDetail({{ $d->id_lelang }})" style="cursor:pointer"><i class="bi bi-box-seam"></i></div>
  @endif
  <div style="padding:1rem">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem">
      <span class="auction-card-lot">Lot #{{ str_pad($d->id_lelang,4,'0',STR_PAD_LEFT) }}</span>
      <span class="badge-m badge-open" style="font-size:.68rem">Live</span>
    </div>
    <div class="auction-card-name">{{ $d->barang->nama_barang }}</div>
    @if($d->barang->kategori)<div style="margin-bottom:.35rem"><span class="badge-m" style="background:var(--gold-p);color:var(--ink-s);font-size:.68rem;padding:.15rem .5rem">{{ $d->barang->kategori->nama_kategori }}</span></div>@endif
    <div class="auction-card-info">
      <div class="auction-card-row"><span class="auction-card-row-label">Harga Awal</span><span class="auction-card-row-val">Rp {{ number_format($d->barang->harga_awal, 0, ',', '.') }}</span></div>
      <div class="auction-card-row"><span class="auction-card-row-label">Penawaran</span><span class="auction-card-row-val">{{ $d->jumlah_penawar }} penawar</span></div>
      @if($d->penawaran_tertinggi)
      <div class="auction-card-row" style="margin-top:.25rem;padding-top:.5rem;border-top:1px solid var(--gold-ln2)">
        <span class="auction-card-row-label" style="font-weight:600;color:var(--success)">Tertinggi</span>
        <span class="auction-card-price">Rp {{ number_format($d->penawaran_tertinggi, 0, ',', '.') }}</span>
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
      <form method="POST" action="{{ route('masyarakat.wishlist.toggle', $d->barang->id_barang) }}" style="display:inline">
        @csrf
        <button type="submit" class="btn-m" style="padding:.6rem .75rem;background:{{ in_array($d->barang->id_barang, $wishlist_ids) ? 'var(--gold)' : 'var(--surface-2)' }};color:{{ in_array($d->barang->id_barang, $wishlist_ids) ? 'var(--ink)' : 'var(--ink-m)' }};border:1px solid var(--border)" title="{{ in_array($d->barang->id_barang, $wishlist_ids) ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
          <i class="{{ in_array($d->barang->id_barang, $wishlist_ids) ? 'fas' : 'far' }} fa-heart"></i>
        </button>
      </form>
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
    <div class="modal-m-header"><span class="modal-m-title"><i class="bi bi-box-seam"></i> Detail Barang Lelang</span><button class="modal-m-close" onclick="closeModal('modal-detail{{ $d->id_lelang }}')">×</button></div>
    <div class="modal-m-body">
      @if($gambar_arr->isNotEmpty())
      <div style="margin-bottom:1rem">
        <img src="{{ asset('storage/barang/'.$gambar_arr->first()->nama_file) }}" class="gallery-main" id="gallery-main-{{ $d->id_lelang }}" onclick="openLightbox(this.src)" alt="">
        @if($gambar_arr->count()>1)
        <div class="gallery-thumbs">
          @foreach($gambar_arr as $gi=>$g)
          <img src="{{ asset('storage/barang/'.$g->nama_file) }}" class="gallery-thumb {{ $gi==0?'active':'' }}" onclick="switchGallery(this,'gallery-main-{{ $d->id_lelang }}')" alt="">
          @endforeach
        </div>
        @endif
      </div>
      @else
      <div style="width:100%;aspect-ratio:16/9;background:var(--cream-d);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:3rem;margin-bottom:1rem"><i class="bi bi-box-seam"></i></div>
      @endif

      <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:1rem;margin-bottom:1rem">
        <div style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:.6rem">
          {{ $d->barang->nama_barang }}
          <span style="font-size:.75rem;font-weight:400;font-family:inherit;color:var(--ink-m);margin-left:.5rem">Lot #{{ str_pad($d->id_lelang,4,'0',STR_PAD_LEFT) }}</span>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;font-size:.83rem">
          <div><span style="color:var(--ink-m)">Harga Awal</span><br><strong>Rp {{ number_format($d->barang->harga_awal, 0, ',', '.') }}</strong></div>
          <div><span style="color:var(--ink-m)">Penawaran Tertinggi</span><br><strong style="color:var(--success)">{{ $d->penawaran_tertinggi ? 'Rp '.number_format($d->penawaran_tertinggi, 0, ',', '.') : '—' }}</strong></div>
          <div><span style="color:var(--ink-m)">Total Penawar</span><br><strong>{{ $d->jumlah_penawar }} orang</strong></div>
          <div><span style="color:var(--ink-m)">Sisa Waktu</span><br>
            @if($d->timer_end)<span class="timer-badge" id="timer-modal-{{ $d->id_lelang }}" data-end="{{ $d->timer_end->timestamp * 1000 }}"><i class="fas fa-clock"></i> <span class="timer-val">--:--</span></span>
            @else<strong>—</strong>@endif
          </div>
          @if($d->barang->nama_penjual)
          <div style="grid-column:span 2"><span style="color:var(--ink-m)">Penjual</span><br><strong>{{ $d->barang->nama_penjual }}</strong></div>
          @endif
        </div>
        @if($d->barang->deskripsi_barang)
        <div style="margin-top:.75rem;padding-top:.75rem;border-top:1px solid var(--gold-ln);font-size:.83rem;color:var(--ink-s);line-height:1.6">
          <span style="color:var(--ink-m);display:block;margin-bottom:.2rem">Deskripsi</span>
          {{ $d->barang->deskripsi_barang }}
        </div>
        @endif
      </div>

      {{-- Rating & Review --}}
      @php
        $ratings = $d->barang->ratings;
        $avg_rating = $ratings->isNotEmpty() ? round($ratings->avg('rating'), 1) : 0;
        $total_ratings = $ratings->count();
      @endphp
      @if($total_ratings > 0)
      <div style="margin-bottom:1rem">
        <div style="font-size:.8rem;font-weight:600;color:var(--ink-s);margin-bottom:.5rem">
          <i class="fas fa-star" style="color:var(--gold);margin-right:.35rem"></i>
          Rating & Review ({{ $total_ratings }} review{{ $total_ratings > 1 ? 's' : '' }})
        </div>
        <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:8px;padding:1rem;margin-bottom:.75rem">
          <div style="display:flex;align-items:center;gap:1rem;margin-bottom:.75rem">
            <div style="text-align:center">
              <div style="font-size:2rem;font-weight:700;color:var(--gold)">{{ $avg_rating }}</div>
              <div style="font-size:.7rem;color:var(--ink-m)">dari 5</div>
            </div>
            <div style="flex:1">
              <div style="display:flex;gap:.2rem;margin-bottom:.25rem">
                @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star" style="color:{{ $i <= $avg_rating ? '#c9a84c' : '#ddd' }};font-size:1rem"></i>
                @endfor
              </div>
              <div style="font-size:.75rem;color:var(--ink-m)">Berdasarkan {{ $total_ratings }} lelang selesai</div>
            </div>
          </div>
        </div>
        <div style="max-height:300px;overflow-y:auto">
          @foreach($ratings->sortByDesc('created_at') as $r)
          <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.75rem;margin-bottom:.5rem">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.4rem">
              <div style="display:flex;align-items:center;gap:.5rem">
                <span style="font-weight:600;color:var(--ink);font-size:.85rem">{{ $r->masyarakat->nama_lengkap ?? 'User' }}</span>
                <div style="display:flex;gap:.1rem">
                  @for($i = 1; $i <= 5; $i++)
                  <i class="fas fa-star" style="color:{{ $i <= $r->rating ? '#c9a84c' : '#ddd' }};font-size:.75rem"></i>
                  @endfor
                </div>
              </div>
              @if($r->created_at)
              <span style="font-size:.7rem;color:var(--ink-l)">{{ $r->created_at->format('d/m/Y') }}</span>
              @endif
            </div>
            @if($r->komentar)
            <div style="font-size:.8rem;color:var(--ink-s);line-height:1.5">{{ $r->komentar }}</div>
            @endif
          </div>
          @endforeach
        </div>
      </div>
      @endif

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
          <span style="font-weight:600;color:{{ $pi==0?'var(--success)':'var(--ink)' }}">Rp {{ number_format($p->penawaran_harga, 0, ',', '.') }}</span>
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
            <span style="color:var(--ink-m)">Harga Awal: <strong>Rp {{ number_format($d->barang->harga_awal, 0, ',', '.') }}</strong></span>
            @if($d->penawaran_tertinggi)<span style="color:var(--success)">Tertinggi: <strong>Rp {{ number_format($d->penawaran_tertinggi, 0, ',', '.') }}</strong></span>@endif
          </div>
          @if($d->timer_end)
          <div style="margin-top:.5rem"><span class="timer-badge" id="timer-tawar-{{ $d->id_lelang }}" data-end="{{ $d->timer_end->timestamp * 1000 }}"><i class="fas fa-clock"></i> <span class="timer-val">--:--</span></span></div>
          @endif
        </div>
        <input type="hidden" name="id_lelang" value="{{ $d->id_lelang }}">
        <input type="hidden" name="id_barang" value="{{ $d->id_barang }}">
        <input type="hidden" name="id_user" value="{{ $mas->id_user ?? '' }}">
        <input type="hidden" name="penawaran_harga" id="penawaran_harga_raw_{{ $d->id_lelang }}">
        <div class="form-group-m">
          <label class="form-label-m">Nominal Penawaran (Rp)</label>
          <input type="text" class="form-control-m bid-input" style="padding-left:1rem;font-size:1.1rem;font-weight:600"
                 id="penawaran_harga_display_{{ $d->id_lelang }}"
                 data-raw-id="penawaran_harga_raw_{{ $d->id_lelang }}"
                 data-harga-awal="{{ $d->barang->harga_awal }}"
                 data-max-bid="{{ $d->barang->harga_awal * 20 }}"
                 data-submit-btn="submit-btn-{{ $d->id_lelang }}"
                 placeholder="Masukkan jumlah tawaran..." required>
          <div style="font-size:.72rem;color:var(--ink-l);margin-top:.3rem">
            Minimal: Rp {{ number_format(($d->penawaran_tertinggi ?? $d->barang->harga_awal) + 1000, 0, ',', '.') }} (penambahan min. Rp 1.000)
          </div>
          <div id="warning-{{ $d->id_lelang }}" style="display:none;font-size:.75rem;color:#C0392B;background:#FEF0EE;border:1px solid #F5C2C7;border-radius:6px;padding:.5rem .75rem;margin-top:.5rem">
            <i class="fas fa-exclamation-triangle"></i> <span class="warning-text"></span>
          </div>
        </div>
      </div>
      <div class="modal-m-footer">
        <button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-tawar{{ $d->id_lelang }}')">Batal</button>
        <button type="submit" class="btn-m btn-gold-m" id="submit-btn-{{ $d->id_lelang }}"><i class="fas fa-gavel"></i> Kirim Penawaran</button>
      </div>
    </form>
  </div>
</div>
@endforeach

@else
<div class="card-m fade-up delay-1" style="margin-bottom:2rem">
  <div class="card-m-body"><div class="empty-state"><div class="empty-icon"><i class="bi bi-search"></i></div><h4>Tidak Ada Lelang Ditemukan</h4><p>{{ ($search || $harga_min || $harga_max || $kategori) ? 'Tidak ada lelang yang cocok dengan filter Anda. Coba ubah kriteria pencarian.' : 'Saat ini tidak ada lelang yang sedang berlangsung. Pantau terus untuk lelang berikutnya!' }}</p>@if($search || $harga_min || $harga_max || $kategori)<a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-outline-m" style="margin-top:.75rem">Reset Filter</a>@endif</div></div>
</div>
@endif

{{-- History table --}}
<div class="card-m fade-up delay-2">
  <div class="card-m-header"><div class="card-m-title"><i class="bi bi-card-list"></i> Riwayat Penawaran Saya</div></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Barang</th><th>Harga Awal</th><th>Penawaran Saya</th><th>Hasil</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($history as $i=>$h)
        <tr>
          <td style="color:var(--ink-l)">{{ $i+1 }}</td>
          <td><strong style="color:var(--ink)">{{ $h->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
          <td style="color:var(--ink-m)">{{ $h->barang ? 'Rp '.number_format($h->barang->harga_awal, 0, ',', '.') : '—' }}</td>
          <td style="font-weight:600;color:var(--ink)">Rp {{ number_format($h->penawaran_harga, 0, ',', '.') }}</td>
          <td>
            @if($h->penawaran_harga == $h->lelang->harga_akhir && $h->lelang->harga_akhir > 0)
              <span class="win-badge"><i class="bi bi-trophy-fill"></i> Pemenang!</span>
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
            @elseif($h->penawaran_harga == $h->lelang->harga_akhir && $h->lelang->harga_akhir > 0)
            <a href="{{ route('masyarakat.faktur', $h->id_lelang) }}" class="btn-m btn-gold-m btn-sm-m" style="display:inline-flex;align-items:center;gap:.35rem"><i class="fas fa-file-pdf"></i> Faktur</a>
            @else<span style="color:var(--ink-l);font-size:.78rem">—</span>@endif
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:3rem;color:var(--ink-m)"><div style="font-size:2rem;opacity:.25;margin-bottom:.5rem">📋</div>Anda belum memiliki riwayat penawaran.</td></tr>
        @endforelse
      </tbody>
    </table>
    @if($history->hasPages())
    <div style="padding:.75rem 1rem">{{ $history->appends(request()->except('page'))->links() }}</div>
    @endif
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
        <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:.85rem;margin-bottom:1rem;font-size:.83rem">Barang: <strong>{{ $h->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></div>
        <input type="hidden" name="id_history" value="{{ $h->id_history }}">
        <input type="hidden" name="penawaran_harga" id="penawaran_harga_edit_raw_{{ $h->id_history }}">
        <div class="form-group-m">
          <label class="form-label-m">Penawaran Baru (Rp)</label>
          <input type="text" class="form-control-m bid-input" style="padding-left:1rem" 
                 id="penawaran_harga_edit_display_{{ $h->id_history }}"
                 data-raw-id="penawaran_harga_edit_raw_{{ $h->id_history }}"
                 data-harga-awal="{{ $h->lelang->barang->harga_awal ?? 0 }}"
                 data-max-bid="{{ ($h->lelang->barang->harga_awal ?? 0) * 20 }}"
                 data-submit-btn="submit-btn-edit-{{ $h->id_history }}"
                 value="{{ number_format($h->penawaran_harga, 0, ',', '.') }}" required>
          <div id="warning-edit-{{ $h->id_history }}" style="display:none;font-size:.75rem;color:#C0392B;background:#FEF0EE;border:1px solid #F5C2C7;border-radius:6px;padding:.5rem .75rem;margin-top:.5rem">
            <i class="fas fa-exclamation-triangle"></i> <span class="warning-text"></span>
          </div>
        </div>
      </div>
      <div class="modal-m-footer">
        <button type="button" class="btn-m btn-outline-m" onclick="closeModal('modal-ubah{{ $h->id_history }}')">Batal</button>
        <button type="submit" class="btn-m btn-primary-m" id="submit-btn-edit-{{ $h->id_history }}"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>
<div class="modal-m-overlay" id="modal-hapus{{ $h->id_history }}">
  <div class="modal-m">
    <div class="modal-m-header"><span class="modal-m-title">Hapus Penawaran</span><button class="modal-m-close" onclick="closeModal('modal-hapus{{ $h->id_history }}')">×</button></div>
    <div class="modal-m-body" style="text-align:center;padding:1.5rem"><div style="font-size:2.5rem;margin-bottom:.75rem">🗑️</div><p style="font-size:.9rem;color:var(--ink-s)">Hapus penawaran untuk <strong>{{ $h->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong>?</p></div>
    <div class="modal-m-footer">
      <button class="btn-m btn-outline-m" onclick="closeModal('modal-hapus{{ $h->id_history }}')">Batal</button>
      <form method="POST" action="{{ route('masyarakat.penawaran.hapus', $h->id_history) }}" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-m btn-danger-m">Ya, Hapus</button>
      </form>
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

// Thousand separator formatting for bid inputs
document.querySelectorAll('.bid-input').forEach(function(input){
  input.addEventListener('input', function(e){
    let val = e.target.value.replace(/\D/g, ''); // Remove non-digits
    let formatted = val ? parseInt(val).toLocaleString('id-ID') : '';
    e.target.value = formatted;
    let rawId = e.target.getAttribute('data-raw-id');
    if(rawId) document.getElementById(rawId).value = val;
    
    // Validate max bid (20x harga_awal)
    let maxBid = parseInt(e.target.getAttribute('data-max-bid'));
    let submitBtnId = e.target.getAttribute('data-submit-btn');
    let rawId = e.target.getAttribute('data-raw-id');
    let warningId = rawId.includes('edit') ? rawId.replace('penawaran_harga_edit_raw_', 'warning-edit-') : rawId.replace('penawaran_harga_raw_', 'warning-');
    let warningEl = document.getElementById(warningId);
    let submitBtn = document.getElementById(submitBtnId);
    
    if(val && parseInt(val) > maxBid){
      if(warningEl){
        warningEl.style.display = 'block';
        warningEl.querySelector('.warning-text').textContent = 'Penawaran tidak wajar!';
      }
      if(submitBtn){
        submitBtn.disabled = true;
        submitBtn.style.opacity = '.5';
        submitBtn.style.cursor = 'not-allowed';
      }
    } else {
      if(warningEl) warningEl.style.display = 'none';
      if(submitBtn){
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
      }
    }
  });
  // Trigger on load for pre-filled values
  input.dispatchEvent(new Event('input'));
});
</script>
@endpush
