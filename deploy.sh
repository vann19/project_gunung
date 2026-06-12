#!/bin/bash

# ============================================
# Script Deploy Laravel ke Shared Hosting
# ============================================
# Cara pakai:
# 1. chmod +x deploy.sh
# 2. ./deploy.sh

echo "🚀 Memulai proses build untuk shared hosting..."

# 1. Install dependencies (tanpa dev)
echo "📦 Installing composer dependencies..."
composer install --optimize-autoloader --no-dev

# 2. Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

# 3. Clear & cache semua config
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo ""
echo "✅ Build selesai! File siap diupload ke shared hosting."
echo ""
echo "📋 Yang perlu diupload ke server:"
echo "   ├── app/"
echo "   ├── bootstrap/"
echo "   ├── config/"
echo "   ├── database/"
echo "   ├── public/        → upload isi folder ini ke public_html/"
echo "   ├── resources/"
echo "   ├── routes/"
echo "   ├── storage/"
echo "   ├── vendor/"
echo "   └── .env           → JANGAN lupa upload & sesuaikan konfigurasi DB!"
echo ""
echo "📁 Struktur di cPanel/Shared Hosting:"
echo "   /home/username/public_html/  ← isi dari folder public/"
echo "   /home/username/laravel/      ← semua file Laravel (diluar public/)"
echo ""
echo "⚠️  Jangan lupa update index.php di public_html untuk path yang benar!"
