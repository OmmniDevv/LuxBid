<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  body{margin:0;padding:0;background:#f5f0e8;font-family:'Segoe UI',Arial,sans-serif;color:#2c2416}
  .wrap{max-width:560px;margin:32px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08)}
  .header{background:#1a1208;padding:28px 32px;text-align:center}
  .header h1{margin:0;font-size:1.6rem;color:#c9a84c;letter-spacing:2px}
  .body{padding:32px}
  .body h2{margin:0 0 12px;font-size:1.1rem;color:#1a1208}
  .body p{margin:0 0 14px;line-height:1.7;color:#4a3f2f;font-size:.93rem}
  .highlight{background:#fdf8ee;border-left:3px solid #c9a84c;padding:12px 16px;border-radius:6px;margin:16px 0}
  .highlight strong{color:#1a1208;font-size:1rem}
  .btn{display:inline-block;margin:20px 0 8px;padding:12px 28px;background:#c9a84c;color:#1a1208;text-decoration:none;border-radius:8px;font-weight:700;font-size:.9rem}
  .footer{background:#f5f0e8;padding:16px 32px;text-align:center;font-size:.78rem;color:#9a8a6a}
</style>
</head>
<body>
<div class="wrap">
  <div class="header"><h1>✦ LuxBid</h1></div>
  <div class="body">
    @yield('content')
  </div>
  <div class="footer">© {{ date('Y') }} LuxBid &middot; Platform Pelelangan Daring &middot; Pesan ini dikirim otomatis, jangan dibalas.</div>
</div>
</body>
</html>
