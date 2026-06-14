<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #c9a84c; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .status-box { padding: 20px; border-radius: 8px; margin: 20px 0; }
        .status-diterima { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .status-ditolak { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .btn { display: inline-block; padding: 12px 30px; background: #c9a84c; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">LuxBid</h1>
            <p style="margin: 5px 0 0; opacity: 0.9;">Platform Lelang Premium</p>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $nama }}</strong>,</p>

            @if($status === 'dibayar')
            <div class="status-box status-diterima">
                <h2 style="margin-top: 0;">✓ Bukti Pembayaran Diterima</h2>
                <p>Bukti pembayaran Anda untuk lelang <strong>{{ $nama_barang }}</strong> telah diverifikasi dan diterima oleh admin.</p>
                @if($catatan)
                <p><strong>Catatan admin:</strong> {{ $catatan }}</p>
                @endif
            </div>
            <p>Terima kasih atas pembayaran Anda. Anda dapat menghubungi admin untuk proses pengambilan barang.</p>
            @else
            <div class="status-box status-ditolak">
                <h2 style="margin-top: 0;">✗ Bukti Pembayaran Ditolak</h2>
                <p>Maaf, bukti pembayaran Anda untuk lelang <strong>{{ $nama_barang }}</strong> ditolak oleh admin.</p>
                @if($catatan)
                <p><strong>Alasan:</strong> {{ $catatan }}</p>
                @endif
            </div>
            <p>Silakan upload ulang bukti pembayaran yang lebih jelas melalui halaman konfirmasi kemenangan.</p>
            @endif

            <a href="{{ $link_konfirmasi }}" class="btn">Lihat Detail Lelang</a>

            <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
            <p style="font-size: 14px; color: #666;">
                <strong>Butuh bantuan?</strong><br>
                Hubungi kami di <a href="mailto:support@luxbid.id">support@luxbid.id</a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; 2026 LuxBid. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
