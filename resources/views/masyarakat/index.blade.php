@extends('layouts.masyarakat')
@section('content')
<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Selamat Datang, {{ session('username') }}!</h1>
    <p class="page-sub">Anda sudah login sebagai peserta lelang. Mulai ajukan penawaran sekarang.</p>
  </div>
</div>

<div class="stat-grid fade-up delay-1">
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-trophy"></i></div><div class="stat-card-n">{{ $jumlah_aktif }}</div><div class="stat-card-l">Lelang Aktif</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-card-list"></i></div><div class="stat-card-n">{{ $jumlah_penawaran }}</div><div class="stat-card-l">Penawaran Saya</div></div>
  <div class="stat-card"><div class="stat-card-ico"><i class="bi bi-check-circle"></i></div><div class="stat-card-n">Aktif</div><div class="stat-card-l">Status Akun</div></div>
</div>

<div class="card-m fade-up delay-2" style="margin-bottom:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-bullseye"></i> Panduan Cepat</div>
  </div>
  <div class="card-m-body">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem">
      <a href="{{ route('masyarakat.penawaran') }}" style="text-decoration:none">
        <div style="background:var(--gold-p);border:1px solid var(--gold-ln);border-radius:var(--rs);padding:1.25rem;transition:transform .22s" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
          <div style="font-size:1.75rem;margin-bottom:.5rem"><i class="bi bi-hammer"></i></div>
          <div style="font-size:.9rem;font-weight:600;color:var(--ink);margin-bottom:.2rem">Lihat & Ikuti Lelang</div>
          <div style="font-size:.78rem;color:var(--ink-m)">Temukan barang lelang aktif dan ajukan penawaran terbaik Anda</div>
        </div>
      </a>
      <div style="background:var(--cream);border:1px solid var(--cream-dd);border-radius:var(--rs);padding:1.25rem">
        <div style="font-size:1.75rem;margin-bottom:.5rem"><i class="bi bi-bar-chart-line"></i></div>
        <div style="font-size:.9rem;font-weight:600;color:var(--ink);margin-bottom:.2rem">Pantau Penawaran</div>
        <div style="font-size:.78rem;color:var(--ink-m)">Lihat histori dan status penawaran Anda di halaman Penawaran</div>
      </div>
      <div style="background:var(--cream);border:1px solid var(--cream-dd);border-radius:var(--rs);padding:1.25rem">
        <div style="font-size:1.75rem;margin-bottom:.5rem"><i class="bi bi-award"></i></div>
        <div style="font-size:.9rem;font-weight:600;color:var(--ink);margin-bottom:.2rem">Menangkan Lelang</div>
        <div style="font-size:.78rem;color:var(--ink-m)">Penawar tertinggi saat waktu habis menjadi pemenang resmi</div>
      </div>
    </div>
    <div style="margin-top:1.5rem">
      <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-primary-m btn-lg-m"><i class="fas fa-gavel"></i> Mulai Ikuti Lelang →</a>
    </div>
  </div>
</div>

<div class="card-m fade-up delay-3">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-lightning-charge"></i> Lelang Aktif Saat Ini</div>
    <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-outline-m btn-sm-m">Lihat Semua →</a>
  </div>
  <div class="card-m-body" style="padding:1rem">
    @if($rows->isEmpty())
      <div style="text-align:center;padding:2.5rem;color:var(--ink-m)">
        <div style="font-size:2rem;opacity:.3;margin-bottom:.5rem"><i class="bi bi-box-seam"></i></div>
        <div style="font-size:.88rem">Belum ada lelang yang sedang berjalan.</div>
      </div>
    @else
      <div style="display:flex;flex-direction:column;gap:.75rem">
        @foreach($rows as $l)
        @php $harga_tampil = $l->penawaran_tertinggi ?? $l->barang->harga_awal; @endphp
        <div style="display:flex;align-items:center;gap:1rem;background:var(--cream);border:1px solid var(--gold-ln);border-radius:var(--rs);overflow:hidden;transition:box-shadow .22s,transform .22s" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(184,134,11,.12)'" onmouseout="this.style.transform='none';this.style.boxShadow='none'">
          <div style="flex-shrink:0;width:90px;height:90px;overflow:hidden">
            @if($l->foto)
              <img src="{{ asset('uploads/barang/'.$l->foto) }}" style="width:90px;height:90px;object-fit:cover;display:block" alt="{{ $l->barang->nama_barang }}">
            @else
              <div style="width:90px;height:90px;background:var(--cream-d);display:flex;align-items:center;justify-content:center;font-size:2rem"><i class="bi bi-box-seam"></i></div>
            @endif
          </div>
          <div style="flex:1;min-width:0;padding:.75rem 0">
            <div style="font-size:.67rem;color:var(--ink-m);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.15rem">Lot #{{ str_pad($l->id_lelang,4,'0',STR_PAD_LEFT) }} · {{ \Carbon\Carbon::parse($l->tgl_lelang)->format('d M Y') }}</div>
            <div style="font-family:'Playfair Display',serif;font-weight:700;color:var(--ink);font-size:1rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $l->barang->nama_barang }}</div>
            <div style="font-size:.72rem;color:var(--ink-m);margin-top:.2rem">{{ $l->jumlah_penawar }} penawar</div>
          </div>
          <div style="text-align:right;flex-shrink:0;padding:.75rem">
            <div style="font-size:.67rem;color:var(--ink-m);margin-bottom:.1rem">{{ $l->penawaran_tertinggi ? 'Tertinggi' : 'Harga Awal' }}</div>
            <div style="font-family:'Playfair Display',serif;font-size:1.05rem;color:var(--success);font-weight:700">Rp {{ number_format($harga_tampil,0,',','.') }}</div>
          </div>
          <div style="flex-shrink:0;padding:.75rem">
            <a href="{{ route('masyarakat.penawaran') }}" class="btn-m btn-primary-m btn-sm-m"><i class="fas fa-gavel"></i> Tawar</a>
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
