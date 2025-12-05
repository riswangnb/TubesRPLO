<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Package;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalPelanggan = Pelanggan::count();
        $totalPackages = Package::count();
        $totalRevenue = Order::sum('total_harga');
        $recentOrders = Order::with(['pelanggan', 'package'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalOrders', 'totalPelanggan', 'totalPackages', 'totalRevenue', 'recentOrders'));
    }
}
