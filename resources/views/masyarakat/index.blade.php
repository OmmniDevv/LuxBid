@extends('layouts.masyarakat')
@section('content')

<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Selamat Datang, {{ session('username') }}</h1>
    <p class="page-sub">Anda login sebagai peserta lelang. Temukan dan ikuti lelang aktif hari ini.</p>
  </div>
</div>

{{-- Stats --}}
<div class="stat-grid fade-up delay-1">
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-lightning-charge"></i></div>
    <div class="stat-card-n">{{ $jumlah_aktif }}</div>
    <div class="stat-card-l">Lelang Aktif</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-card-list"></i></div>
    <div class="stat-card-n">{{ $jumlah_penawaran }}</div>
    <div class="stat-card-l">Penawaran Saya</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-patch-check"></i></div>
    <div class="stat-card-n" style="font-size:1.25rem">Aktif</div>
    <div class="stat-card-l">Status Akun</div>
  </div>
</div>

{{-- Quick Access --}}
<div class="card-m fade-up delay-2" style="margin-bottom:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-grid-1x2"></i> Akses Cepat</div>
  </div>
  <div class="card-m-body">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:1rem">
      <a href="{{ route('masyarakat.penawaran') }}" class="quick-link-card" style="text-decoration:none">
        <div class="quick-card-inner">
          <div class="quick-card-ico">
            <i class="fas fa-gavel"></i>
          </div>
          <div class="quick-card-label">Lihat &amp; Ikuti Lelang</div>
          <div class="quick-card-sub">Temukan barang lelang aktif dan ajukan penawaran terbaik</div>
        </div>
      </a>

      <div class="quick-card-inner" style="opacity:.8">
        <div class="quick-card-ico" style="background:var(--surface-2)">
          <i class="bi bi-bar-chart-line"></i>
        </div>
        <div class="quick-card-label">Pantau Penawaran</div>
        <div class="quick-card-sub">Lihat histori dan status penawaran di halaman Penawaran</div>
      </div>

      <div class="quick-card-inner" style="opacity:.8">
        <div class="quick-card-ico" style="background:var(--surface-2)">
          <i class="bi bi-award"></i>
        </div>
        <div class="quick-card-label">Menangkan Lelang</div>
        <div class="quick-card-sub">Penawar tertinggi saat waktu habis jadi pemenang resmi</div>
      </div>
    </div>

    <div style="margin-top:1.25rem">
      <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-primary-m">
        <i class="fas fa-gavel"></i> Mulai Ikuti Lelang
      </a>
    </div>
  </div>
</div>

{{-- Active auctions --}}
<div class="card-m fade-up delay-3">
  <div class="card-m-header">
    <div class="card-m-title">
      <i class="bi bi-broadcast" style="color:var(--success)"></i>
      Lelang Aktif Saat Ini
    </div>
    <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-outline-m btn-sm-m">Lihat Semua &rarr;</a>
  </div>
  <div class="card-m-body" style="padding:.75rem">
    @if($rows->isEmpty())
      <div class="empty-state">
        <div class="empty-state-ico"><i class="bi bi-box-seam"></i></div>
        <div class="empty-state-title">Belum ada lelang aktif</div>
        <div class="empty-state-sub">Lelang aktif akan muncul di sini saat petugas membukanya.</div>
      </div>
    @else
      <div style="display:flex;flex-direction:column;gap:.65rem">
        @foreach($rows as $l)
        @php $harga_tampil = $l->penawaran_tertinggi ?? $l->barang->harga_awal; @endphp
        <div class="list-item-card">
          <div class="lic-img">
            @if($l->foto)
              <img src="{{ asset('storage/barang/'.$l->foto) }}" alt="{{ $l->barang->nama_barang }}" style="width:100%;height:100%;object-fit:cover">
            @else
              <i class="bi bi-box-seam" style="font-size:1.75rem;color:var(--text-3)"></i>
            @endif
          </div>
          <div class="lic-body">
            <div class="lic-meta">
              Lot #{{ str_pad($l->id_lelang,4,'0',STR_PAD_LEFT) }}
              &middot; {{ \Carbon\Carbon::parse($l->tgl_lelang)->format('d M Y') }}
            </div>
            <div class="lic-name">{{ $l->barang->nama_barang }}</div>
            <div class="lic-meta">{{ $l->jumlah_penawar }} penawar</div>
          </div>
          <div class="lic-price">
            <div class="lic-price-lbl">{{ $l->penawaran_tertinggi ? 'Tertinggi' : 'Harga Awal' }}</div>
            <div class="lic-price-val">Rp {{ number_format($harga_tampil,0,',','.') }}</div>
          </div>
          <div class="lic-action">
            <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-primary-m btn-sm-m">
              <i class="fas fa-gavel"></i> Tawar
            </a>
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

@push('styles')
<style>
/* Quick access cards */
.quick-link-card:hover .quick-card-inner{
  background:var(--accent-p);border-color:var(--accent-ln);
  transform:translateY(-3px);box-shadow:var(--shadow-md);
}
.quick-card-inner{
  background:var(--surface-2);border:1px solid var(--border-2);
  border-radius:var(--rs);padding:1.25rem;
  transition:all var(--ease);cursor:default;
}
.quick-card-ico{
  width:44px;height:44px;border-radius:var(--rss);
  background:var(--accent-p);border:1px solid var(--accent-ln);
  display:flex;align-items:center;justify-content:center;
  font-size:1.15rem;color:var(--accent);margin-bottom:.9rem;
}
.quick-card-label{font-size:.9rem;font-weight:600;color:var(--text);margin-bottom:.25rem}
.quick-card-sub{font-size:.78rem;color:var(--text-2);line-height:1.6}

/* List item card */
.list-item-card{
  display:flex;align-items:center;gap:1rem;
  background:var(--surface-2);border:1px solid var(--border);
  border-radius:var(--rs);overflow:hidden;
  transition:box-shadow var(--ease),transform var(--ease),border-color var(--ease);
}
.list-item-card:hover{
  transform:translateY(-2px);
  box-shadow:var(--shadow-md);
  border-color:var(--accent-ln);
}
.lic-img{
  flex-shrink:0;width:84px;height:84px;
  background:var(--surface-3);
  display:flex;align-items:center;justify-content:center;overflow:hidden;
}
.lic-body{flex:1;min-width:0;padding:.75rem 0}
.lic-meta{font-size:.67rem;color:var(--text-3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.15rem}
.lic-name{
  font-family:var(--font-serif);font-weight:700;
  color:var(--text);font-size:1rem;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
}
.lic-price{text-align:right;flex-shrink:0;padding:.75rem}
.lic-price-lbl{font-size:.67rem;color:var(--text-3);margin-bottom:.1rem}
.lic-price-val{
  font-family:var(--font-serif);font-size:1.05rem;
  color:var(--success);font-weight:700;
}
.lic-action{flex-shrink:0;padding:.75rem}

/* Empty state */
.empty-state{text-align:center;padding:3rem 1.5rem;color:var(--text-2)}
.empty-state-ico{font-size:2.5rem;opacity:.2;margin-bottom:.65rem;color:var(--accent)}
.empty-state-title{font-family:var(--font-serif);font-size:1.1rem;color:var(--text);margin-bottom:.3rem}
.empty-state-sub{font-size:.83rem;color:var(--text-2)}

@media(max-width:600px){
  .list-item-card{flex-wrap:wrap}
  .lic-img{width:100%;height:120px;border-radius:0}
  .lic-body{padding:.75rem}
  .lic-action{padding:.5rem .75rem .75rem}
}
</style>
@endpush

@endsection
