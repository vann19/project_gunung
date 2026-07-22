#!/bin/bash
set -e

echo "🚀 Membuat bundel zero-setup untuk Hostinger..."

# 1. Bersihkan folder staging lama
rm -rf dist_hostinger project-gunung-hostinger.zip
mkdir -p dist_hostinger/public_html
mkdir -p dist_hostinger/project-gunung

# 2. Copy isi folder public ke public_html
cp -r public/* dist_hostinger/public_html/
if [ -f public/.htaccess ]; then
    cp public/.htaccess dist_hostinger/public_html/
fi

# 3. Tulis file index.php yang sudah terkonfigurasi untuk Hostinger
cat << 'EOF' > dist_hostinger/public_html/index.php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../project-gunung/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../project-gunung/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../project-gunung/bootstrap/app.php';

$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
EOF

# 4. Copy seluruh komponen sistem ke folder project-gunung
cp -r app bootstrap config database lang public resources routes storage vendor artisan composer.json database-gunung.sql .env.example dist_hostinger/project-gunung/

# 5. Pastikan folder storage kosong lengkap terbuat
mkdir -p dist_hostinger/project-gunung/storage/framework/views
mkdir -p dist_hostinger/project-gunung/storage/framework/sessions
mkdir -p dist_hostinger/project-gunung/storage/framework/cache/data
mkdir -p dist_hostinger/project-gunung/storage/logs

touch dist_hostinger/project-gunung/storage/framework/views/.gitignore
touch dist_hostinger/project-gunung/storage/framework/sessions/.gitignore
touch dist_hostinger/project-gunung/storage/framework/cache/data/.gitignore
touch dist_hostinger/project-gunung/storage/logs/.gitignore

# 6. Hapus cache bootstrap lokal
rm -f dist_hostinger/project-gunung/bootstrap/cache/services.php
rm -f dist_hostinger/project-gunung/bootstrap/cache/packages.php
rm -f dist_hostinger/project-gunung/bootstrap/cache/config.php
rm -f dist_hostinger/project-gunung/bootstrap/cache/routes*.php

# 7. Paketkan ke dalam zip
cd dist_hostinger
zip -r ../project-gunung-hostinger.zip public_html project-gunung
cd ..

# 8. Bersihkan folder staging
rm -rf dist_hostinger

echo "✅ Selesai! File project-gunung-hostinger.zip telah berhasil dibuat."
