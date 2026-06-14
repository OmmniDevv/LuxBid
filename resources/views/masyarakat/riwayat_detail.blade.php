@extends('layouts.masyarakat')
@section('content')
<div class="page-header fade-up">
  <div style="display:flex;align-items:center;gap:1rem">
    <a href="{{ route('masyarakat.riwayat') }}" class="btn-m btn-outline-m" style="padding:.5rem">
      <i class="fas fa-arrow-left"></i>
    </a>
    <div>
      <h1 class="page-title">Detail Riwayat Lelang</h1>
      <p class="page-sub">Lot #{{ str_pad($lelang->id_lelang, 4, '0', STR_PAD_LEFT) }}</p>
    </div>
  </div>
</div>

<div class="card-m fade-up delay-1">
  <div style="padding:2rem">
    <div style="display:flex;gap:2rem;margin-bottom:2rem">
      @if($lelang->barang->gambarUtama)
      <img src="{{ asset('storage/barang/' . $lelang->barang->gambarUtama->nama_file) }}"
           style="width:200px;height:200px;object-fit:cover;border-radius:8px;flex-shrink:0">
      @else
      <div style="width:200px;height:200px;background:var(--cream-d);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <i class="bi bi-box-seam" style="font-size:3rem;color:var(--ink-l)"></i>
      </div>
      @endif

      <div style="flex:1">
        <h2 style="font-size:1.5rem;font-weight:700;color:var(--ink);margin:0 0 1rem">{{ $lelang->barang->nama_barang }}</h2>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:1rem">
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Status Lelang</div>
            <div style="font-weight:600;color:var(--ink)">
              @if($lelang->status === 'dibuka') Dibuka
              @elseif($lelang->status === 'ditutup') Ditutup
              @else Selesai
              @endif
            </div>
          </div>
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Harga Awal</div>
            <div style="font-weight:600;color:var(--ink)">Rp {{ number_format($lelang->barang->harga_awal, 0, ',', '.') }}</div>
          </div>
          @if($lelang->harga_akhir)
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Harga Akhir</div>
            <div style="font-weight:600;color:var(--success)">Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</div>
          </div>
          @endif
          @if($lelang->id_user == session('id_user'))
          <div>
            <div style="font-size:.75rem;color:var(--ink-m)">Status Anda</div>
            <div style="font-weight:600;color:var(--success)"><i class="fas fa-trophy"></i> Pemenang</div>
          </div>
          @endif
        </div>
      </div>
    </div>

    @if($lelang->barang->deskripsi_barang)
    <div style="background:var(--cream);border-radius:8px;padding:1.25rem;margin-bottom:2rem">
      <h3 style="font-size:.95rem;font-weight:600;color:var(--ink);margin:0 0 .75rem">Deskripsi Barang</h3>
      <p style="color:var(--ink-s);line-height:1.6;margin:0">{{ $lelang->barang->deskripsi_barang }}</p>
    </div>
    @endif
  </div>
</div>

@if($penawaran_saya->isNotEmpty())
<div class="card-m fade-up delay-2" style="margin-top:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="fas fa-gavel"></i> Penawaran Saya ({{ $penawaran_saya->count() }})</div>
  </div>
  <div style="padding:1.5rem">
    <div style="max-height:300px;overflow-y:auto">
      @foreach($penawaran_saya as $p)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;border-bottom:1px solid var(--border);background:{{ $loop->first ? 'rgba(40,167,69,.05)' : 'transparent' }}">
        <div style="display:flex;align-items:center;gap:1rem">
          @if($loop->first)
          <span style="background:var(--success);color:#fff;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600">1</span>
          @else
          <span style="background:var(--cream-d);color:var(--ink-m);width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600">{{ $loop->iteration }}</span>
          @endif
          <div>
            <div style="font-weight:600;color:var(--ink)">Rp {{ number_format($p->penawaran_harga, 0, ',', '.') }}</div>
            <div style="font-size:.75rem;color:var(--ink-m)">{{ $p->created_at ? $p->created_at->format('d/m/Y H:i') : '-' }}</div>
          </div>
        </div>
        @if($loop->first && $lelang->id_user == session('id_user'))
        <span class="badge-m" style="background:rgba(40,167,69,.15);color:#28a745;border:1px solid rgba(40,167,69,.3)">
          <i class="fas fa-trophy"></i> Menang
        </span>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</div>
@endif

<div class="card-m fade-up delay-3" style="margin-top:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="fas fa-history"></i> Timeline Penawaran ({{ $timeline->count() }} total)</div>
  </div>
  <div style="padding:1.5rem">
    <div style="max-height:400px;overflow-y:auto">
      @foreach($timeline as $t)
      <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;border-bottom:1px solid var(--border)">
        <div style="display:flex;align-items:center;gap:1rem">
          <span style="background:{{ $t->id_user == session('id_user') ? 'var(--primary)' : 'var(--cream-d)' }};color:{{ $t->id_user == session('id_user') ? '#fff' : 'var(--ink-m)' }};width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600">
            {{ $loop->iteration }}
          </span>
          <div>
            <div style="font-weight:600;color:var(--ink)">
              {{ $t->masyarakat->nama_lengkap }}
              @if($t->id_user == session('id_user'))
              <span style="font-size:.75rem;color:var(--primary)">(Anda)</span>
              @endif
            </div>
            <div style="font-size:.75rem;color:var(--ink-m)">{{ $t->created_at ? $t->created_at->format('d/m/Y H:i') : '-' }}</div>
          </div>
        </div>
        <div style="font-weight:600;color:var(--ink)">Rp {{ number_format($t->penawaran_harga, 0, ',', '.') }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
