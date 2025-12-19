@extends('layouts.admin')

@section('title', 'Laporan')
@section('header', 'Laporan & Rekap')

@section('content')
<!-- Filter Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="space-y-4">
        <div class="flex flex-wrap gap-4 items-end">
            <!-- Filter Type -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Filter</label>
                <select name="filter_type" id="filter_type" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: #d1d5db; outline: 2px solid #56C5D0; outline-offset: -1px;" onchange="toggleDateInputs()">
                    <option value="harian" {{ $filterType == 'harian' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="bulanan" {{ $filterType == 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="custom" {{ $filterType == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <!-- Start Date -->
            <div class="flex-1 min-w-[200px]" id="start_date_wrapper">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: #d1d5db; outline: 2px solid #56C5D0; outline-offset: -1px;">
            </div>

            <!-- End Date -->
            <div class="flex-1 min-w-[200px]" id="end_date_wrapper">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: #d1d5db; outline: 2px solid #56C5D0; outline-offset: -1px;">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="text-white px-6 py-2 rounded-lg font-semibold" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
                    <i class="fas fa-search mr-2"></i>Tampilkan
                </button>
            </div>

            <!-- Export Excel Button -->
            <div>
                <a href="{{ route('admin.laporan.export', request()->query()) }}" class="text-white px-6 py-2 rounded-lg font-semibold inline-block" style="background-color: #10b981;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </a>
            </div>

            <!-- Print Button -->
            <div>
                <a href="{{ route('admin.laporan.print', request()->query()) }}" target="_blank" class="text-white px-6 py-2 rounded-lg font-semibold inline-block" style="background-color: #3b82f6;" onmouseover="this.style.backgroundColor='#2563eb'" onmouseout="this.style.backgroundColor='#3b82f6'">
                    <i class="fas fa-print mr-2"></i>Cetak Laporan
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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

    <!-- Total Revenue -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #10b981;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #d1fae5;">
                <i class="fas fa-money-bill-wave text-2xl" style="color: #10b981;"></i>
            </div>
        </div>
    </div>

    <!-- Total Berat -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #f59e0b;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Total Berat</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalBerat, 1) }} kg</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #fef3c7;">
                <i class="fas fa-weight text-2xl" style="color: #f59e0b;"></i>
            </div>
        </div>
    </div>

    <!-- Rata-rata per Order -->
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4" style="border-color: #8b5cf6;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-semibold">Rata-rata/Order</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 0, ',', '.') : 0 }}</p>
            </div>
            <div class="p-3 rounded-full" style="background-color: #ede9fe;">
                <i class="fas fa-chart-line text-2xl" style="color: #8b5cf6;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Breakdown Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Breakdown by Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Breakdown Per Status</h3>
        <div class="space-y-3">
            @foreach($ordersByStatus as $item)
            <div class="flex items-center justify-between p-3 rounded-lg" style="background-color: #f9fafb;">
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold" style="
                        @if($item->status == 'pending') background-color: #fef3c7; color: #b45309;
                        @elseif($item->status == 'proses') background-color: #dbeafe; color: #1e40af;
                        @elseif($item->status == 'selesai') background-color: #dcfce7; color: #166534;
                        @elseif($item->status == 'diambil') background-color: #f3f4f6; color: #1f2937;
                        @endif">
                        {{ ucfirst($item->status) }}
                    </span>
                    <span class="text-gray-600 text-sm">{{ $item->total }} order</span>
                </div>
                <span class="font-semibold text-gray-800">Rp {{ number_format($item->revenue, 0, ',', '.') }}</span>
            </div>
            @endforeach
            @if($ordersByStatus->isEmpty())
            <p class="text-gray-500 text-center py-4">Tidak ada data</p>
            @endif
        </div>
    </div>

    <!-- Breakdown by Package -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Breakdown Per Layanan</h3>
        <div class="space-y-3">
            @foreach($ordersByPackage as $item)
            <div class="flex items-center justify-between p-3 rounded-lg" style="background-color: #f9fafb;">
                <div>
                    <p class="font-semibold text-gray-800">{{ $item->package->nama ?? 'Custom' }}</p>
                    <p class="text-xs text-gray-500">{{ $item->total }} order • {{ number_format($item->total_berat, 1) }} kg</p>
                </div>
                <span class="font-semibold text-gray-800">Rp {{ number_format($item->revenue, 0, ',', '.') }}</span>
            </div>
            @endforeach
            @if($ordersByPackage->isEmpty())
            <p class="text-gray-500 text-center py-4">Tidak ada data</p>
            @endif
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Grafik Pendapatan</h3>
    <canvas id="revenueChart" height="80"></canvas>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Orders</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Invoice</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Layanan</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Berat</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $order->invoice_number ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') : $order->tanggal_order->format('d/m/Y') }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $order->pelanggan->nama }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $order->package->nama ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $order->berat ? number_format($order->berat, 1) . ' kg' : '-' }}</td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleDateInputs() {
        const filterType = document.getElementById('filter_type').value;
        const startDateWrapper = document.getElementById('start_date_wrapper');
        const endDateWrapper = document.getElementById('end_date_wrapper');
        
        if (filterType === 'harian' || filterType === 'bulanan') {
            startDateWrapper.style.display = 'none';
            endDateWrapper.style.display = 'none';
        } else {
            startDateWrapper.style.display = 'block';
            endDateWrapper.style.display = 'block';
        }
    }

    // Initialize on page load
    toggleDateInputs();

    // Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const labels = @json($ordersPerDay->pluck('date')->map(function($date) {
        return \Carbon\Carbon::parse($date)->format('d M');
    }));
    const data = @json($ordersPerDay->pluck('revenue'));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#56C5D0',
                backgroundColor: 'rgba(86, 197, 208, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#56C5D0',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
