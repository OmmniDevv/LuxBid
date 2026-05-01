<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Laporan Hasil Lelang — Lux Bid</title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial,Helvetica,sans-serif;background:#fff;color:#1C1A15;font-size:10pt}

/* Header */
.doc-header{background:#1C1A15;padding:18px 24px 14px;margin-bottom:0}
.header-row{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px}
.logo-name{font-size:16pt;font-weight:700;color:#fff}
.logo-name span{color:#B8860B}
.logo-tag{font-size:7pt;color:rgba(250,247,240,.45);letter-spacing:.08em;text-transform:uppercase;margin-top:2px}
.doc-meta{text-align:right;font-size:7.5pt;color:rgba(250,247,240,.55);line-height:1.8}
.doc-meta strong{color:rgba(250,247,240,.85);display:block}
.doc-title{font-size:15pt;font-weight:700;color:#fff}
.doc-title span{color:#B8860B}
.doc-by{font-size:7.5pt;color:rgba(250,247,240,.45);margin-top:3px}

/* Summary */
.summary-table{width:100%;border-collapse:collapse;border-bottom:1px solid rgba(184,134,11,.25)}
.sum-cell{width:25%;padding:12px 10px;text-align:center;border-right:1px solid rgba(184,134,11,.2);vertical-align:middle}
.sum-cell:last-child{border-right:none}
.sum-label{font-size:6.5pt;text-transform:uppercase;letter-spacing:.07em;color:#7A7260;margin-bottom:3px}
.sum-value{font-size:14pt;font-weight:700;color:#1C1A15}
.sum-value.gold{color:#B8860B;font-size:10pt}

/* Section label */
.section-label{padding:7px 14px 5px;font-size:6.5pt;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#B8860B;background:#FDF8EE;border-bottom:1px solid rgba(184,134,11,.2)}

/* Data table */
table.data{width:100%;border-collapse:collapse}
table.data thead tr{background:#EDE8DC}
table.data th{padding:6px 10px;font-size:6.5pt;font-weight:700;color:#7A7260;text-transform:uppercase;letter-spacing:.05em;text-align:left;border-bottom:2px solid rgba(184,134,11,.2)}
table.data td{padding:6px 10px;font-size:8pt;color:#1C1A15;border-bottom:1px solid #EDE8DC;vertical-align:middle}
table.data tbody tr:last-child td{border-bottom:none}
table.data tbody tr.even td{background:#FDFAF5}
.badge{display:inline;padding:1px 6px;border-radius:8px;font-size:6.5pt;font-weight:700}
.badge-open{background:#EEF9F4;color:#1D6A47}
.badge-closed{background:#EDE8DC;color:#7A7260}
.badge-pending{background:#FFF4E5;color:#A85B00}
.price-final{font-weight:700;color:#1D6A47}
.no-data{text-align:center;padding:20px;color:#7A7260;font-size:8pt}

/* Footer */
.doc-footer{background:#FDF8EE;border-top:2px solid rgba(184,134,11,.2);padding:8px 14px;margin-top:0}
.footer-inner{display:flex;justify-content:space-between}
.footer-l{font-size:7pt;color:#7A7260;line-height:1.7}
.footer-r{font-size:6.5pt;color:#7A7260;text-align:right;line-height:1.7}
</style>
</head>
<body>

<div class="doc-header">
  <div class="header-row">
    <div>
      <div class="logo-name">Lux<span>Bid</span></div>
      <div class="logo-tag">Platform Pelelangan Online</div>
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

<table class="summary-table">
  <tr>
    <td class="sum-cell">
      <div class="sum-label">Lelang Selesai</div>
      <div class="sum-value">{{ $total_selesai }}</div>
    </td>
    <td class="sum-cell">
      <div class="sum-label">Lelang Aktif</div>
      <div class="sum-value">{{ $total_aktif }}</div>
    </td>
    <td class="sum-cell">
      <div class="sum-label">Total Penawaran</div>
      <div class="sum-value">{{ $total_penawaran }}</div>
    </td>
    <td class="sum-cell">
      <div class="sum-label">Nilai Transaksi</div>
      <div class="sum-value gold">Rp {{ number_format($total_nilai,0,',','.') }}</div>
    </td>
  </tr>
</table>

<div class="section-label">Data Hasil Lelang</div>

<table class="data">
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
    <tr class="{{ $i % 2 === 1 ? 'even' : '' }}">
      <td style="color:#7A7260">{{ $i + 1 }}</td>
      <td><strong>{{ $d->barang->nama_barang ?? '[Data tidak tersedia]' }}</strong></td>
      <td style="color:#7A7260">{{ $d->barang->nama_penjual ?? '—' }}</td>
      <td style="color:#7A7260">{{ $d->tgl_lelang ?? '-' }}</td>
      <td>
        @if($d->status === 'dibuka')
          <span style="color:#7A7260;font-style:italic">Masih berlangsung</span>
        @elseif($d->_pemenang)
          {{ $d->_pemenang }}
        @else
          <span style="color:#7A7260">Tidak ada pemenang</span>
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

<div class="doc-footer">
  <div class="footer-inner">
    <div class="footer-l">
      <strong>LuxBid &mdash; Platform Pelelangan Online</strong><br>
      Laporan ini digenerate oleh: <strong>{{ $username }}</strong>
    </div>
    <div class="footer-r">
      Dicetak: {{ now()->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB<br>
      &copy; 2026 LuxBid &middot; TEAM HUNTERS
    </div>
  </div>
</div>

</body>
</html>
