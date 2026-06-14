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

@if(session('success'))
<div class="alert alert-success fade-up delay-1" style="background:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1.5rem">
  <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="stat-grid fade-up delay-1">
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-check-circle"></i></div><div class="stat-card-n">{{ $total_selesai }}</div><div class="stat-card-l">Lelang Selesai</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-lightning-charge"></i></div><div class="stat-card-n">{{ $total_aktif }}</div><div class="stat-card-l">Lelang Aktif</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-cash-coin"></i></div><div class="stat-card-n">{{ $total_penawaran }}</div><div class="stat-card-l">Total Penawaran</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-trophy"></i></div><div class="stat-card-n" style="font-size:1.3rem">Rp {{ number_format($total_nilai,0,',','.') }}</div><div class="stat-card-l">Nilai Transaksi</div></div>
</div>

<div class="card-m fade-up delay-2">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-bar-chart"></i> Data Hasil Lelang</div>
    <form method="GET" style="display:flex;gap:.5rem;align-items:center">
      <select name="status_konfirmasi" style="padding:.5rem;border:1px solid var(--border);border-radius:6px;font-size:.85rem" onchange="this.form.submit()">
        <option value="">Semua Status Konfirmasi</option>
        <option value="menunggu_konfirmasi" {{ request('status_konfirmasi') === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
        <option value="dikonfirmasi" {{ request('status_konfirmasi') === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
        <option value="dibatalkan" {{ request('status_konfirmasi') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        <option value="selesai" {{ request('status_konfirmasi') === 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
      @if(request('status_konfirmasi'))
      <a href="{{ route('petugas.laporan') }}" class="btn-m btn-secondary-m" style="padding:.5rem .75rem;font-size:.8rem"><i class="fas fa-times"></i></a>
      @endif
    </form>
  </div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead><tr><th>#</th><th>Nama Barang</th><th>Tanggal</th><th>Pemenang</th><th>Harga Akhir</th><th>Status</th><th>Status Konfirmasi</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($paginator as $i=>$d)
        <tr>
          <td style="color:var(--ink-l)">{{ $paginator->firstItem() + $i }}</td>
          <td><strong style="color:var(--ink)">{{ $d->barang->nama_barang ?? '-' }}</strong></td>
          <td style="color:var(--ink-m)">{{ $d->tgl_lelang ?? '—' }}</td>
          <td>
            @if($d->status=='dibuka')<span style="color:var(--ink-l);font-size:.8rem">Masih berlangsung</span>
            @elseif($d->_pemenang)<span style="font-size:.82rem;font-weight:500"><i class="bi bi-trophy" style="color:var(--gold)"></i> {{ $d->_pemenang }}</span>
            @else<span style="color:var(--ink-l);font-size:.8rem">Tidak ada pemenang</span>@endif
          </td>
          <td style="font-weight:600;color:var(--success)">{{ ($d->status=='ditutup'&&$d->_harga_tertinggi)?'Rp '.number_format($d->_harga_tertinggi, 0, ',', '.'):'—' }}</td>
          <td>
            @if($d->status=='dibuka')<span class="badge-m badge-open"><i class="fas fa-circle" style="font-size:.45rem"></i> Dibuka</span>
            @elseif($d->status=='ditutup')<span class="badge-m badge-closed">Selesai</span>
            @else<span class="badge-m badge-pending">Belum Aktif</span>@endif
          </td>
          <td>
            @if($d->status=='ditutup' && $d->id_user > 0)
              @if($d->status_konfirmasi === 'menunggu_konfirmasi')
              <span class="badge-m" style="background:rgba(255,193,7,.15);color:#ffc107;border:1px solid rgba(255,193,7,.3)">Menunggu</span>
              @elseif($d->status_konfirmasi === 'dikonfirmasi')
              <span class="badge-m" style="background:rgba(40,167,69,.15);color:#28a745;border:1px solid rgba(40,167,69,.3)">Dikonfirmasi</span>
              @elseif($d->status_konfirmasi === 'dibatalkan')
              <span class="badge-m" style="background:rgba(220,53,69,.15);color:#dc3545;border:1px solid rgba(220,53,69,.3)">Dibatalkan</span>
              @elseif($d->status_konfirmasi === 'selesai')
              <span class="badge-m" style="background:rgba(108,117,125,.15);color:#6c757d;border:1px solid rgba(108,117,125,.3)">Selesai</span>
              @else
              <span style="color:var(--ink-l);font-size:.8rem">-</span>
              @endif
            @else
            <span style="color:var(--ink-l);font-size:.8rem">-</span>
            @endif
          </td>
          <td>
            @if($d->status=='ditutup' && $d->id_user > 0)
            <button type="button" onclick="openUpdateModal({{ $d->id_lelang }}, '{{ $d->status_konfirmasi }}', '{{ $d->catatan_admin ?? '' }}')" class="btn-m btn-secondary-m" style="padding:.4rem .75rem;font-size:.8rem">
              <i class="fas fa-edit"></i> Update
            </button>
            @if($d->nomor_faktur)
            <a href="{{ route('petugas.faktur_pdf', $d->id_lelang) }}" target="_blank" class="btn-m" style="padding:.4rem .75rem;font-size:.8rem;background:var(--gold);color:var(--ink);border:none">
              <i class="fas fa-file-pdf"></i> Faktur
            </a>
            @endif
            @else
            <span style="color:var(--ink-l);font-size:.8rem">-</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:3rem;color:var(--ink-m)">Belum ada data lelang.</td></tr>
        @endforelse
      </tbody>
    </table>
    @if($paginator->hasPages())
    <div style="padding:.75rem 1rem">{{ $paginator->links() }}</div>
    @endif
  </div>
</div>

<!-- Modal Update Status -->
<div id="updateModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:12px;padding:2rem;max-width:500px;width:90%">
    <h3 style="margin:0 0 1rem;font-size:1.1rem;color:var(--ink)">Update Status Konfirmasi</h3>
    <form method="POST" action="{{ route('petugas.laporan.update_status') }}" id="updateForm">
      @csrf
      <input type="hidden" name="id_lelang" id="update_id_lelang">
      <div style="margin-bottom:1rem">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--ink-m);margin-bottom:.4rem">Status Konfirmasi</label>
        <select name="status_konfirmasi" id="update_status_konfirmasi" style="width:100%;padding:.75rem;border:1px solid var(--border);border-radius:6px;font-family:inherit" required>
          <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
          <option value="dikonfirmasi">Dikonfirmasi</option>
          <option value="dibatalkan">Dibatalkan</option>
          <option value="selesai">Selesai</option>
        </select>
      </div>
      <div style="margin-bottom:1rem">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--ink-m);margin-bottom:.4rem">Catatan Admin (opsional)</label>
        <textarea name="catatan_admin" id="update_catatan_admin" rows="3" style="width:100%;padding:.75rem;border:1px solid var(--border);border-radius:6px;font-family:inherit" placeholder="Tambahkan catatan jika perlu..."></textarea>
      </div>
      <div style="display:flex;gap:.75rem;justify-content:flex-end">
        <button type="button" class="btn-m btn-secondary-m" onclick="closeUpdateModal()">Batal</button>
        <button type="submit" class="btn-m btn-primary-m">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openUpdateModal(id_lelang, status, catatan) {
  document.getElementById('update_id_lelang').value = id_lelang;
  document.getElementById('update_status_konfirmasi').value = status || 'menunggu_konfirmasi';
  document.getElementById('update_catatan_admin').value = catatan || '';
  document.getElementById('updateModal').style.display = 'flex';
}
function closeUpdateModal() {
  document.getElementById('updateModal').style.display = 'none';
}
</script>
@endsection
