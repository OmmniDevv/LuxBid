@extends('layouts.petugas')
@section('content')

<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Dasbor Administrator</h1>
    <p class="page-sub">Selamat datang, <strong>{{ session('username') }}</strong>. Panel pusat administrasi LuxBid.</p>
  </div>
  <a href="{{ route('administrator.barang') }}" class="btn-m btn-primary-m">
    <i class="fas fa-plus"></i> Tambah Barang
  </a>
</div>

{{-- Stats --}}
<div class="stat-grid fade-up delay-1">
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-box-seam"></i></div>
    <div class="stat-card-n">{{ $total_barang }}</div>
    <div class="stat-card-l">Total Barang</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-lightning-charge"></i></div>
    <div class="stat-card-n">{{ $total_lelang_aktif }}</div>
    <div class="stat-card-l">Lelang Aktif</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-cash-coin"></i></div>
    <div class="stat-card-n">{{ $total_penawaran }}</div>
    <div class="stat-card-l">Total Penawaran</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-ico"><i class="bi bi-people"></i></div>
    <div class="stat-card-n">{{ $total_masyarakat }}</div>
    <div class="stat-card-l">Peserta Terdaftar</div>
  </div>
</div>

<div class="stat-grid fade-up delay-2" style="margin-top:1rem;grid-template-columns:repeat(auto-fit,minmax(200px,1fr))">
  <div class="stat-card" style="border-left:3px solid #ffc107">
    <div class="stat-card-ico" style="color:#ffc107"><i class="bi bi-hourglass-split"></i></div>
    <div class="stat-card-n">{{ $menunggu_konfirmasi }}</div>
    <div class="stat-card-l">Menunggu Konfirmasi</div>
  </div>
  <div class="stat-card" style="border-left:3px solid #17a2b8">
    <div class="stat-card-ico" style="color:#17a2b8"><i class="bi bi-file-earmark-check"></i></div>
    <div class="stat-card-n">{{ $menunggu_verifikasi }}</div>
    <div class="stat-card-l">Verifikasi Bukti Bayar</div>
  </div>
  <div class="stat-card" style="border-left:3px solid #28a745">
    <div class="stat-card-ico" style="color:#28a745"><i class="bi bi-currency-dollar"></i></div>
    <div class="stat-card-n">Rp {{ number_format($total_pendapatan / 1000000, 1) }}jt</div>
    <div class="stat-card-l">Total Pendapatan</div>
  </div>
</div>

{{-- Quick access cards --}}
<div class="quick-nav-grid fade-up delay-2">
  <a href="{{ route('administrator.barang') }}" class="qnav-card" style="text-decoration:none">
    <div class="qnav-ico"><i class="bi bi-box-seam"></i></div>
    <div>
      <div class="qnav-title">Pendataan Barang</div>
      <div class="qnav-sub">Tambah &amp; kelola data barang lelang</div>
    </div>
    <i class="fas fa-chevron-right qnav-arrow"></i>
  </a>
  <a href="{{ route('administrator.petugas') }}" class="qnav-card" style="text-decoration:none">
    <div class="qnav-ico"><i class="bi bi-people"></i></div>
    <div>
      <div class="qnav-title">Data Petugas</div>
      <div class="qnav-sub">Kelola akun petugas &amp; administrator</div>
    </div>
    <i class="fas fa-chevron-right qnav-arrow"></i>
  </a>
  <a href="{{ route('administrator.laporan') }}" class="qnav-card" style="text-decoration:none">
    <div class="qnav-ico"><i class="bi bi-bar-chart-line"></i></div>
    <div>
      <div class="qnav-title">Laporan &amp; Statistik</div>
      <div class="qnav-sub">Hasil lelang &amp; ekspor laporan PDF</div>
    </div>
    <i class="fas fa-chevron-right qnav-arrow"></i>
  </a>
</div>

{{-- Recent auctions table --}}
<div class="card-m fade-up delay-3">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-card-list"></i> Lelang Terbaru</div>
    <a href="{{ route('administrator.laporan') }}" class="btn-m btn-outline-m btn-sm-m">Lihat Semua &rarr;</a>
  </div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Barang</th>
          <th>Harga Awal</th>
          <th>Harga Akhir</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recent_lelang as $i => $r)
        <tr>
          <td style="color:var(--text-3);font-size:.8rem">{{ $i + 1 }}</td>
          <td><strong style="color:var(--text)">{{ $r->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
          <td>{{ $r->barang ? 'Rp '.number_format($r->barang->harga_awal,0,',','.') : '—' }}</td>
          <td>
            @if($r->harga_akhir)
              <span style="color:var(--success);font-weight:600">Rp {{ number_format($r->harga_akhir,0,',','.') }}</span>
            @else
              <span style="color:var(--text-3)">—</span>
            @endif
          </td>
          <td>
            @if($r->status == 'dibuka')
              <span class="badge-m badge-open"><i class="fas fa-circle" style="font-size:.4rem;vertical-align:middle"></i> Dibuka</span>
            @elseif($r->status == 'ditutup')
              <span class="badge-m badge-closed">Selesai</span>
            @else
              <span class="badge-m badge-pending">Belum Aktif</span>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" style="text-align:center;padding:3rem;color:var(--text-2)">
            <div style="font-size:1.75rem;opacity:.2;margin-bottom:.5rem"><i class="bi bi-inbox"></i></div>
            Belum ada data lelang
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@push('styles')
<style>
.quick-nav-grid{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
  gap:1rem;margin-bottom:1.75rem;
}
.qnav-card{
  background:var(--surface);border:1px solid var(--border);
  border-radius:var(--rs);padding:1.25rem 1.35rem;
  display:flex;align-items:center;gap:.9rem;
  transition:all var(--ease);color:var(--text);
}
.qnav-card:hover{
  border-color:var(--accent-ln);background:var(--accent-p);
  transform:translateY(-2px);box-shadow:var(--shadow-md);color:var(--text);
}
.qnav-ico{
  width:44px;height:44px;min-width:44px;border-radius:10px;
  background:var(--accent-p);border:1px solid var(--accent-ln);
  display:flex;align-items:center;justify-content:center;
  font-size:1.15rem;color:var(--accent);
}
.qnav-card:hover .qnav-ico{background:rgba(202,138,4,.25)}
.qnav-title{font-size:.9rem;font-weight:600;color:var(--text);margin-bottom:.15rem}
.qnav-sub{font-size:.74rem;color:var(--text-2)}
.qnav-arrow{margin-left:auto;font-size:.7rem;color:var(--text-3)}
</style>
@endpush

@endsection
