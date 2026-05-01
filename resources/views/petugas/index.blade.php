
@extends('layouts.petugas')
@section('content')
@php $isAdmin = session('id_level')==1; @endphp
<div class="page-header fade-up">
  <div><h1 class="page-title">Dasbor {{ $isAdmin?'Admin':'Petugas' }}</h1><p class="page-sub">Selamat datang, {{ session('username') }}. Pantau dan kelola seluruh aktivitas lelang.</p></div>
  <a href="{{ $isAdmin?route('administrator.barang'):route('petugas.aktivasi') }}" class="btn-m btn-primary-m"><i class="fas fa-{{ $isAdmin?'plus':'play-circle' }}"></i> {{ $isAdmin?'Tambah Barang':'Aktivasi Lelang' }}</a>
</div>
<div class="stat-grid fade-up delay-1">
  <div class="stat-card"><div class="stat-card-ico">📦</div><div class="stat-card-n">{{ $total_barang }}</div><div class="stat-card-l">Total Barang</div></div>
  <div class="stat-card"><div class="stat-card-ico">⚡</div><div class="stat-card-n">{{ $total_lelang_aktif }}</div><div class="stat-card-l">Lelang Aktif</div></div>
  <div class="stat-card"><div class="stat-card-ico">💰</div><div class="stat-card-n">{{ $total_penawaran }}</div><div class="stat-card-l">Total Penawaran</div></div>
  <div class="stat-card"><div class="stat-card-ico">👥</div><div class="stat-card-n">{{ $total_masyarakat }}</div><div class="stat-card-l">Peserta Terdaftar</div></div>
</div>
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.75rem" class="fade-up delay-2">
  <a href="{{ route('petugas.barang') }}" style="text-decoration:none"><div class="card-m" style="padding:1.5rem;display:flex;align-items:center;gap:.9rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'"><div style="width:44px;height:44px;border-radius:10px;background:var(--gold-p);border:1px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">📦</div><div><div style="font-size:.9rem;font-weight:600;color:var(--ink)">Pendataan Barang</div><div style="font-size:.75rem;color:var(--ink-m)">Tambah & kelola barang</div></div></div></a>
  <a href="{{ $isAdmin?route('administrator.petugas'):route('petugas.aktivasi') }}" style="text-decoration:none"><div class="card-m" style="padding:1.5rem;display:flex;align-items:center;gap:.9rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'"><div style="width:44px;height:44px;border-radius:10px;background:var(--gold-p);border:1px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">{{ $isAdmin?'👥':'⚡' }}</div><div><div style="font-size:.9rem;font-weight:600;color:var(--ink)">{{ $isAdmin?'Data Petugas':'Aktivasi Lelang' }}</div><div style="font-size:.75rem;color:var(--ink-m)">{{ $isAdmin?'Kelola akun petugas':'Buka & tutup lelang' }}</div></div></div></a>
  <a href="{{ route('petugas.laporan') }}" style="text-decoration:none"><div class="card-m" style="padding:1.5rem;display:flex;align-items:center;gap:.9rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'"><div style="width:44px;height:44px;border-radius:10px;background:var(--gold-p);border:1px solid var(--gold-ln);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">📊</div><div><div style="font-size:.9rem;font-weight:600;color:var(--ink)">Laporan</div><div style="font-size:.75rem;color:var(--ink-m)">Lihat hasil lelang</div></div></div></a>
</div>
<div class="card-m fade-up delay-3">
  <div class="card-m-header"><div class="card-m-title"><span>📋</span> Daftar Lelang Terbaru</div><a href="{{ route('petugas.aktivasi') }}" class="btn-m btn-outline-m btn-sm-m">Kelola Semua →</a></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Barang</th><th>Harga Awal</th><th>Harga Akhir</th><th>Status</th><th>Dibuka Oleh</th></tr></thead>
      <tbody>
        @forelse($recent_lelang as $i=>$row)
        <tr>
          <td style="color:var(--ink-l);font-size:.8rem">{{ $i+1 }}</td>
          <td><strong style="color:var(--ink)">{{ $row->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
          <td>{{ $row->barang ? 'Rp '.number_format($row->barang->harga_awal) : '—' }}</td>
          <td>{{ $row->harga_akhir ? 'Rp '.number_format($row->harga_akhir) : '—' }}</td>
          <td>@if($row->status=='dibuka')<span class="badge-m badge-open"><i class="fas fa-circle" style="font-size:.5rem"></i> Dibuka</span>@else<span class="badge-m badge-closed">Ditutup</span>@endif</td>
          <td style="font-size:.82rem;color:var(--ink-m)">{{ $row->petugas->nama_petugas ?? '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;padding:2.5rem;color:var(--ink-m)">Belum ada data lelang</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
