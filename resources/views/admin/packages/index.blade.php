@extends('layouts.admin')

@section('title', 'Daftar Layanan')
@section('header', 'Manage Packages')

@section('content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight">Daftar Layanan</h3>
        <p class="text-slate-500 font-medium">Atur paket laundry dan harga layanan di sini.</p>
    </div>
    <div>
        <a href="{{ route('admin.packages.create') }}" 
           class="group flex items-center gap-2 px-5 py-3 bg-brand text-white rounded-xl font-bold hover:bg-brand-dark hover:-translate-y-1 hover:shadow-lg hover:shadow-brand/30 transition-all duration-300">
            <i class="fas fa-plus text-lg group-hover:rotate-90 transition-transform"></i>
            <span>Tambah Paket</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <form method="GET" action="{{ route('admin.packages.index') }}" class="relative z-10 flex flex-col md:flex-row gap-3">
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama layanan atau deskripsi..." 
                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:outline-none focus:bg-white focus:border-brand focus:ring-4 focus:ring-brand/10 transition-all placeholder-slate-400">
        </div>
        
        <button type="submit" class="px-8 py-3.5 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-700 transition-colors shadow-lg shadow-slate-900/10">
            Cari Layanan
        </button>
        
        @if(request('search'))
        <a href="{{ route('admin.packages.index') }}" class="px-4 py-3.5 bg-slate-200 text-slate-600 rounded-xl hover:bg-slate-300 transition-colors flex items-center justify-center" title="Reset Pencarian">
            <i class="fas fa-redo"></i>
        </a>
        @endif
    </form>
</div>

@if(request('search'))
<div class="mb-6 flex items-center gap-2 text-sm">
    <span class="flex items-center gap-2 px-4 py-2 bg-brand/10 text-brand-dark rounded-full font-bold">
        <i class="fas fa-info-circle"></i>
        Menampilkan {{ $packages->total() }} hasil untuk "{{ request('search') }}"
    </span>
</div>
@endif

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50/50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Paket</th>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Estimasi Waktu</th>
                    <th class="px-6 py-5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Harga / Kg</th>
                    <th class="px-6 py-5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($packages as $package)
                <tr class="group hover:bg-orange-50/30 transition-colors duration-200">
                    
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-lg transition-all duration-300 group-hover:bg-orange-500 group-hover:text-white group-hover:scale-110">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $package->nama }}</p>
                                <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Layanan</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                            <i class="fas fa-clock text-slate-400"></i>
                            {{ $package->durasi_hari }} Hari
                        </span>
                    </td>
                    
                    <td class="px-6 py-5">
                        <p class="text-sm text-slate-600 max-w-xs truncate" title="{{ $package->deskripsi }}">
                            {{ $package->deskripsi ?? '-' }}
                        </p>
                    </td>

                    <td class="px-6 py-5 text-right">
                        <span class="text-sm font-black text-slate-800">
                            Rp {{ number_format($package->harga, 0, ',', '.') }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.packages.edit', $package) }}" 
                               class="w-9 h-9 rounded-xl flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:bg-brand hover:border-brand hover:text-white transition-all shadow-sm" title="Edit">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            
                            <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" onsubmit="return confirm('Yakin ingin menghapus paket layanan ini?')" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 rounded-xl flex items-center justify-center bg-white border border-slate-200 text-slate-500 hover:bg-red-500 hover:border-red-500 hover:text-white transition-all shadow-sm" title="Hapus">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box text-4xl text-slate-300"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-700">Data Layanan Kosong</h4>
                        <p class="text-slate-500 text-sm mb-6">Belum ada paket layanan yang tersedia.</p>
                        @if(request('search'))
                            <a href="{{ route('admin.packages.index') }}" class="inline-block px-6 py-2.5 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 transition-colors">
                                Reset Pencarian
                            </a>
                        @else
                            <a href="{{ route('admin.packages.create') }}" class="inline-block px-6 py-2.5 bg-brand text-white rounded-xl font-bold hover:bg-brand-dark transition-colors">
                                Tambah Paket Pertama
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
    {{ $packages->links() }}
</div>
@endsection