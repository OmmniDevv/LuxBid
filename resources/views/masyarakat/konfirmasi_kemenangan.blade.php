@extends('layouts.masyarakat')
@section('content')
<div class="page-header fade-up">
  <div>
    <h1 class="page-title">Konfirmasi Kemenangan Lelang</h1>
    <p class="page-sub">Konfirmasi kesediaan Anda untuk melanjutkan proses pembayaran dan pengambilan barang.</p>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success fade-up delay-1" style="background:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1.5rem">
  <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger fade-up delay-1" style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;padding:1rem;border-radius:8px;margin-bottom:1.5rem">
  <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

@if(session('info'))
<div class="alert alert-info fade-up delay-1" style="background:#d1ecf1;border:1px solid #bee5eb;color:#0c5460;padding:1rem;border-radius:8px;margin-bottom:1.5rem">
  <i class="fas fa-info-circle"></i> {{ session('info') }}
</div>
@endif

<div class="card-m fade-up delay-2">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-trophy"></i> Detail Kemenangan</div>
    @if($lelang->status_konfirmasi === 'menunggu_konfirmasi')
    <span class="badge-m" style="background:rgba(255,193,7,.15);color:#ffc107;border:1px solid rgba(255,193,7,.3)">Menunggu Konfirmasi</span>
    @elseif($lelang->status_konfirmasi === 'dikonfirmasi')
    <span class="badge-m" style="background:rgba(40,167,69,.15);color:#28a745;border:1px solid rgba(40,167,69,.3)">Dikonfirmasi</span>
    @elseif($lelang->status_konfirmasi === 'dibatalkan')
    <span class="badge-m" style="background:rgba(220,53,69,.15);color:#dc3545;border:1px solid rgba(220,53,69,.3)">Dibatalkan</span>
    @elseif($lelang->status_konfirmasi === 'selesai')
    <span class="badge-m" style="background:rgba(108,117,125,.15);color:#6c757d;border:1px solid rgba(108,117,125,.3)">Selesai</span>
    @endif
  </div>

  <div style="padding:2rem">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:1.5rem;margin-bottom:2rem">
      <div>
        <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--ink-l);margin-bottom:.3rem">Nama Barang</div>
        <div style="font-size:1.1rem;font-weight:700;color:var(--ink)">{{ $lelang->barang->nama_barang }}</div>
      </div>
      <div>
        <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--ink-l);margin-bottom:.3rem">Harga Akhir</div>
        <div style="font-size:1.1rem;font-weight:700;color:var(--gold)">Rp {{ number_format($lelang->harga_akhir, 0, ',', '.') }}</div>
      </div>
      <div>
        <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:.05em;color:var(--ink-l);margin-bottom:.3rem">Nomor Faktur</div>
        <div style="font-size:1rem;font-weight:700;color:var(--ink);font-family:monospace">{{ $lelang->nomor_faktur }}</div>
      </div>
    </div>

    @if($lelang->batas_konfirmasi)
    <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:1rem;margin-bottom:1.5rem">
      <div style="display:flex;align-items:center;gap:.5rem">
        <i class="fas fa-clock" style="color:#856404"></i>
        <div>
          <strong style="color:#856404">Batas Waktu Konfirmasi:</strong>
          <span style="color:#856404">{{ $lelang->batas_konfirmasi->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</span>
          @if(now()->lt($lelang->batas_konfirmasi))
          <span style="color:#856404;font-size:.85rem">({{ now()->diffForHumans($lelang->batas_konfirmasi, true) }} lagi)</span>
          @else
          <span style="color:#dc3545;font-size:.85rem">(Sudah lewat)</span>
          @endif
        </div>
      </div>
    </div>
    @endif

    <div style="background:var(--paper);border:1px solid var(--border);border-radius:8px;padding:1.25rem;margin-bottom:1.5rem">
      <h3 style="font-size:.95rem;font-weight:600;color:var(--ink);margin-bottom:.75rem">📋 Instruksi Selanjutnya</h3>
      <ol style="margin:0;padding-left:1.25rem;color:var(--ink-m);line-height:1.8">
        <li>Konfirmasi kesediaan Anda dengan klik tombol di bawah</li>
        <li>Download faktur PDF untuk bukti transaksi</li>
        <li>Lakukan pembayaran sesuai nominal pada faktur</li>
        <li>Hubungi admin untuk konfirmasi pembayaran dan pengambilan barang</li>
      </ol>
    </div>

    <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem">
      <a href="{{ route('masyarakat.faktur_pdf', $lelang->id_lelang) }}" target="_blank" class="btn-m btn-primary-m">
        <i class="fas fa-file-pdf"></i> Download Faktur PDF
      </a>

      @if($lelang->status_konfirmasi === 'menunggu_konfirmasi')
      <form method="POST" action="{{ route('masyarakat.konfirmasi_kemenangan.konfirmasi', $lelang->id_lelang) }}" style="display:inline">
        @csrf
        <button type="submit" class="btn-m" style="background:var(--success);color:#fff;border:none;cursor:pointer" onclick="return confirm('Apakah Anda yakin untuk mengkonfirmasi kesediaan melanjutkan pembayaran?')">
          <i class="fas fa-check"></i> Konfirmasi Kesediaan
        </button>
      </form>

      <button type="button" class="btn-m btn-secondary-m" onclick="document.getElementById('batalModal').style.display='flex'">
        <i class="fas fa-times"></i> Batalkan
      </button>
      @endif
    </div>

    @if($lelang->status_konfirmasi === 'dikonfirmasi' && !$lelang->bukti_pembayaran)
    <div style="background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem">
      <h3 style="font-size:.95rem;font-weight:600;color:#856404;margin-bottom:.75rem"><i class="fas fa-upload"></i> Upload Bukti Pembayaran</h3>
      <form method="POST" action="{{ route('masyarakat.bukti_bayar.upload', $lelang->id_lelang) }}" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom:1rem">
          <input type="file" name="bukti_pembayaran" accept="image/*" required style="width:100%;padding:.5rem;border:1px solid var(--border);border-radius:6px">
          <div style="font-size:.75rem;color:var(--ink-m);margin-top:.3rem">Format: JPG, PNG, WEBP. Maksimal 5MB.</div>
        </div>
        <button type="submit" class="btn-m btn-primary-m">
          <i class="fas fa-cloud-upload-alt"></i> Upload Bukti
        </button>
      </form>
    </div>
    @elseif($lelang->bukti_pembayaran)
    <div style="background:#d4edda;border:1px solid #c3e6cb;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem">
      <h3 style="font-size:.95rem;font-weight:600;color:#155724;margin-bottom:.75rem"><i class="fas fa-check-circle"></i> Bukti Pembayaran</h3>
      <div style="margin-bottom:1rem">
        <img src="{{ asset('storage/bukti_bayar/' . $lelang->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width:300px;border-radius:8px;border:1px solid var(--border)">
      </div>
      <div style="font-size:.85rem;color:#155724">
        <i class="fas fa-info-circle"></i>
        @if($lelang->status_konfirmasi === 'dibayar')
        <strong>Status:</strong> Pembayaran telah diverifikasi dan diterima.
        @else
        <strong>Status:</strong> Menunggu verifikasi admin.
        @endif
      </div>
    </div>
    @endif

    <div style="background:#e7f3ff;border:1px solid #b3d7ff;border-radius:8px;padding:1rem">
      <div style="font-weight:600;color:#004085;margin-bottom:.5rem">📞 Kontak Admin</div>
      <div style="color:#004085;font-size:.9rem;line-height:1.6">
        <strong>WhatsApp:</strong> +62 858-6907-4622<br>
        <strong>Email:</strong> support@luxbid.id<br>
        <strong>Jam Operasional:</strong> Senin - Jumat, 08.00 - 17.00 WIB
      </div>
    </div>
  </div>
</div>

@if(in_array($lelang->status_konfirmasi, ['dikonfirmasi', 'selesai']) && !$rating_existing)
<div class="card-m fade-up delay-3" style="margin-top:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-star-fill" style="color:var(--gold)"></i> Beri Rating & Review</div>
  </div>
  <div style="padding:2rem">
    <form method="POST" action="{{ route('masyarakat.rating.store', $lelang->id_lelang) }}">
      @csrf
      <div style="margin-bottom:1.5rem">
        <label style="display:block;font-size:.9rem;font-weight:600;color:var(--ink);margin-bottom:.75rem">Rating (1-5 bintang)</label>
        <div style="display:flex;gap:.5rem" id="rating-stars">
          @for($i = 1; $i <= 5; $i++)
          <label style="cursor:pointer">
            <input type="radio" name="rating" value="{{ $i }}" required style="display:none" onchange="updateStars({{ $i }})">
            <i class="far fa-star" data-star="{{ $i }}" style="font-size:2rem;color:#ddd;transition:color .2s" onmouseover="hoverStars({{ $i }})" onmouseout="resetStars()"></i>
          </label>
          @endfor
        </div>
      </div>
      <div style="margin-bottom:1.5rem">
        <label style="display:block;font-size:.9rem;font-weight:600;color:var(--ink);margin-bottom:.5rem">Komentar (opsional)</label>
        <textarea name="komentar" rows="4" style="width:100%;padding:.75rem;border:1px solid var(--border);border-radius:8px;font-family:inherit" placeholder="Bagikan pengalaman Anda dengan lelang ini..."></textarea>
      </div>
      <button type="submit" class="btn-m btn-primary-m">
        <i class="fas fa-paper-plane"></i> Kirim Rating
      </button>
    </form>
  </div>
</div>

<script>
let selectedRating = 0;
function updateStars(rating) {
  selectedRating = rating;
  for(let i = 1; i <= 5; i++) {
    const star = document.querySelector(`[data-star="${i}"]`);
    if(i <= rating) {
      star.classList.remove('far');
      star.classList.add('fas');
      star.style.color = '#c9a84c';
    } else {
      star.classList.remove('fas');
      star.classList.add('far');
      star.style.color = '#ddd';
    }
  }
}
function hoverStars(rating) {
  for(let i = 1; i <= 5; i++) {
    const star = document.querySelector(`[data-star="${i}"]`);
    if(i <= rating) {
      star.style.color = '#c9a84c';
    }
  }
}
function resetStars() {
  if(selectedRating > 0) {
    updateStars(selectedRating);
  } else {
    for(let i = 1; i <= 5; i++) {
      document.querySelector(`[data-star="${i}"]`).style.color = '#ddd';
    }
  }
}
</script>
@elseif($rating_existing)
<div class="card-m fade-up delay-3" style="margin-top:1.5rem">
  <div class="card-m-header">
    <div class="card-m-title"><i class="bi bi-check-circle" style="color:var(--success)"></i> Rating Anda</div>
  </div>
  <div style="padding:2rem">
    <div style="margin-bottom:1rem">
      <div style="font-size:.85rem;color:var(--ink-m);margin-bottom:.5rem">Rating:</div>
      <div>
        @for($i = 1; $i <= 5; $i++)
        <i class="fas fa-star" style="color:{{ $i <= $rating_existing->rating ? '#c9a84c' : '#ddd' }};font-size:1.5rem"></i>
        @endfor
      </div>
    </div>
    @if($rating_existing->komentar)
    <div>
      <div style="font-size:.85rem;color:var(--ink-m);margin-bottom:.5rem">Komentar:</div>
      <div style="background:var(--surface);border:1px solid var(--border);border-radius:8px;padding:1rem;color:var(--ink)">
        {{ $rating_existing->komentar }}
      </div>
    </div>
    @endif
    <div style="margin-top:1rem;font-size:.8rem;color:var(--ink-l)">
      <i class="fas fa-info-circle"></i> Terima kasih atas rating Anda!
    </div>
  </div>
</div>
@endif

<!-- Modal Batalkan -->
<div id="batalModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:12px;padding:2rem;max-width:500px;width:90%">
    <h3 style="margin:0 0 1rem;font-size:1.1rem;color:var(--ink)">Batalkan Kemenangan</h3>
    <form method="POST" action="{{ route('masyarakat.konfirmasi_kemenangan.batalkan', $lelang->id_lelang) }}">
      @csrf
      <div style="margin-bottom:1rem">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--ink-m);margin-bottom:.4rem">Alasan Pembatalan (opsional)</label>
        <textarea name="catatan" rows="3" style="width:100%;padding:.75rem;border:1px solid var(--border);border-radius:6px;font-family:inherit" placeholder="Masukkan alasan pembatalan..."></textarea>
      </div>
      <div style="display:flex;gap:.75rem;justify-content:flex-end">
        <button type="button" class="btn-m btn-secondary-m" onclick="document.getElementById('batalModal').style.display='none'">Batal</button>
        <button type="submit" class="btn-m" style="background:#dc3545;color:#fff;border:none;cursor:pointer" onclick="return confirm('Apakah Anda yakin ingin membatalkan kemenangan ini?')">
          <i class="fas fa-times"></i> Ya, Batalkan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
