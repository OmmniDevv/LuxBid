
<!DOCTYPE html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title>Laporan Lelang — Lux Bid</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial,sans-serif;font-size:12px;color:#333;padding:20px}
h1{font-size:18px;margin-bottom:4px}
p{font-size:11px;color:#666;margin-bottom:16px}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #ddd;padding:6px 8px;text-align:left}
th{background:#f5f5f5;font-weight:600}
tr:nth-child(even){background:#fafafa}
@media print{button{display:none}}
</style>
</head><body>
<h1>Laporan Hasil Lelang — Lux Bid</h1>
<p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
<table>
  <thead><tr><th>#</th><th>Nama Barang</th><th>Penjual</th><th>Tanggal</th><th>Pemenang</th><th>Harga Awal</th><th>Harga Akhir</th><th>Status</th></tr></thead>
  <tbody>
    @foreach($rows as $i=>$d)
    <tr>
      <td>{{ $i+1 }}</td>
      <td>{{ $d->barang->nama_barang ?? '[Data tidak tersedia]' }}</td>
      <td>{{ $d->barang->nama_penjual ?? '—' }}</td>
      <td>{{ $d->tgl_lelang }}</td>
      <td>{{ $d->_pemenang ?? '—' }}</td>
      <td>{{ $d->barang ? 'Rp '.number_format($d->barang->harga_awal) : '—' }}</td>
      <td>{{ $d->_harga_tertinggi ? 'Rp '.number_format($d->_harga_tertinggi) : '—' }}</td>
      <td>{{ ucfirst($d->status) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<script>window.onload=()=>window.print()</script>
</body></html>
