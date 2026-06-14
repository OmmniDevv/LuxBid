@extends('layouts.petugas')
@section('content')

<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Activity Log</h1>
    <p class="page-sub">Riwayat aktivitas admin dan petugas di sistem.</p>
  </div>
</div>

<div class="card-m fade-up delay-1">
  <div class="card-m-body">
    <form method="GET" action="{{ route('administrator.activity_log') }}">
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:.75rem;align-items:end">
        <div>
          <label class="form-label-m" style="font-size:.78rem">Aksi</label>
          <select name="action" class="form-control-m">
            <option value="">Semua Aksi</option>
            <option value="create_barang" {{ request('action') === 'create_barang' ? 'selected' : '' }}>Tambah Barang</option>
            <option value="update_barang" {{ request('action') === 'update_barang' ? 'selected' : '' }}>Update Barang</option>
            <option value="delete_barang" {{ request('action') === 'delete_barang' ? 'selected' : '' }}>Hapus Barang</option>
            <option value="buka_lelang" {{ request('action') === 'buka_lelang' ? 'selected' : '' }}>Buka Lelang</option>
            <option value="tutup_lelang" {{ request('action') === 'tutup_lelang' ? 'selected' : '' }}>Tutup Lelang</option>
            <option value="upload_bukti_bayar" {{ request('action') === 'upload_bukti_bayar' ? 'selected' : '' }}>Upload Bukti Bayar</option>
            <option value="verifikasi_bukti_bayar" {{ request('action') === 'verifikasi_bukti_bayar' ? 'selected' : '' }}>Verifikasi Bukti</option>
          </select>
        </div>
        <div>
          <label class="form-label-m" style="font-size:.78rem">Dari Tanggal</label>
          <input type="date" name="from" class="form-control-m" value="{{ request('from') }}">
        </div>
        <div>
          <label class="form-label-m" style="font-size:.78rem">Sampai Tanggal</label>
          <input type="date" name="to" class="form-control-m" value="{{ request('to') }}">
        </div>
        <div style="display:flex;gap:.5rem">
          <button type="submit" class="btn-m btn-primary-m"><i class="fas fa-search"></i> Filter</button>
          <a href="{{ route('administrator.activity_log') }}" class="btn-m btn-outline-m">Reset</a>
        </div>
      </div>
    </form>
  </div>
</div>

@if($logs->isEmpty())
<div class="card-m fade-up delay-2" style="margin-top:1.5rem">
  <div class="card-m-body" style="text-align:center;padding:3rem">
    <i class="fas fa-history" style="font-size:3rem;color:var(--ink-l);margin-bottom:1rem"></i>
    <p style="color:var(--ink-m)">Tidak ada activity log ditemukan.</p>
  </div>
</div>
@else
<div class="card-m fade-up delay-2" style="margin-top:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="fas fa-list"></i> Riwayat Aktivitas ({{ $logs->total() }})</div>
  </div>
  <div style="overflow-x:auto">
    <table class="table-m">
      <thead>
        <tr>
          <th style="width:180px">Waktu</th>
          <th style="width:200px">Aksi</th>
          <th>Target</th>
          <th style="width:150px">User</th>
          <th style="width:120px">IP Address</th>
        </tr>
      </thead>
      <tbody>
        @foreach($logs as $log)
        <tr>
          <td>
            <div style="font-weight:600;color:var(--ink)">{{ $log->created_at->format('d/m/Y') }}</div>
            <div style="font-size:.75rem;color:var(--ink-m)">{{ $log->created_at->format('H:i:s') }}</div>
          </td>
          <td>
            <span class="badge-m" style="background:{{ $log->_badge_bg }};color:{{ $log->_badge_color }}">
              {{ $log->_action_label }}
            </span>
          </td>
          <td>
            @if($log->model_type && $log->model_id)
            <div style="font-weight:600;color:var(--ink)">{{ $log->model_type }} #{{ $log->model_id }}</div>
            @else
            <div style="color:var(--ink-l);font-size:.85rem">-</div>
            @endif
            @if($log->detail)
            <div style="font-size:.75rem;color:var(--ink-m)">{{ $log->_details_summary }}</div>
            @endif
          </td>
          <td>
            <div style="font-weight:600;color:var(--ink)">{{ $log->user_name }}</div>
            <div style="font-size:.75rem;color:var(--ink-m)">{{ $log->user_type }}</div>
          </td>
          <td style="font-family:monospace;font-size:.8rem;color:var(--ink-m)">{{ $log->ip_address }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="fade-up delay-3" style="margin-top:2rem">
  {{ $logs->links() }}
</div>
@endif

@endsection
