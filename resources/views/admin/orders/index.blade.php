@extends('layouts.admin')

@section('title', 'Daftar Orders')
@section('header', 'Manage Orders')

@section('content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Daftar Orders</h3>
        <p class="text-slate-500 font-medium">Kelola semua transaksi laundry di sini.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.orders.export', request()->query()) }}" 
           class="group flex items-center gap-2 px-5 py-3 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300">
            <i class="fas fa-file-excel text-lg"></i>
            <span class="hidden md:inline">Export</span>
        </a>
        <a href="{{ route('admin.orders.create') }}" 
           class="group flex items-center gap-2 px-5 py-3 bg-brand text-white rounded-xl font-bold hover:bg-brand-dark hover:-translate-y-1 hover:shadow-lg hover:shadow-brand/30 transition-all duration-300">
            <i class="fas fa-plus text-lg group-hover:rotate-90 transition-transform"></i>
            <span class="hidden md:inline">Order Baru</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand/5 rounded-full blur-3xl pointer-events-none"></div>

    <form method="GET" action="{{ route('admin.orders.index') }}" class="relative z-10">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari invoice, nama pelanggan..." 
                       class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:outline-none focus:bg-white focus:border-brand focus:ring-4 focus:ring-brand/10 transition-all placeholder-slate-400">
            </div>
            
            <button type="submit" class="px-8 py-3.5 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-700 transition-colors shadow-lg shadow-slate-900/10">
                Cari
            </button>
            
            @if(request()->hasAny(['search', 'status', 'package_id', 'tanggal_dari', 'tanggal_sampai']))
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-3.5 bg-slate-200 text-slate-600 rounded-xl hover:bg-slate-300 transition-colors" title="Reset Filter">
                <i class="fas fa-redo"></i>
            </a>
            @endif
            
            <button type="button" onclick="toggleFilter()" 
                    class="px-6 py-3.5 border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 hover:text-brand hover:border-brand/30 transition-all flex items-center gap-2">
                <i class="fas fa-sliders-h"></i> Filter
            </button>
        </div>

        <div id="advancedFilter" class="mt-4 pt-6 border-t border-slate-100" style="display: {{ request()->hasAny(['status', 'package_id', 'tanggal_dari', 'tanggal_sampai']) ? 'block' : 'none' }};">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700 appearance-none">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Layanan</label>
                    <div class="relative">
                        <select name="package_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700 appearance-none">
                            <option value="">Semua Paket</option>
                            @foreach($packages as $package)
                                <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>{{ $package->nama }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-brand text-slate-700">
                </div>
            </div>
        </div>
    </form>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider w-40">Order Info</th>
                    
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Pelanggan</th>
                    
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Layanan</th>
                    
                    <th class="px-6 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider w-32">Status</th>
                    <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider w-24">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                <tr class="group hover:bg-blue-50/30 transition-colors duration-200 cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                    
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-mono text-sm font-bold text-brand-dark">#{{ $order->invoice_number ?? '-' }}</span>
                            <span class="text-xs text-slate-500 mt-1">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d M Y') : $order->tanggal_order->format('d M Y') }}
                            </span>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 text-xs font-bold group-hover:bg-brand group-hover:text-white transition-colors shadow-sm">
                                {{ substr($order->pelanggan->nama, 0, 1) }}
                            </div>
                            <div class="max-w-[150px]">
                                <p class="text-sm font-bold text-slate-700 truncate" title="{{ $order->pelanggan->nama }}">{{ $order->pelanggan->nama }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ $order->pelanggan->telepon }}</p>
                            </div>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-slate-700 truncate max-w-[150px]">{{ $order->package->nama ?? '-' }}</span>
                            <span class="text-xs text-slate-500 mt-1 bg-slate-100 px-2 py-0.5 rounded w-fit">
                                <i class="fas fa-weight-hanging text-[10px] mr-1"></i>{{ $order->berat ? number_format($order->berat, 1) . ' kg' : '-' }}
                            </span>
                        </div>
                    </td>
                    
                    <td class="px-6 py-4 text-right">
                        <span class="text-sm font-black text-slate-800 whitespace-nowrap">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="inline-block relative w-full">
                            @csrf @method('PATCH')
                            @php
                                $statusStyle = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                    'proses'  => 'bg-blue-50 text-blue-600 border-blue-200',
                                    'selesai' => 'bg-green-50 text-green-600 border-green-200',
                                    'diambil' => 'bg-slate-50 text-slate-600 border-slate-200',
                                ];
                                $currentStyle = $statusStyle[$order->status] ?? 'bg-gray-50 text-gray-600';
                            @endphp
                            
                            <select name="status" onchange="this.form.submit()" 
                                    class="w-full appearance-none cursor-pointer pl-3 pr-8 py-1.5 rounded-lg text-xs font-bold border focus:ring-2 focus:ring-brand/20 transition-all {{ $currentStyle }}">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="diambil" {{ $order->status == 'diambil' ? 'selected' : '' }}>Diambil</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] opacity-50 pointer-events-none"></i>
                        </form>
                    </td>
                    
                    <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.orders.invoice', $order) }}" 
                               class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 transition-all" title="Invoice">
                                <i class="fas fa-print"></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order) }}" 
                               class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-brand hover:bg-brand/10 transition-all" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box-open text-4xl text-slate-300"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-700">Tidak ada data ditemukan</h4>
                        <p class="text-slate-500 text-sm mb-4">Coba ubah filter atau kata kunci pencarian Anda.</p>
                        @if(request()->hasAny(['search', 'status', 'package_id', 'tanggal_dari', 'tanggal_sampai']))
                            <a href="{{ route('admin.orders.index') }}" class="inline-block px-4 py-2 bg-slate-200 text-slate-700 rounded-lg font-bold hover:bg-slate-300 transition-colors">
                                Reset Filter
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $orders->links() }}
</div>

@endsection

@push('scripts')
<script>
    function toggleFilter() {
        const filter = document.getElementById('advancedFilter');
        if (filter.style.display === 'none') {
            filter.style.display = 'block';
        } else {
            filter.style.display = 'none';
        }
    }
</script>
@endpush