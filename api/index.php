<?php

// 1. Paksa PHP untuk menampilkan error dasar (Raw PHP Error)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // 2. Cek apakah folder Vendor ada?
    // Seringkali Vercel gagal install composer dependencies
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        throw new Exception("CRITICAL: File 'vendor/autoload.php' tidak ditemukan. Composer install gagal dijalankan.");
    }

    // 3. Load Autoloader
    require __DIR__ . '/../vendor/autoload.php';

    // 4. Load Aplikasi (Bootstrap)
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // 5. Setup Storage Sementara (Wajib untuk Vercel)
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0777, true);
        mkdir($storagePath . '/framework/views', 0777, true); // Folder view cache
        mkdir($storagePath . '/framework/sessions', 0777, true); // Folder session
        mkdir($storagePath . '/logs', 0777, true); // Folder logs
    }
    $app->useStoragePath($storagePath);

    // 6. Jalankan Aplikasi
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    // 7. JIKA ERROR: Tampilkan langsung di layar browser dalam format teks
    http_response_code(500);
    echo "<div style='background: #ffebe9; color: #cc0000; padding: 20px; font-family: monospace; border: 1px solid red;'>";
    echo "<h1>EMERGENCY ERROR CATCHER</h1>";
    echo "<h3>Pesan Error:</h3>";
    echo "<pre style='font-size: 16px; font-weight: bold;'>" . $e->getMessage() . "</pre>";
    echo "<h3>Lokasi File:</h3>";
    echo "<pre>" . $e->getFile() . " on line " . $e->getLine() . "</pre>";
    echo "<hr>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}