# Email Setup untuk LuxBid

## Masalah Saat Ini
Port SMTP (587, 465, 25) ter-block di network development, sehingga email tidak bisa dikirim via Gmail SMTP langsung.

## Solusi Development
Gunakan `MAIL_MAILER=log` di `.env` — email akan di-log ke `storage/logs/laravel.log` untuk testing.

## Solusi Production

### Opsi 1: Mailtrap (Recommended untuk Staging)
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@luxbid.com
MAIL_FROM_NAME="LuxBid"
```

### Opsi 2: SendGrid (Recommended untuk Production)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@luxbid.com
MAIL_FROM_NAME="LuxBid"
```

### Opsi 3: Mailgun
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your_domain.com
MAILGUN_SECRET=your_mailgun_secret
MAIL_FROM_ADDRESS=noreply@luxbid.com
MAIL_FROM_NAME="LuxBid"
```

### Opsi 4: Gmail SMTP (Bila Port Terbuka)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=app_password_16_digit  # TANPA SPASI
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="LuxBid"
```

## Queue Setup (Sudah Configured)
Email menggunakan queue untuk reliability. Jalankan worker:

```bash
php artisan queue:work --queue=default
```

Untuk production, gunakan supervisor atau systemd untuk keep worker running.

## Test Email
```bash
php artisan tinker
Mail::to('test@example.com')->send(new App\Mail\WelcomeMail('Test User'));
```

## Email Templates yang Tersedia
- `WelcomeMail` - Email selamat datang saat registrasi
- `ResetCodeMail` - Email kode reset password
- `OutbidMail` - Notifikasi saat terbid oleh user lain
- `AuctionWonMail` - Notifikasi saat menang lelang
- `AuctionOpenedMail` - Notifikasi lelang dibuka
- `AuctionClosedMail` - Notifikasi lelang ditutup

Semua template ada di `resources/views/emails/`
