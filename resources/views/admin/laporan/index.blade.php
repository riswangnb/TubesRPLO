@extends('layouts.admin')

@section('title', 'Laporan Keuangan')
@section('header', 'Analytics & Reports')

@section('content')

<style>
    /* Custom Scrollbar untuk Widget List */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Laporan & Rekap</h3>
        <p class="text-slate-500 font-medium">Analisa performa bisnis dan keuangan laundry.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.laporan.export', request()->query()) }}" 
           class="group flex items-center gap-2 px-5 py-3 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300">
            <i class="fas fa-file-excel text-lg"></i>
            <span>Export Excel</span>
        </a>
        <a href="{{ route('admin.laporan.print', request()->query()) }}" target="_blank"
           class="group flex items-center gap-2 px-5 py-3 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-700 hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-800/30 transition-all duration-300">
            <i class="fas fa-print text-lg"></i>
            <span>Cetak PDF</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand/5 rounded-full blur-3xl pointer-events-none"></div>

    <form method="GET" action="{{ route('admin.laporan.index') }}" class="relative z-10">
        <div class="flex flex-col md:flex-row items-end gap-4">
            
            <div class="flex-1 w-full">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 mb-1 block">Tipe Filter</label>
                <div class="relative">
                    <select name="filter_type" id="filter_type" onchange="toggleDateInputs()"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700 appearance-none">
                        <option value="harian" {{ $filterType == 'harian' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="bulanan" {{ $filterType == 'bulanan' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="custom" {{ $filterType == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            <div class="flex-1 w-full" id="start_date_wrapper">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 mb-1 block">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700">
            </div>

            <div class="flex-1 w-full" id="end_date_wrapper">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 mb-1 block">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700">
            </div>

            <div>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-brand text-white rounded-xl font-bold hover:bg-brand-dark transition-colors shadow-lg shadow-brand/20 flex items-center justify-center gap-2">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
            </div>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-gradient-to-br from-brand to-brand-dark rounded-[2rem] p-6 shadow-xl shadow-brand/20 relative overflow-hidden group text-white">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-xl backdrop-blur-md">
                    <i class="fas fa-wallet text-white"></i>
                </div>
            </div>
            <p class="text-brand-accent text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:-translate-y-1 transition-all duration-300 group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl group-hover:bg-blue-500 group-hover:text-white transition-colors">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Transaksi</p>
        <h3 class="text-2xl font-black text-slate-800">{{ $totalOrders }}</h3>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:-translate-y-1 transition-all duration-300 group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center text-xl group-hover:bg-orange-500 group-hover:text-white transition-colors">
                <i class="fas fa-weight-hanging"></i>
            </div>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Total Berat</p>
        <h3 class="text-2xl font-black text-slate-800">{{ number_format($totalBerat, 1) }} <span class="text-sm font-medium text-slate-400">Kg</span></h3>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:-translate-y-1 transition-all duration-300 group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-500 flex items-center justify-center text-xl group-hover:bg-purple-500 group-hover:text-white transition-colors">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-1">Rata-rata / Order</p>
        <h3 class="text-2xl font-black text-slate-800">Rp {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 0, ',', '.') : 0 }}</h3>
    </div>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 mb-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Grafik Pendapatan</h3>
            <p class="text-sm text-slate-500">Tren pemasukan berdasarkan periode filter</p>
        </div>
        <span class="text-xs font-medium text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
            <i class="fas fa-calendar-alt mr-1"></i> Data Terupdate
        </span>
    </div>
    
    <div class="relative h-[400px] w-full">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 h-full">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie text-blue-500"></i> Status Pesanan
        </h3>
        <div class="space-y-3">
            @foreach($ordersByStatus as $item)
            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100">
                <div class="flex items-center gap-3">
                     <span class="w-3 h-3 rounded-full 
                        @if($item->status == 'pending') bg-amber-400 shadow-lg shadow-amber-400/50
                        @elseif($item->status == 'proses') bg-blue-400 shadow-lg shadow-blue-400/50
                        @elseif($item->status == 'selesai') bg-green-400 shadow-lg shadow-green-400/50
                        @elseif($item->status == 'diambil') bg-slate-400 shadow-lg shadow-slate-400/50
                        @endif"></span>
                    <span class="text-sm font-bold text-slate-700 capitalize">{{ ucfirst($item->status) }}</span>
                    <span class="text-xs text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200 shadow-sm">{{ $item->total }} Trx</span>
                </div>
                <span class="text-sm font-black text-slate-800">Rp {{ number_format($item->revenue, 0, ',', '.') }}</span>
            </div>
            @endforeach
             @if($ordersByStatus->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                    <i class="fas fa-chart-pie text-3xl mb-2 opacity-20"></i>
                    <p class="text-sm">Belum ada data status</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 h-full">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <i class="fas fa-trophy text-orange-500"></i> Top Layanan
            </h3>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50 px-2 py-1 rounded border border-slate-100">
                Scroll ▼
            </span>
        </div>
        
        <div class="space-y-3 overflow-y-auto max-h-[300px] pr-2 custom-scrollbar">
            @foreach($ordersByPackage as $item)
            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 transition-colors group">
                <div class="flex-1 min-w-0 pr-4"> 
                    <p class="text-sm font-bold text-slate-700 truncate group-hover:text-brand transition-colors" title="{{ $item->package->nama ?? 'Custom' }}">
                        {{ $item->package->nama ?? 'Custom' }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-0.5 font-medium">
                        {{ $item->total }} order • {{ number_format($item->total_berat, 1) }} kg
                    </p>
                </div>
                <span class="text-sm font-black text-slate-800 whitespace-nowrap">
                    Rp {{ number_format($item->revenue, 0, ',', '.') }}
                </span>
            </div>
            @endforeach
            
            @if($ordersByPackage->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                    <i class="fas fa-box-open text-3xl mb-2 opacity-20"></i>
                    <p class="text-sm">Belum ada data layanan</p>
                </div>
            @endif
        </div>
    </div>

</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-xl font-bold text-slate-800">Rincian Transaksi</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Invoice</th>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Berat</th>
                    <th class="px-6 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($orders as $order)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-bold text-brand-dark bg-brand/5 px-2 py-1 rounded">#{{ $order->invoice_number ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') : $order->tanggal_order->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-700">
                        {{ $order->pelanggan->nama }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $order->package->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 text-center">
                        {{ $order->berat ? number_format($order->berat, 1) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-800 text-right">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                         <span class="px-3 py-1 rounded-full text-xs font-bold border 
                            @if($order->status == 'pending') bg-amber-50 text-amber-600 border-amber-200
                            @elseif($order->status == 'proses') bg-blue-50 text-blue-600 border-blue-200
                            @elseif($order->status == 'selesai') bg-green-50 text-green-600 border-green-200
                            @elseif($order->status == 'diambil') bg-slate-100 text-slate-600 border-slate-200
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
                @if($orders->isEmpty())
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                        <i class="fas fa-search mb-2 text-2xl"></i>
                        <p>Tidak ada data transaksi pada periode ini.</p>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $orders->appends(request()->query())->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleDateInputs() {
        const filterType = document.getElementById('filter_type').value;
        const startDateWrapper = document.getElementById('start_date_wrapper');
        const endDateWrapper = document.getElementById('end_date_wrapper');
        
        if (filterType === 'harian' || filterType === 'bulanan') {
            startDateWrapper.classList.add('hidden');
            endDateWrapper.classList.add('hidden');
        } else {
            startDateWrapper.classList.remove('hidden');
            endDateWrapper.classList.remove('hidden');
        }
    }

    // Initialize on page load
    toggleDateInputs();

    // Chart Configuration
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create Gradient
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 194, 255, 0.5)'); // Brand Color Transparent
    gradient.addColorStop(1, 'rgba(0, 194, 255, 0.0)');

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
                borderColor: '#00C2FF', // Brand Color
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#00C2FF',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointHoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { family: "'Outfit', sans-serif", size: 13 },
                    bodyFont: { family: "'Outfit', sans-serif", size: 14, weight: 'bold' },
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
                    grid: {
                        color: '#f1f5f9',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        font: { family: "'Outfit', sans-serif", size: 11 },
                        color: '#94a3b8',
                        callback: function(value) {
                            if(value >= 1000000) return (value/1000000) + 'jt';
                            if(value >= 1000) return (value/1000) + 'rb';
                            return value;
                        }
                    },
                    border: { display: false }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: "'Outfit', sans-serif", size: 11 },
                        color: '#94a3b8'
                    },
                    border: { display: false }
                }
            }
        }
    });
</script>
@endpush