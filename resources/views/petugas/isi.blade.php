
<div style="overflow-x:auto">
<table class="table-m">
  <thead><tr><th>#</th><th>Nama Barang</th><th>Penawar Tertinggi</th><th>Penawaran Tertinggi</th><th>Harga Awal</th></tr></thead>
  <tbody>
    @forelse($lelang_aktif as $i=>$l)
    <tr>
      <td style="color:var(--ink-l)">{{ $i+1 }}</td>
      <td><strong>{{ $l->barang->nama_barang }}</strong></td>
      <td>@if($l->_pemenang){{ $l->_pemenang }}@else<span style="color:var(--ink-l);font-size:.8rem">Belum ada penawaran</span>@endif</td>
      <td style="font-weight:700;color:var(--success)">{{ $l->_harga_tertinggi ? 'Rp '.number_format($l->_harga_tertinggi, 0, ',', '.') : '—' }}</td>
      <td style="color:var(--ink-m)">Rp {{ number_format($l->barang->harga_awal, 0, ',', '.') }}</td>
    </tr>
    @empty
    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--ink-m)">Tidak ada lelang aktif saat ini.</td></tr>
    @endforelse
  </tbody>
</table>
</div>
