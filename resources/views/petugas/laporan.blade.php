
@extends('layouts.petugas')
@section('content')
<div class="page-header fade-up">
  <div><h1 class="page-title">Laporan Hasil Lelang</h1><p class="page-sub">Rekap seluruh hasil lelang yang telah selesai dijalankan.</p></div>
  <div style="display:flex;gap:.5rem;flex-wrap:wrap">
    <a href="{{ route('petugas.laporan') }}" class="btn-m btn-secondary-m"><i class="fas fa-sync-alt"></i> Generate</a>
    <a href="{{ route('petugas.laporan.pdf', ['mode'=>'print']) }}" target="_blank" class="btn-m btn-primary-m"><i class="fas fa-print"></i> Print</a>
    <a href="{{ route('petugas.laporan.pdf', ['mode'=>'pdf']) }}" target="_blank" class="btn-m" style="background:var(--gold);color:var(--ink);border-radius:100px;padding:.5rem 1.1rem;font-size:.82rem;font-weight:600;display:inline-flex;align-items:center;gap:.4rem;text-decoration:none"><i class="fas fa-file-pdf"></i> Download PDF</a>
  </div>
</div>
<div class="stat-grid fade-up delay-1">
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-check-circle"></i></div><div class="stat-card-n">{{ $total_selesai }}</div><div class="stat-card-l">Lelang Selesai</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-lightning-charge"></i></div><div class="stat-card-n">{{ $total_aktif }}</div><div class="stat-card-l">Lelang Aktif</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-cash-coin"></i></div><div class="stat-card-n">{{ $total_penawaran }}</div><div class="stat-card-l">Total Penawaran</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-trophy"></i></div><div class="stat-card-n" style="font-size:1.3rem">Rp {{ number_format($total_nilai,0,',','.') }}</div><div class="stat-card-l">Nilai Transaksi</div></div>
</div>
<div class="card-m fade-up delay-2">
  <div class="card-m-header"><div class="card-m-title"><i class="bi bi-bar-chart"></i> Data Hasil Lelang</div></div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Barang</th><th>Penjual</th><th>Tanggal Lelang</th><th>Pemenang</th><th>Harga Awal</th><th>Harga Akhir</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($rows as $i=>$d)
        <tr>
          <td style="color:var(--ink-l)">{{ $i+1 }}</td>
          <td><strong style="color:var(--ink)">{{ $d->barang->nama_barang ?? '<em style="color:var(--ink-l)">Data tidak tersedia</em>' }}</strong></td>
          <td style="color:var(--ink-m)">{{ $d->barang->nama_penjual ?? '—' }}</td>
          <td style="color:var(--ink-m)">{{ $d->tgl_lelang ?? '—' }}</td>
          <td>
            @if($d->status=='dibuka')<span style="color:var(--ink-l);font-size:.8rem">Masih berlangsung</span>
            @elseif($d->_pemenang)<span style="font-size:.82rem;font-weight:500">🏆 {{ $d->_pemenang }}</span>
            @else<span style="color:var(--ink-l);font-size:.8rem">Tidak ada pemenang</span>@endif
          </td>
          <td style="color:var(--ink-m)">{{ $d->barang ? 'Rp '.number_format($d->barang->harga_awal) : '—' }}</td>
          <td style="font-weight:600;color:var(--success)">{{ ($d->status=='ditutup'&&$d->_harga_tertinggi)?'Rp '.number_format($d->_harga_tertinggi):'—' }}</td>
          <td>
            @if($d->status=='dibuka')<span class="badge-m badge-open"><i class="fas fa-circle" style="font-size:.45rem"></i> Dibuka</span>
            @elseif($d->status=='ditutup')<span class="badge-m badge-closed">Selesai</span>
            @else<span class="badge-m badge-pending">Belum Aktif</span>@endif
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:3rem;color:var(--ink-m)">Belum ada data lelang.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
