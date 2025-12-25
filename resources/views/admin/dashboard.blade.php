
@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('header', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-brand/5 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-brand/5 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-150 duration-500"></div>
        
        <div class="relative z-10 flex flex-col h-full justify-between">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center text-xl transition-colors duration-300 group-hover:bg-brand group-hover:text-white group-hover:rotate-6">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg flex items-center gap-1">
                    <i class="fas fa-arrow-up"></i> +2.5%
                </span>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider mb-1">Total Orders</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalOrders }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-purple-500/5 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-150 duration-500"></div>
        
        <div class="relative z-10 flex flex-col h-full justify-between">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl transition-colors duration-300 group-hover:bg-purple-500 group-hover:text-white group-hover:rotate-6">
                    <i class="fas fa-users"></i>
                </div>
                 <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">
                    Active
                </span>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider mb-1">Pelanggan</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalPelanggan }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-orange-500/5 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/5 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-150 duration-500"></div>
        
        <div class="relative z-10 flex flex-col h-full justify-between">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl transition-colors duration-300 group-hover:bg-orange-500 group-hover:text-white group-hover:rotate-6">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <div>
                <p class="text-slate-500 text-sm font-bold uppercase tracking-wider mb-1">Paket Layanan</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $totalPackages }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-6 shadow-xl shadow-slate-900/20 hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden text-white">
        <div class="absolute top-0 -inset-full h-full w-1/2 z-5 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white opacity-10 animate-shine" style="animation: shine 3s infinite;"></div>
        
        <div class="relative z-10 flex flex-col h-full justify-between">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-brand-accent flex items-center justify-center text-xl backdrop-blur-sm border border-white/10 group-hover:scale-110 transition-transform">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div>
                <p class="text-white/60 text-sm font-bold uppercase tracking-wider mb-1">Total Pendapatan</p>
                <h3 class="text-2xl lg:text-3xl font-black text-white truncate">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Pesanan Terbaru</h3>
            <p class="text-slate-500 text-sm">Monitoring transaksi realtime</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-2 text-sm font-bold text-brand hover:text-brand-dark transition-colors">
            Lihat Semua
            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Invoice</th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Layanan</th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-8 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($recentOrders as $order)
                <tr class="hover:bg-slate-50/80 cursor-pointer transition-colors duration-200" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                    <td class="px-8 py-5">
                        <span class="font-mono text-sm font-bold text-brand-dark">#{{ $order->invoice_number ?? '-' }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-xs font-bold">
                                {{ substr($order->pelanggan->nama, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-slate-700">{{ $order->pelanggan->nama }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-600 font-medium">
                        {{ $order->package->nama ?? '-' }}
                    </td>
                    <td class="px-8 py-5 text-sm font-bold text-slate-800">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-8 py-5">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'proses' => 'bg-blue-100 text-brand-dark border-blue-200',
                                'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                'diambil' => 'bg-slate-100 text-slate-600 border-slate-200',
                            ];
                            $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600';
                            
                            $statusIcons = [
                                'pending' => 'fa-clock',
                                'proses' => 'fa-cog fa-spin',
                                'selesai' => 'fa-check-circle',
                                'diambil' => 'fa-handshake',
                            ];
                            $statusIcon = $statusIcons[$order->status] ?? 'fa-circle';
                        @endphp
                        
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                            <i class="fas {{ $statusIcon }}"></i>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500">
                        {{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') : $order->tanggal_order->format('d M Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($recentOrders->isEmpty())
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">
                <i class="fas fa-inbox"></i>
            </div>
            <p class="text-slate-500 font-medium">Belum ada pesanan terbaru.</p>
        </div>
    @endif
</div>
@endsection