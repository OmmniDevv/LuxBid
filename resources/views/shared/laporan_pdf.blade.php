<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Laporan Hasil Lelang — Lux Bid</title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

body{font-family:Arial,Helvetica,sans-serif;background:#FAF7F0;color:#1C1A15;padding:1.5rem}

/* Screen toolbar — hidden in PDF */
.toolbar{display:flex;align-items:center;justify-content:space-between;background:#fff;border:1px solid rgba(184,134,11,.25);border-radius:10px;padding:.9rem 1.25rem;margin-bottom:1.5rem}
.toolbar-title{font-size:.95rem;font-weight:700;color:#1C1A15}
.toolbar-title span{color:#B8860B}
.toolbar-btns{display:flex;gap:.5rem}
.btn-tool{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1rem;border-radius:100px;font-size:.8rem;font-weight:600;cursor:pointer;border:none;text-decoration:none}
.btn-print{background:#1C1A15;color:#FAF7F0}
.btn-pdf{background:#B8860B;color:#1C1A15}
.btn-back{background:#EDE8DC;color:#7A7260}

/* Document */
.doc{max-width:960px;margin:0 auto;background:#fff;border:1px solid rgba(184,134,11,.25);border-radius:12px;overflow:hidden}

/* Header */
.doc-header{background:#1C1A15;padding:2rem 2.5rem 1.75rem}
.header-row{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem}
.logo-box{display:flex;align-items:center;gap:.65rem}
.logo-sq{width:44px;height:44px;background:#FDF8EE;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:700;color:#B8860B;font-family:Georgia,serif}
.logo-name{font-family:Georgia,serif;font-size:1.3rem;font-weight:700;color:#fff}
.logo-name span{color:#B8860B}
.logo-tag{font-size:.65rem;color:rgba(250,247,240,.4);letter-spacing:.1em;text-transform:uppercase;margin-top:.1rem}
.doc-meta{text-align:right;font-size:.72rem;color:rgba(250,247,240,.5);line-height:1.8}
.doc-meta strong{color:rgba(250,247,240,.8);display:block;font-size:.75rem}
.doc-title{font-family:Georgia,serif;font-size:1.6rem;font-weight:700;color:#fff}
.doc-title span{color:#B8860B}
.doc-by{font-size:.78rem;color:rgba(250,247,240,.45);margin-top:.25rem}

/* Summary */
.summary{display:table;width:100%;border-bottom:1px solid rgba(184,134,11,.2)}
.sum-card{display:table-cell;width:25%;padding:1.25rem 1rem;text-align:center;border-right:1px solid rgba(184,134,11,.2);vertical-align:middle}
.sum-card:last-child{border-right:none}
.sum-label{font-size:.65rem;text-transform:uppercase;letter-spacing:.08em;color:#7A7260;margin-bottom:.3rem}
.sum-value{font-family:Georgia,serif;font-size:1.4rem;font-weight:700;color:#1C1A15}
.sum-value.gold{color:#B8860B;font-size:1rem}

/* Table section */
.section-label{padding:.9rem 1.5rem .6rem;font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#B8860B;background:#FDF8EE;border-bottom:1px solid rgba(184,134,11,.2)}

table{width:100%;border-collapse:collapse}
thead tr{background:#EDE8DC}
th{padding:.65rem 1rem;font-size:.68rem;font-weight:700;color:#7A7260;text-transform:uppercase;letter-spacing:.06em;text-align:left;border-bottom:2px solid rgba(184,134,11,.2)}
td{padding:.7rem 1rem;font-size:.8rem;color:#1C1A15;border-bottom:1px solid #EDE8DC;vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
tbody tr:nth-child(even) td{background:#FDFAF5}
.badge{display:inline-block;padding:.15rem .55rem;border-radius:100px;font-size:.65rem;font-weight:700}
.badge-open{background:#EEF9F4;color:#1D6A47}
.badge-closed{background:#EDE8DC;color:#7A7260}
.badge-pending{background:#FFF4E5;color:#A85B00}
.price-final{font-weight:700;color:#1D6A47}
.no-data{text-align:center;padding:2.5rem;color:#7A7260;font-size:.82rem}

/* Footer */
.doc-footer{background:#FDF8EE;border-top:2px solid rgba(184,134,11,.2);padding:1rem 1.5rem;display:flex;justify-content:space-between;align-items:center}
.doc-footer-l{font-size:.7rem;color:#7A7260;line-height:1.7}
.doc-footer-l strong{color:#1C1A15}
.doc-footer-r{font-size:.68rem;color:#7A7260;text-align:right;line-height:1.7}

/* Print / PDF */
@media print {
  @page{size:A4 landscape;margin:1cm 1.2cm}
  body{background:#fff!important;padding:0!important}
  .toolbar{display:none!important}
  .doc{max-width:100%!important;border:none!important;border-radius:0!important}
  .doc-header{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .summary,.sum-card,.section-label,thead tr,.doc-footer{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  tbody tr:nth-child(even) td{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .badge{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  td,th{font-size:8pt!important;padding:.45rem .7rem!important}
}
</style>
</head>
<body>

@php $mode = $mode ?? 'print'; @endphp

{{-- Screen toolbar (hidden in PDF render) --}}
@if($mode !== 'pdf_render')
<div class="toolbar">
  <div class="toolbar-title">Lux<span>Bid</span> &mdash; Preview Laporan</div>
  <div class="toolbar-btns">
    <button class="btn-tool btn-back" onclick="window.close()">Tutup</button>
    <button class="btn-tool btn-print" onclick="window.print()">Print</button>
  </div>
</div>
@endif

<div class="doc">

  {{-- Header --}}
  <div class="doc-header">
    <div class="header-row">
      <div class="logo-box">
        <div class="logo-sq">L</div>
        <div>
          <div class="logo-name">Lux<span>Bid</span></div>
          <div class="logo-tag">Platform Pelelangan Online</div>
        </div>
      </div>
      <div class="doc-meta">
        <strong>Tanggal Generate</strong>
        {{ now()->timezone('Asia/Jakarta')->format('d/m/Y') }}<br>
        Pukul {{ now()->timezone('Asia/Jakarta')->format('H:i') }} WIB
      </div>
    </div>
    <div class="doc-title">Laporan Hasil <span>Lelang</span></div>
    <div class="doc-by">Digenerate oleh: {{ $username }}</div>
  </div>

  {{-- Summary --}}
  <div class="summary">
    <div class="sum-card">
      <div class="sum-label">Lelang Selesai</div>
      <div class="sum-value">{{ $total_selesai }}</div>
    </div>
    <div class="sum-card">
      <div class="sum-label">Lelang Aktif</div>
      <div class="sum-value">{{ $total_aktif }}</div>
    </div>
    <div class="sum-card">
      <div class="sum-label">Total Penawaran</div>
      <div class="sum-value">{{ $total_penawaran }}</div>
    </div>
    <div class="sum-card">
      <div class="sum-label">Nilai Transaksi</div>
      <div class="sum-value gold">Rp {{ number_format($total_nilai,0,',','.') }}</div>
    </div>
  </div>

  {{-- Table --}}
  <div class="section-label">Data Hasil Lelang</div>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Barang</th>
        <th>Penjual</th>
        <th>Tanggal Lelang</th>
        <th>Pemenang</th>
        <th>Harga Awal</th>
        <th>Harga Akhir</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $i => $d)
      <tr>
        <td style="color:#7A7260">{{ $i + 1 }}</td>
        <td><strong>{{ $d->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
        <td style="color:#7A7260">{{ $d->barang->nama_penjual ?? '—' }}</td>
        <td style="color:#7A7260">{{ $d->tgl_lelang ?? '-' }}</td>
        <td>
          @if($d->status === 'dibuka')
            <span style="color:#7A7260;font-style:italic;font-size:.75rem">Masih berlangsung</span>
          @elseif($d->_pemenang)
            {{ $d->_pemenang }}
          @else
            <span style="color:#7A7260;font-size:.75rem">Tidak ada pemenang</span>
          @endif
        </td>
        <td style="color:#7A7260">{{ $d->barang ? 'Rp '.number_format($d->barang->harga_awal,0,',','.') : '—' }}</td>
        <td class="{{ ($d->status === 'ditutup' && $d->_harga_tertinggi) ? 'price-final' : '' }}">
          {{ ($d->status === 'ditutup' && $d->_harga_tertinggi) ? 'Rp '.number_format($d->_harga_tertinggi,0,',','.') : '-' }}
        </td>
        <td>
          @if($d->status === 'dibuka')
            <span class="badge badge-open">Dibuka</span>
          @elseif($d->status === 'ditutup')
            <span class="badge badge-closed">Selesai</span>
          @else
            <span class="badge badge-pending">Belum Aktif</span>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="7" class="no-data">Belum ada data lelang.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{-- Footer --}}
  <div class="doc-footer">
    <div class="doc-footer-l">
      <strong>LuxBid &mdash; Platform Pelelangan Online</strong>
      Laporan ini digenerate oleh: <strong>{{ $username }}</strong>
    </div>
    <div class="doc-footer-r">
      Dicetak: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB<br>
      &copy; 2026 LuxBid &middot; TEAM HUNTERS
    </div>
  </div>

</div>

@if($mode === 'print')
<script>
window.addEventListener('load', function() { setTimeout(function(){ window.print(); }, 300); });
</script>
@endif

</body>
</html>
