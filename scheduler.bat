@echo off
cd /d "C:\Users\Hype AMD\Documents\projek\LuxBid"
php artisan schedule:run >> NUL 2>&1
