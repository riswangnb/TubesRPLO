<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\LaporanController;
use App\Models\Package;

Route::get('/', function () {
    $packages = Package::orderBy('harga', 'asc')->take(3)->get();
    return view('welcome', compact('packages'));
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('orders', OrderController::class, ['names' => 'admin.orders']);
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('admin.orders.invoice');
    Route::resource('packages', PackageController::class, ['names' => 'admin.packages']);
    Route::resource('pelanggans', PelangganController::class, ['names' => 'admin.pelanggans']);
    Route::get('laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
});
