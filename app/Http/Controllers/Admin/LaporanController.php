<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal hari ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $filterType = $request->input('filter_type', 'custom'); // harian, bulanan, custom

        // Adjust dates based on filter type
        if ($filterType == 'harian') {
            $startDate = Carbon::now()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        } elseif ($filterType == 'bulanan') {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        // Query orders dalam range tanggal
        $ordersQuery = Order::with(['pelanggan', 'package'])
            ->whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate);

        // Total orders dan revenue
        $totalOrders = $ordersQuery->count();
        $totalRevenue = $ordersQuery->sum('total_harga');
        $totalBerat = $ordersQuery->sum('berat');

        // Breakdown per status
        $ordersByStatus = Order::whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->select('status', DB::raw('count(*) as total'), DB::raw('sum(total_harga) as revenue'))
            ->groupBy('status')
            ->get();

        // Breakdown per package
        $ordersByPackage = Order::with('package')
            ->whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->whereNotNull('package_id')
            ->select('package_id', DB::raw('count(*) as total'), DB::raw('sum(total_harga) as revenue'), DB::raw('sum(berat) as total_berat'))
            ->groupBy('package_id')
            ->get();

        // Orders per hari (untuk chart)
        $ordersPerDay = Order::whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->select(DB::raw('DATE(tanggal_order) as date'), DB::raw('count(*) as total'), DB::raw('sum(total_harga) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // List semua orders dalam periode
        $orders = Order::with(['pelanggan', 'package'])
            ->whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->orderBy('tanggal_order', 'desc')
            ->paginate(20);

        return view('admin.laporan.index', compact(
            'startDate',
            'endDate',
            'filterType',
            'totalOrders',
            'totalRevenue',
            'totalBerat',
            'ordersByStatus',
            'ordersByPackage',
            'ordersPerDay',
            'orders'
        ));
    }

    public function print(Request $request)
    {
        // Default tanggal hari ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $filterType = $request->input('filter_type', 'custom');

        // Adjust dates based on filter type
        if ($filterType == 'harian') {
            $startDate = Carbon::now()->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
        } elseif ($filterType == 'bulanan') {
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        // Query orders dalam range tanggal
        $ordersQuery = Order::with(['pelanggan', 'package'])
            ->whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate);

        // Total orders dan revenue
        $totalOrders = $ordersQuery->count();
        $totalRevenue = $ordersQuery->sum('total_harga');
        $totalBerat = $ordersQuery->sum('berat');

        // Breakdown per status
        $ordersByStatus = Order::whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->select('status', DB::raw('count(*) as total'), DB::raw('sum(total_harga) as revenue'))
            ->groupBy('status')
            ->get();

        // Breakdown per package
        $ordersByPackage = Order::with('package')
            ->whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->whereNotNull('package_id')
            ->select('package_id', DB::raw('count(*) as total'), DB::raw('sum(total_harga) as revenue'), DB::raw('sum(berat) as total_berat'))
            ->groupBy('package_id')
            ->get();

        // List semua orders dalam periode (tanpa pagination untuk print)
        $orders = Order::with(['pelanggan', 'package'])
            ->whereDate('tanggal_order', '>=', $startDate)
            ->whereDate('tanggal_order', '<=', $endDate)
            ->orderBy('tanggal_order', 'desc')
            ->get();

        return view('admin.laporan.print', compact(
            'startDate',
            'endDate',
            'filterType',
            'totalOrders',
            'totalRevenue',
            'totalBerat',
            'ordersByStatus',
            'ordersByPackage',
            'orders'
        ));
    }
}

