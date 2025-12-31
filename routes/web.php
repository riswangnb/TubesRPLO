<?php

use Illuminate\Support\Facades\Route;

// 1. Panggil LandingController yang sudah Anda buat
use App\Http\Controllers\LandingController;

// Controller Admin & Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LaporanController;

// ====================================================
// HALAMAN UTAMA (LANDING PAGE)
// ====================================================

// ✅ PERBAIKAN: Gunakan LandingController, bukan function manual
Route::get('/', [LandingController::class, 'index']);


// ====================================================
// AUTHENTICATION
// ====================================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ====================================================
// ADMIN PANEL
// ====================================================
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Orders
    Route::resource('orders', OrderController::class, ['names' => 'admin.orders']);
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('orders-export', [OrderController::class, 'export'])->name('admin.orders.export');
    
    // Packages (Layanan)
    Route::resource('packages', PackageController::class, ['names' => 'admin.packages']);
    
    // Pelanggan
    Route::resource('pelanggans', PelangganController::class, ['names' => 'admin.pelanggans']);
    Route::get('pelanggans-export', [PelangganController::class, 'export'])->name('admin.pelanggans.export');
    
    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('laporan/print', [LaporanController::class, 'print'])->name('admin.laporan.print');
    Route::get('laporan/export', [LaporanController::class, 'export'])->name('admin.laporan.export');
});