<?php

// 1. Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 2. Load Aplikasi Laravel (bootstrap)
$app = require_once __DIR__ . '/../bootstrap/app.php';

/* === FIX ERROR 500 VERCEL ===
   Vercel adalah lingkungan Read-Only. Kita harus memindahkan 
   storage path ke folder '/tmp' yang boleh ditulisi.
*/
$storagePath = '/tmp/storage';

// Buat folder storage di /tmp jika belum ada
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    // Buat sub-folder penting
    mkdir($storagePath . '/app', 0777, true);
    mkdir($storagePath . '/framework/cache', 0777, true);
    mkdir($storagePath . '/framework/views', 0777, true);
    mkdir($storagePath . '/framework/sessions', 0777, true);
    mkdir($storagePath . '/logs', 0777, true);
}

// Set path storage baru ke aplikasi
$app->useStoragePath($storagePath);

// 3. Jalankan Aplikasi (Kernel)
// Kode di bawah ini meniru isi public/index.php
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);