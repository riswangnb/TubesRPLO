@extends('layouts.admin')

@section('title', 'Detail Order #' . ($order->invoice_number ?? $order->id))
@section('header', 'Detail Transaksi')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.orders.index') }}" class="group inline-flex items-center gap-2 text-slate-500 hover:text-brand font-bold transition-colors">
        <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-brand transition-colors">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
        </div>
        <span>Kembali ke Daftar</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-8">
        
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand/5 rounded-full -mr-16 -mt-16 blur-3xl pointer-events-none"></div>

            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8 border-b border-slate-100 pb-8 relative z-10">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                            {{ $order->invoice_number ?? 'ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </h3>
                        <span class="px-3 py-1 rounded-full text-xs font-bold border 
                            @if($order->status == 'pending') bg-amber-50 text-amber-600 border-amber-200
                            @elseif($order->status == 'proses') bg-blue-50 text-blue-600 border-blue-200
                            @elseif($order->status == 'selesai') bg-green-50 text-green-600 border-green-200
                            @elseif($order->status == 'diambil') bg-slate-100 text-slate-600 border-slate-200
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <p class="text-slate-500 font-medium flex items-center gap-2">
                        <i class="far fa-calendar text-brand"></i>
                        {{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y, H:i') : $order->tanggal_order->format('d F Y, H:i') }}
                    </p>
                </div>
                
                @if($order->invoice_number)
                <div class="text-right">
                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Invoice Date</span>
                    <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($order->invoice_date)->format('d M Y') }}</span>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-user-circle text-brand"></i> Pelanggan
                    </h4>
                    <div>
                        <p class="text-lg font-bold text-slate-800">{{ $order->pelanggan->nama }}</p>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mt-1">
                            <i class="fas fa-phone text-xs"></i> {{ $order->pelanggan->telepon }}
                        </div>
                        @if($order->pelanggan->email)
                        <div class="flex items-center gap-2 text-slate-500 text-sm mt-1">
                            <i class="fas fa-envelope text-xs"></i> {{ $order->pelanggan->email }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-brand"></i> Alamat
                    </h4>
                    <p class="text-slate-600 font-medium leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        {{ $order->pelanggan->alamat }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center"><i class="fas fa-box"></i></span>
                Detail Layanan
            </h4>

            <div class="overflow-hidden rounded-2xl border border-slate-100">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Item</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Berat (Kg)</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Harga/Kg</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700 block">{{ $order->package->nama ?? 'Unknown Package' }}</span>
                                <span class="text-xs text-slate-500">{{ $order->package->deskripsi ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-slate-600">
                                {{ $order->berat ? number_format($order->berat, 1) : '0' }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-slate-600">
                                Rp {{ number_format($order->package->harga ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-slate-800">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($order->catatan)
            <div class="mt-6">
                <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5 flex gap-4">
                    <i class="fas fa-sticky-note text-amber-400 text-xl mt-0.5"></i>
                    <div>
                        <h5 class="font-bold text-amber-800 text-sm mb-1">Catatan Pesanan</h5>
                        <p class="text-amber-700 text-sm">{{ $order->catatan }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <h4 class="text-lg font-bold text-slate-800 mb-8 flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-brand-dark flex items-center justify-center"><i class="fas fa-history"></i></span>
                Riwayat Status
            </h4>
            
            <div class="relative pl-4 space-y-8">
                <div class="absolute top-2 left-[27px] h-[calc(100%-20px)] w-0.5 bg-slate-100"></div>

                <div class="relative flex gap-6 group">
                    <div class="relative z-10 w-6 h-6 rounded-full border-4 {{ in_array($order->status, ['pending', 'proses', 'selesai', 'diambil']) ? 'border-brand bg-white ring-4 ring-brand/10' : 'border-slate-200 bg-slate-50' }} transition-all"></div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">Order Dibuat</p>
                        <p class="text-xs text-slate-500 mt-1">Order masuk ke sistem (Pending).</p>
                        @if($order->created_at)
                            <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 rounded text-[10px] font-mono text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        @endif
                    </div>
                </div>

                <div class="relative flex gap-6 group">
                    <div class="relative z-10 w-6 h-6 rounded-full border-4 {{ in_array($order->status, ['proses', 'selesai', 'diambil']) ? 'border-brand bg-white ring-4 ring-brand/10' : 'border-slate-200 bg-slate-50' }} transition-all"></div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm {{ $order->status == 'proses' ? 'text-brand' : '' }}">Sedang Dikerjakan</p>
                        <p class="text-xs text-slate-500 mt-1">Pakaian sedang dicuci/disetrika.</p>
                    </div>
                </div>

                <div class="relative flex gap-6 group">
                    <div class="relative z-10 w-6 h-6 rounded-full border-4 {{ in_array($order->status, ['selesai', 'diambil']) ? 'border-brand bg-white ring-4 ring-brand/10' : 'border-slate-200 bg-slate-50' }} transition-all"></div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm {{ $order->status == 'selesai' ? 'text-brand' : '' }}">Selesai</p>
                        <p class="text-xs text-slate-500 mt-1">Siap untuk diambil/diantar.</p>
                    </div>
                </div>

                <div class="relative flex gap-6 group">
                    <div class="relative z-10 w-6 h-6 rounded-full border-4 {{ $order->status == 'diambil' ? 'border-brand bg-white ring-4 ring-brand/10' : 'border-slate-200 bg-slate-50' }} transition-all"></div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm {{ $order->status == 'diambil' ? 'text-brand' : '' }}">Pesanan Diambil</p>
                        <p class="text-xs text-slate-500 mt-1">Transaksi selesai sepenuhnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        
        <div class="bg-gradient-to-br from-brand to-brand-dark rounded-[2rem] p-8 text-white shadow-xl shadow-brand/20 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-10 -mt-10 blur-xl group-hover:scale-150 transition-transform duration-700"></div>
            
            <p class="text-brand-accent text-xs font-bold uppercase tracking-widest mb-2">Total Tagihan</p>
            <h2 class="text-4xl font-black mb-4 tracking-tight">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h2>
            
            <div class="h-px bg-white/20 my-4"></div>
            
            <div class="flex justify-between text-sm text-white/80 font-medium">
                <span>Status</span>
                <span class="text-white flex items-center gap-1">
                    @if($order->status == 'diambil')
                        <i class="fas fa-check-circle text-brand-accent"></i> Lunas
                    @else
                        <i class="fas fa-clock"></i> Belum Lunas
                    @endif
                </span>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-2">Workflow</h4>
            
            <div class="space-y-3">
                @if($order->status == 'pending')
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="proses">
                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-play"></i> Mulai Proses
                        </button>
                    </form>
                @endif

                @if($order->status == 'proses')
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="selesai">
                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-4 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-check"></i> Tandai Selesai
                        </button>
                    </form>
                @endif

                @if($order->status == 'selesai')
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="diambil">
                        <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-4 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-hand-holding"></i> Serahkan ke Pelanggan
                        </button>
                    </form>
                @endif

                @if($order->status == 'diambil')
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-center text-slate-500 text-sm font-medium">
                        <i class="fas fa-check-double text-brand mb-1 block text-lg"></i>
                        Order Selesai
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
            <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-2">Admin Tools</h4>
            
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.orders.invoice', $order) }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-slate-50 text-slate-700 rounded-xl font-bold hover:bg-slate-100 hover:text-brand transition-all border border-slate-100">
                    <i class="fas fa-print text-xl"></i>
                    <span class="text-xs">Invoice</span>
                </a>
                
                <a href="{{ route('admin.orders.edit', $order) }}" class="flex flex-col items-center justify-center gap-2 p-4 bg-slate-50 text-slate-700 rounded-xl font-bold hover:bg-slate-100 hover:text-brand transition-all border border-slate-100">
                    <i class="fas fa-pen text-xl"></i>
                    <span class="text-xs">Edit</span>
                </a>
                
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Yakin ingin menghapus order ini?')" class="col-span-2">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center gap-2 p-4 bg-red-50 text-red-500 rounded-xl font-bold hover:bg-red-500 hover:text-white transition-all border border-red-100">
                        <i class="fas fa-trash-alt"></i>
                        <span class="text-sm">Hapus Order</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="px-4 text-center">
            <p class="text-[10px] text-slate-400 font-mono">
                ID: #{{ $order->id }} • Created: {{ $order->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
</div>

@endsection