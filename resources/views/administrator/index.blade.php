
@extends('layouts.petugas')
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Dasbor Admin</h1><p class="page-sub">Selamat datang, {{ session('username') }}. Panel administrasi pusat.</p></div>
  <a href="{{ route('administrator.barang') }}" class="btn-m btn-primary-m"><i class="fas fa-plus"></i> Tambah Barang</a>
</div>
<div class="stat-grid fade-up delay-1">
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-box-seam"></i></div><div class="stat-card-n">{{ $total_barang }}</div><div class="stat-card-l">Total Barang</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-lightning-charge"></i></div><div class="stat-card-n">{{ $total_lelang_aktif }}</div><div class="stat-card-l">Lelang Aktif</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-cash-coin"></i></div><div class="stat-card-n">{{ $total_penawaran }}</div><div class="stat-card-l">Total Penawaran</div></div>
  <div class="stat-card"><div class="stat-card-ico">👥</div><div class="stat-card-n">{{ $total_masyarakat }}</div><div class="stat-card-l">Peserta Terdaftar</div></div>
</div>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.75rem" class="fade-up delay-2">
  <a href="{{ route('administrator.barang') }}" style="text-decoration:none"><div class="card-m" style="padding:1.5rem;display:flex;align-items:center;gap:.9rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'"><div style="width:44px;height:44px;border-radius:10px;background:var(--gold-p);border:1px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0"><i class="bi bi-box-seam"></i></div><div><div style="font-size:.9rem;font-weight:600;color:var(--ink)">Pendataan Barang</div><div style="font-size:.75rem;color:var(--ink-m)">Tambah & kelola barang</div></div></div></a>
  <a href="{{ route('administrator.petugas') }}" style="text-decoration:none"><div class="card-m" style="padding:1.5rem;display:flex;align-items:center;gap:.9rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'"><div style="width:44px;height:44px;border-radius:10px;background:var(--gold-p);border:1px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0"><i class="bi bi-people"></i></div><div><div style="font-size:.9rem;font-weight:600;color:var(--ink)">Data Petugas</div><div style="font-size:.75rem;color:var(--ink-m)">Kelola akun petugas</div></div></div></a>
  <a href="{{ route('administrator.laporan') }}" style="text-decoration:none"><div class="card-m" style="padding:1.5rem;display:flex;align-items:center;gap:.9rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'"><div style="width:44px;height:44px;border-radius:10px;background:var(--gold-p);border:1px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0"><i class="bi bi-bar-chart"></i></div><div><div style="font-size:.9rem;font-weight:600;color:var(--ink)">Laporan</div><div style="font-size:.75rem;color:var(--ink-m)">Hasil & statistik lelang</div></div></div></a>
</div>
<div class="card-m fade-up delay-3">
  <div class="card-m-header"><div class="card-m-title"><i class="bi bi-card-list"></i> Lelang Terbaru</div><a href="{{ route('administrator.laporan') }}" class="btn-m btn-outline-m btn-sm-m">Lihat Semua →</a></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Barang</th><th>Harga Awal</th><th>Harga Akhir</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($recent_lelang as $i=>$r)
        <tr>
          <td style="color:var(--ink-l)">{{ $i+1 }}</td>
          <td><strong>{{ $r->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
          <td>{{ $r->barang ? 'Rp '.number_format($r->barang->harga_awal) : '—' }}</td>
          <td>{{ $r->harga_akhir ? 'Rp '.number_format($r->harga_akhir) : '—' }}</td>
          <td>@if($r->status=='dibuka')<span class="badge-m badge-open">Dibuka</span>@elseif($r->status=='ditutup')<span class="badge-m badge-closed">Selesai</span>@else<span class="badge-m badge-pending">Belum Aktif</span>@endif</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--ink-m)">Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
