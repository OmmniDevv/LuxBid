@extends('layouts.masyarakat')
@section('content')

<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Wishlist Saya</h1>
    <p class="page-sub">Barang favorit yang Anda tandai untuk diikuti</p>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success fade-up delay-1" style="background:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1.5rem">
  <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card-m fade-up delay-1">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-heart-fill" style="color:#c9a84c"></i> Daftar Wishlist</div>
  </div>
  <div class="card-m-body">
    @forelse($wishlist as $item)
    <div style="border:1px solid var(--border);border-radius:8px;padding:1.25rem;margin-bottom:1rem;display:flex;gap:1.25rem;align-items:start">
      @if($item->barang->gambarUtama)
      <img src="{{ asset('uploads/barang/' . $item->barang->gambarUtama->nama_file) }}" alt="{{ $item->barang->nama_barang }}" style="width:120px;height:120px;object-fit:cover;border-radius:8px;flex-shrink:0">
      @else
      <div style="width:120px;height:120px;background:var(--surface-2);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
        <i class="bi bi-image" style="font-size:2rem;color:var(--ink-l)"></i>
      </div>
      @endif

      <div style="flex:1;min-width:0">
        <h3 style="margin:0 0 .5rem;font-size:1.1rem;color:var(--ink)">{{ $item->barang->nama_barang }}</h3>

        <div style="display:flex;gap:1.5rem;margin-bottom:.75rem;flex-wrap:wrap">
          <div style="font-size:.88rem">
            <span style="color:var(--ink-m)">Harga Awal:</span>
            <strong style="color:var(--success)">Rp {{ number_format($item->barang->harga_awal, 0, ',', '.') }}</strong>
          </div>
          @if($item->barang->kategori)
          <div style="font-size:.88rem">
            <span style="color:var(--ink-m)">Kategori:</span>
            <strong style="color:var(--ink)">{{ $item->barang->kategori->nama_kategori }}</strong>
          </div>
          @endif
        </div>

        <div style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap">
          @if($item->_lelang_aktif)
          <span class="badge-m badge-open" style="background:rgba(40,167,69,.15);color:#28a745;border:1px solid rgba(40,167,69,.3)">
            <i class="fas fa-circle" style="font-size:.45rem"></i> Lelang Aktif
          </span>
          <a href="{{ route('masyarakat.penawaran') }}#lelang-{{ $item->_lelang_aktif->id_lelang }}" class="btn-m btn-primary-m" style="padding:.45rem .9rem;font-size:.82rem">
            <i class="fas fa-gavel"></i> Ikuti Lelang
          </a>
          @else
          <span class="badge-m" style="background:rgba(108,117,125,.15);color:#6c757d;border:1px solid rgba(108,117,125,.3)">
            Tidak Ada Lelang Aktif
          </span>
          @endif

          <form method="POST" action="{{ route('masyarakat.wishlist.toggle', $item->id_barang) }}" style="display:inline">
            @csrf
            <button type="submit" class="btn-m btn-secondary-m" style="padding:.45rem .9rem;font-size:.82rem">
              <i class="fas fa-trash"></i> Hapus
            </button>
          </form>
        </div>

        <div style="margin-top:.75rem;font-size:.8rem;color:var(--ink-l)">
          <i class="bi bi-calendar"></i> Ditambahkan {{ $item->created_at->diffForHumans() }}
        </div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:3rem;color:var(--ink-m)">
      <i class="bi bi-heart" style="font-size:3rem;color:var(--ink-l);margin-bottom:1rem"></i>
      <p style="margin:0;font-size:.95rem">Belum ada barang di wishlist Anda.</p>
      <p style="margin:.5rem 0 0;font-size:.85rem">Tandai barang favorit Anda untuk mendapatkan notifikasi!</p>
      <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-primary-m" style="margin-top:1.5rem">
        <i class="fas fa-gavel"></i> Lihat Lelang Aktif
      </a>
    </div>
    @endforelse

    @if($wishlist->hasPages())
    <div style="padding:.75rem 0;margin-top:1rem;border-top:1px solid var(--border)">
      {{ $wishlist->links() }}
    </div>
    @endif
  </div>
</div>

@endsection
