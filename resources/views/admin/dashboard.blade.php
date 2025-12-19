@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Orders -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #56C5D0;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Orders</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOrders }}</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #AEE4FF;">
                <i class="fas fa-shopping-cart text-2xl" style="color: #56C5D0;"></i>
            </div>
        </div>
    </div>

    <!-- Total Pelanggan -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #56C5D0;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Pelanggan</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPelanggan }}</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #AEE4FF;">
                <i class="fas fa-users text-2xl" style="color: #56C5D0;"></i>
            </div>
        </div>
    </div>

    <!-- Total Packages -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #56C5D0;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Packages</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPackages }}</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #AEE4FF;">
                <i class="fas fa-box text-2xl" style="color: #56C5D0;"></i>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #56C5D0;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #AEE4FF;">
                <i class="fas fa-money-bill-wave text-2xl" style="color: #56C5D0;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Recent Orders</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Invoice</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Package</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm text-gray-600 font-medium">{{ $order->invoice_number ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $order->pelanggan->nama }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $order->package->nama ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600 font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold" style="
                            @if($order->status == 'pending') background-color: #fef3c7; color: #b45309;
                            @elseif($order->status == 'proses') background-color: #dbeafe; color: #1e40af;
                            @elseif($order->status == 'selesai') background-color: #dcfce7; color: #166534;
                            @elseif($order->status == 'diambil') background-color: #f3f4f6; color: #1f2937;
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') : $order->tanggal_order->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Lihat semua orders →</a>
    </div>
</div>
@endsection
