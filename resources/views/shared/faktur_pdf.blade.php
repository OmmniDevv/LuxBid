<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Faktur {{ $nomor_faktur }} — LuxBid</title>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:Georgia,serif;background:#fff;color:#1C1A15;font-size:10pt;margin:0;padding:0}

/* ── Watermark ── */
.watermark{position:fixed;top:50%;left:50%;transform:translate(-50%,-50%) rotate(-35deg);font-size:72pt;font-weight:700;color:rgba(184,134,11,.04);letter-spacing:.2em;text-transform:uppercase;pointer-events:none;z-index:0;white-space:nowrap}

/* ── Page wrapper ── */
.page{position:relative;z-index:1}

/* ── Header band ── */
.header-band{background:#1C1A15;padding:0}
.header-top{padding:22px 36px 0;display:flex;justify-content:space-between;align-items:flex-start}
.logo-area{}
.logo-wordmark{font-size:22pt;font-weight:700;color:#fff;letter-spacing:-.02em;line-height:1}
.logo-wordmark span{color:#B8860B}
.logo-sub{font-size:6.5pt;color:rgba(250,247,240,.35);letter-spacing:.18em;text-transform:uppercase;margin-top:4px}
.faktur-meta{text-align:right}
.faktur-type{font-size:7pt;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:rgba(184,134,11,.7);margin-bottom:4px}
.faktur-num{font-size:13pt;font-weight:700;color:#fff;letter-spacing:.04em}
.faktur-date{font-size:7pt;color:rgba(250,247,240,.35);margin-top:3px}

/* Gold divider line */
.gold-line{height:2px;background:linear-gradient(90deg,transparent,#B8860B 20%,#D4A017 50%,#B8860B 80%,transparent);margin:16px 36px 0}

/* Header bottom strip */
.header-bottom{padding:12px 36px 18px;display:flex;justify-content:space-between;align-items:center}
.doc-label{font-size:8pt;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(250,247,240,.45)}

/* Status badge */
.status-badge{display:inline-block;padding:4px 14px;border-radius:2px;font-size:7pt;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
.badge-pending{background:rgba(184,134,11,.15);color:#D4A017;border:1px solid rgba(184,134,11,.3)}
.badge-paid{background:rgba(29,106,71,.2);color:#4CAF82;border:1px solid rgba(29,106,71,.3)}

/* ── Body ── */
.body{padding:28px 36px}

/* Section header */
.sec-head{display:flex;align-items:center;gap:8px;margin-bottom:10px}
.sec-head-line{flex:1;height:1px;background:linear-gradient(90deg,rgba(184,134,11,.3),transparent)}
.sec-label{font-size:6.5pt;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#B8860B;white-space:nowrap}

/* Two-col info */
.info-row{display:table;width:100%;margin-bottom:22px}
.info-col{display:table-cell;width:50%;vertical-align:top}
.info-col.right{padding-left:24px;border-left:1px solid rgba(184,134,11,.15)}
.info-col.left{padding-right:24px}
.field{margin-bottom:9px}
.field-label{font-size:6.5pt;letter-spacing:.1em;text-transform:uppercase;color:#7A7260;font-family:Arial,sans-serif;margin-bottom:2px}
.field-value{font-size:9.5pt;font-weight:700;color:#1C1A15}
.field-value.accent{color:#B8860B}
.field-value.mono{font-family:'Courier New',monospace;font-size:9pt;letter-spacing:.05em}

/* Barang card */
.barang-wrap{background:#FAF7F0;border:1px solid rgba(184,134,11,.2);border-radius:4px;padding:18px 20px;margin-bottom:22px;position:relative;overflow:hidden}
.barang-wrap::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:linear-gradient(180deg,#B8860B,#D4A017)}
.barang-id{font-size:6.5pt;font-family:Arial,sans-serif;letter-spacing:.1em;text-transform:uppercase;color:#B8860B;margin-bottom:4px}
.barang-name{font-size:13pt;font-weight:700;color:#1C1A15;margin-bottom:6px;line-height:1.2}
.barang-desc{font-size:8pt;color:#7A7260;line-height:1.65;margin-bottom:12px;font-family:Arial,sans-serif}
.barang-attrs{display:table;width:100%}
.attr{display:table-cell;width:33.33%}
.attr-label{font-size:6pt;letter-spacing:.1em;text-transform:uppercase;color:#7A7260;font-family:Arial,sans-serif;margin-bottom:2px}
.attr-value{font-size:8.5pt;font-weight:700;color:#1C1A15}

/* Harga table */
.harga-wrap{margin-bottom:22px}
.harga-table{width:100%;border-collapse:collapse}
.harga-table tr td{padding:7px 0;font-family:Arial,sans-serif;font-size:8.5pt;border-bottom:1px solid rgba(237,232,220,.8)}
.harga-table tr:last-child td{border-bottom:none}
.harga-table .lbl{color:#7A7260}
.harga-table .val{text-align:right;font-weight:600;color:#1C1A15}
.harga-total-row{background:#1C1A15;margin-top:6px}
.harga-total{display:flex;justify-content:space-between;align-items:center;background:#1C1A15;padding:11px 14px;border-radius:3px;margin-top:6px}
.harga-total .lbl{font-size:7.5pt;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(250,247,240,.55);font-family:Arial,sans-serif}
.harga-total .val{font-size:13pt;font-weight:700;color:#B8860B;font-family:Georgia,serif}

/* Instruksi */
.instruksi{border:1px solid rgba(184,134,11,.2);border-radius:4px;padding:14px 16px;margin-bottom:20px;background:#FFFDF7}
.instruksi-title{font-size:7.5pt;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#1C1A15;margin-bottom:8px;font-family:Arial,sans-serif}
.instruksi p{font-size:8pt;color:#3A3527;line-height:1.75;margin-bottom:5px;font-family:Arial,sans-serif}
.instruksi p:last-child{margin-bottom:0}
.instruksi strong{color:#1C1A15}
.deadline{display:inline-block;background:rgba(184,134,11,.1);border:1px solid rgba(184,134,11,.25);border-radius:2px;padding:2px 8px;font-size:7.5pt;font-weight:700;color:#B8860B;font-family:Arial,sans-serif;letter-spacing:.05em}

/* Kontak grid */
.kontak-grid{display:table;width:100%;margin-bottom:20px}
.kontak-cell{display:table-cell;width:33.33%;vertical-align:top;padding-right:12px}
.kontak-cell:last-child{padding-right:0}
.kontak-label{font-size:6pt;letter-spacing:.1em;text-transform:uppercase;color:#7A7260;font-family:Arial,sans-serif;margin-bottom:3px}
.kontak-value{font-size:8.5pt;font-weight:700;color:#1C1A15;font-family:Arial,sans-serif}
.kontak-sub{font-size:7pt;color:#7A7260;font-family:Arial,sans-serif;margin-top:1px}

/* Stamp area */
.stamp-row{display:flex;justify-content:space-between;align-items:flex-end;margin-top:4px}
.stamp-box{border:1.5px solid rgba(184,134,11,.25);border-radius:3px;padding:8px 20px;text-align:center}
.stamp-label{font-size:6.5pt;letter-spacing:.1em;text-transform:uppercase;color:#7A7260;font-family:Arial,sans-serif;margin-bottom:16px}
.stamp-sign{font-size:7pt;color:#7A7260;font-family:Arial,sans-serif;border-top:1px solid rgba(184,134,11,.3);padding-top:5px;margin-top:0}
.doc-valid{font-size:7pt;color:rgba(184,134,11,.5);font-family:Arial,sans-serif;letter-spacing:.08em;text-align:right;line-height:1.8}

/* ── Footer band ── */
.footer-gold-line{height:1px;background:linear-gradient(90deg,transparent,#B8860B 20%,#D4A017 50%,#B8860B 80%,transparent);margin:0 36px}
.footer-band{background:#1C1A15;padding:10px 36px;display:flex;justify-content:space-between;align-items:center}
.footer-l{font-size:6.5pt;color:rgba(250,247,240,.3);font-family:Arial,sans-serif;line-height:1.7}
.footer-r{font-size:6.5pt;color:rgba(250,247,240,.3);font-family:Arial,sans-serif;text-align:right;line-height:1.7}
.footer-r strong{color:rgba(184,134,11,.6)}
</style>
</head>
<body>

<div class="watermark">LUXBID</div>

<div class="page">

  {{-- ── Header ── --}}
  <div class="header-band">
    <div class="header-top">
      <div class="logo-area">
        <div class="logo-wordmark">Lux<span>Bid</span></div>
        <div class="logo-sub">Platform Pelelangan Online</div>
      </div>
      <div class="faktur-meta">
        <div class="faktur-type">Faktur Resmi</div>
        <div class="faktur-num">{{ $nomor_faktur }}</div>
        <div class="faktur-date">Diterbitkan {{ $tgl_cetak }} WIB</div>
      </div>
    </div>
    <div class="gold-line"></div>
    <div class="header-bottom">
      <div class="doc-label">Dokumen Hasil Lelang &mdash; Konfidensial</div>
      <span class="status-badge badge-pending">Menunggu Konfirmasi</span>
    </div>
  </div>

  <div class="body">

    {{-- ── Info Pemenang & Lelang ── --}}
    <div class="sec-head">
      <div class="sec-label">Informasi Transaksi</div>
      <div class="sec-head-line"></div>
    </div>
    <div class="info-row">
      <div class="info-col left">
        <div class="field">
          <div class="field-label">Nama Pemenang</div>
          <div class="field-value">{{ $pemenang->nama_lengkap ?? '-' }}</div>
        </div>
        <div class="field">
          <div class="field-label">Username</div>
          <div class="field-value mono">{{ $pemenang->username ?? '-' }}</div>
        </div>
        <div class="field">
          <div class="field-label">Nomor Telepon</div>
          <div class="field-value">{{ $pemenang->telp ?? '-' }}</div>
        </div>
      </div>
      <div class="info-col right">
        <div class="field">
          <div class="field-label">Nomor Faktur</div>
          <div class="field-value accent mono">{{ $nomor_faktur }}</div>
        </div>
        <div class="field">
          <div class="field-label">Tanggal Lelang</div>
          <div class="field-value">{{ $lelang->tgl_lelang ?? '-' }}</div>
        </div>
        <div class="field">
          <div class="field-label">ID Sesi Lelang</div>
          <div class="field-value mono">#{{ str_pad($lelang->id_lelang, 5, '0', STR_PAD_LEFT) }}</div>
        </div>
      </div>
    </div>

    {{-- ── Detail Barang ── --}}
    <div class="sec-head">
      <div class="sec-label">Detail Barang</div>
      <div class="sec-head-line"></div>
    </div>
    <div class="barang-wrap">
      <div class="barang-id">ID Barang &nbsp;#{{ str_pad($barang->id_barang, 4, '0', STR_PAD_LEFT) }}</div>
      <div class="barang-name">{{ $barang->nama_barang }}</div>
      @if($barang->deskripsi_barang)
      <div class="barang-desc">{{ $barang->deskripsi_barang }}</div>
      @endif
      <div class="barang-attrs">
        <div class="attr">
          <div class="attr-label">Tanggal Masuk</div>
          <div class="attr-value">{{ $barang->tgl ?? '-' }}</div>
        </div>
        <div class="attr">
          <div class="attr-label">Harga Awal</div>
          <div class="attr-value">Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}</div>
        </div>
        <div class="attr">
          <div class="attr-label">Penjual / Pemilik</div>
          <div class="attr-value">{{ $barang->nama_penjual ?: '-' }}</div>
        </div>
      </div>
    </div>

    {{-- ── Ringkasan Harga ── --}}
    <div class="sec-head">
      <div class="sec-label">Ringkasan Pembayaran</div>
      <div class="sec-head-line"></div>
    </div>
    <div class="harga-wrap">
      <table class="harga-table">
        <tr>
          <td class="lbl">Harga Awal Barang</td>
          <td class="val">Rp {{ number_format($barang->harga_awal, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td class="lbl">Harga Penawaran Tertinggi</td>
          <td class="val">Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</td>
        </tr>
        <tr>
          <td class="lbl">Biaya Administrasi</td>
          <td class="val" style="color:#7A7260">Rp 0 (Gratis)</td>
        </tr>
      </table>
      <div class="harga-total">
        <div class="lbl">Total yang Harus Dibayar</div>
        <div class="val">Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</div>
      </div>
    </div>

    {{-- ── Instruksi ── --}}
    <div class="sec-head">
      <div class="sec-label">Instruksi Selanjutnya</div>
      <div class="sec-head-line"></div>
    </div>
    <div class="instruksi">
      <div class="instruksi-title">Langkah Konfirmasi Pembayaran &amp; Pengambilan Barang</div>
      <p>Selamat, Anda telah memenangkan lelang ini. Harap segera menghubungi tim admin LuxBid untuk mengkonfirmasi pembayaran dan mengatur jadwal pengambilan barang.</p>
      <p>Batas waktu konfirmasi: <span class="deadline">3 &times; 24 Jam</span> sejak faktur ini diterbitkan. Keterlambatan dapat mengakibatkan pembatalan status kemenangan.</p>
      <p>Tunjukkan nomor faktur <strong>{{ $nomor_faktur }}</strong> kepada petugas saat melakukan konfirmasi pembayaran.</p>
    </div>

    {{-- ── Kontak Admin ── --}}
    <div class="sec-head">
      <div class="sec-label">Hubungi Admin</div>
      <div class="sec-head-line"></div>
    </div>
    <div class="kontak-grid">
      <div class="kontak-cell">
        <div class="kontak-label">WhatsApp</div>
        <div class="kontak-value">+62 858-6907-4622</div>
        <div class="kontak-sub">Respon cepat</div>
      </div>
      <div class="kontak-cell">
        <div class="kontak-label">Email</div>
        <div class="kontak-value">support@luxbid.id</div>
        <div class="kontak-sub">Maks. 1&times;24 jam</div>
      </div>
      <div class="kontak-cell">
        <div class="kontak-label">Jam Operasional</div>
        <div class="kontak-value">Senin &ndash; Jumat</div>
        <div class="kontak-sub">08.00 &ndash; 17.00 WIB</div>
      </div>
    </div>

    {{-- ── Stamp & Validasi ── --}}
    <div class="stamp-row">
      <div class="stamp-box">
        <div class="stamp-label">Tanda Tangan &amp; Cap Admin</div>
        <div class="stamp-sign">LuxBid &mdash; TEAM HUNTERS</div>
      </div>
      <div class="doc-valid">
        Dokumen ini digenerate secara otomatis oleh sistem LuxBid<br>
        dan sah tanpa tanda tangan basah.<br>
        Verifikasi: <strong style="color:rgba(184,134,11,.6)">{{ $nomor_faktur }}</strong>
      </div>
    </div>

  </div>

  {{-- ── Footer ── --}}
  <div class="footer-gold-line"></div>
  <div class="footer-band">
    <div class="footer-l">
      <strong style="color:rgba(250,247,240,.5)">LuxBid &mdash; Platform Pelelangan Online</strong><br>
      SMKN 7 Baleendah, Kab. Bandung, Jawa Barat &nbsp;&middot;&nbsp; support@luxbid.id
    </div>
    <div class="footer-r">
      Faktur <strong>{{ $nomor_faktur }}</strong><br>
      Dicetak {{ $tgl_cetak }} WIB
    </div>
  </div>

</div>
</body>
</html>
