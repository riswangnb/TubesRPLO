<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\PackageController;

Route::apiResource('orders', LaundryController::class);
Route::apiResource('pelanggans', PelangganController::class);
Route::apiResource('packages', PackageController::class);
// Tambahkan resource lain sesuai kebutuhan