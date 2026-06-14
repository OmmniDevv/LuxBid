@extends('layouts.masyarakat')
@section('content')
<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Riwayat Lelang</h1>
    <p class="page-sub">Daftar lelang yang pernah Anda ikuti dan menangkan.</p>
  </div>
</div>

@if($riwayat->isEmpty())
<div class="card-m fade-up delay-1">
  <div class="card-m-body" style="text-align:center;padding:3rem">
    <i class="fas fa-history" style="font-size:3rem;color:var(--ink-l);margin-bottom:1rem"></i>
    <p style="color:var(--ink-m)">Belum ada riwayat lelang.</p>
    <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-primary-m" style="margin-top:1rem">
      <i class="fas fa-gavel"></i> Ikuti Lelang
    </a>
  </div>
</div>
@else
<div class="fade-up delay-1">
  @foreach($riwayat as $d)
  <div class="card-m" style="margin-bottom:1rem">
    <div style="display:flex;gap:1.5rem;padding:1.5rem">
      @if($d->barang->gambarUtama)
      <img src="{{ asset('storage/barang/' . $d->barang->gambarUtama->nama_file) }}"
           style="width:120px;height:120px;object-fit:cover;border-radius:8px;flex-shrink:0">
      @else
      <div style="width:120px;height:120px;background:var(--cream-d);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <i class="bi bi-box-seam" style="font-size:2rem;color:var(--ink-l)"></i>
      </div>
      @endif

      <div style="flex:1">
        <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:.75rem">
          <div>
            <div style="font-size:.75rem;color:var(--ink-m);margin-bottom:.25rem">
              Lot #{{ str_pad($d->id_lelang, 4, '0', STR_PAD_LEFT) }}
              @if($d->barang->kategori)
              · {{ $d->barang->kategori->nama_kategori }}
              @endif
            </div>
            <h3 style="font-size:1.1rem;font-weight:700;color:var(--ink);margin:0">{{ $d->barang->nama_barang }}</h3>
          </div>
          @if($d->_status_saya === 'Menang')
          <span class="badge-m" style="background:rgba(40,167,69,.15);color:#28a745;border:1px solid rgba(40,167,69,.3)">
            <i class="fas fa-trophy"></i> Menang
          </span>
          @else
          <span class="badge-m" style="background:rgba(108,117,125,.15);color:#6c757d;border:1px solid rgba(108,117,125,.3)">
            Kalah
          </span>
          @endif
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem;margin-bottom:1rem">
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Harga Awal</div>
            <div style="font-weight:600;color:var(--ink)">Rp {{ number_format($d->barang->harga_awal, 0, ',', '.') }}</div>
          </div>
          @if($d->_penawaran_saya)
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Penawaran Tertinggi Saya</div>
            <div style="font-weight:600;color:var(--primary)">Rp {{ number_format($d->_penawaran_saya, 0, ',', '.') }}</div>
          </div>
          @endif
          @if($d->harga_akhir)
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Harga Akhir</div>
            <div style="font-weight:600;color:var(--success)">Rp {{ number_format($d->harga_akhir, 0, ',', '.') }}</div>
          </div>
          @endif
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Total Penawaran Saya</div>
            <div style="font-weight:600;color:var(--ink)">{{ $d->_jumlah_penawaran_saya }}×</div>
          </div>
        </div>

        <div style="display:flex;gap:.75rem">
          <a href="{{ route('masyarakat.riwayat.detail', $d->id_lelang) }}" class="btn-m btn-outline-m" style="font-size:.85rem;padding:.5rem 1rem">
            <i class="fas fa-info-circle"></i> Detail
          </a>
          @if($d->_status_saya === 'Menang' && $d->nomor_faktur)
          <a href="{{ route('masyarakat.faktur_pdf', $d->id_lelang) }}" target="_blank" class="btn-m btn-primary-m" style="font-size:.85rem;padding:.5rem 1rem">
            <i class="fas fa-file-pdf"></i> Faktur
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div class="fade-up delay-2" style="margin-top:2rem">
  {{ $riwayat->links() }}
</div>
@endif
@endsection
