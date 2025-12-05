<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PelangganController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('orders', OrderController::class, ['names' => 'admin.orders']);
    Route::resource('packages', PackageController::class, ['names' => 'admin.packages']);
    Route::resource('pelanggans', PelangganController::class, ['names' => 'admin.pelanggans']);
});
