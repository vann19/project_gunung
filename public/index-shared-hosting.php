<?php

/*
|--------------------------------------------------------------------------
| Index.php untuk Shared Hosting
|--------------------------------------------------------------------------
| File ini diletakkan di public_html/
| Sementara folder Laravel utama diletakkan di luar public_html
|
| Struktur cPanel:
|   /home/username/laravel/      ← root project Laravel
|   /home/username/public_html/  ← isi folder public/ + file ini
|
*/

// Path ke folder Laravel (di luar public_html)
// Sesuaikan dengan path server hosting kamu!
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

// Jika deploy ke shared hosting, ubah path ini:
// Contoh: /home/namauser/laravel/vendor/autoload.php
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
