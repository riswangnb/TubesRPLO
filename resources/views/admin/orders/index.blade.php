@extends('layouts.admin')

@section('title', 'Orders')
@section('header', 'Manage Orders')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-bold text-gray-800">Daftar Orders</h3>
    <div class="flex gap-3">
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="text-white px-4 py-2 rounded-lg flex items-center space-x-2" style="background-color: #10b981;" onmouseover="this.style.backgroundColor='#059669'" onmouseout="this.style.backgroundColor='#10b981'">
            <i class="fas fa-file-excel"></i>
            <span>Export Excel</span>
        </a>
        <a href="{{ route('admin.orders.create') }}" class="text-white px-4 py-2 rounded-lg flex items-center space-x-2" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
            <i class="fas fa-plus"></i>
            <span>Tambah Order</span>
        </a>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="bg-white rounded-lg shadow-md mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="p-4">
        <!-- Main Search Bar -->
        <div class="flex gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari invoice, nama pelanggan, atau nomor telepon..." class="w-full px-4 py-2.5 border rounded-lg focus:outline-none text-sm" style="border-color: #d1d5db; outline: 2px solid #56C5D0; outline-offset: -1px;">
            </div>
            <button type="submit" class="text-white px-6 py-2.5 rounded-lg font-semibold text-sm" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
                Cari
            </button>
            @if(request()->hasAny(['search', 'status', 'package_id', 'tanggal_dari', 'tanggal_sampai']))
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2.5 rounded-lg text-sm" title="Reset">
                <i class="fas fa-redo"></i>
            </a>
            @endif
            <button type="button" onclick="toggleFilter()" class="border border-gray-300 hover:bg-gray-50 px-4 py-2.5 rounded-lg text-sm text-gray-600">
                <i class="fas fa-sliders-h mr-1"></i>Filter
            </button>
        </div>

        <!-- Advanced Filters (Collapsible) -->
        <div id="advancedFilter" class="mt-4 pt-4 border-t border-gray-200" style="display: {{ request()->hasAny(['status', 'package_id', 'tanggal_dari', 'tanggal_sampai']) ? 'block' : 'none' }};">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none text-sm" style="border-color: #d1d5db;">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Layanan</label>
                    <select name="package_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none text-sm" style="border-color: #d1d5db;">
                        <option value="">Semua</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>{{ $package->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none text-sm" style="border-color: #d1d5db;">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none text-sm" style="border-color: #d1d5db;">
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Results Info -->
@if(request()->hasAny(['search', 'status', 'package_id', 'tanggal_dari', 'tanggal_sampai']))
<div class="mb-4 px-4 py-2.5 bg-blue-50 border-l-4 border-blue-400 rounded text-sm text-blue-800">
    Menampilkan <strong>{{ $orders->total() }}</strong> hasil
    @if(request('search'))
        untuk "<strong>{{ request('search') }}</strong>"
    @endif
    @if(request('status'))
        • Status: <strong>{{ ucfirst(request('status')) }}</strong>
    @endif
</div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Invoice</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Pelanggan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Layanan</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Berat</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-700">Total</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                    <td class="px-4 py-3 text-sm text-gray-600 font-medium">{{ $order->invoice_number ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') : $order->tanggal_order->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->pelanggan->nama }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->package->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600 text-center">{{ $order->berat ? number_format($order->berat, 1) . ' kg' : '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-800 font-semibold text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm text-center" onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="inline-block status-form-{{ $order->id }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 rounded-full text-xs font-semibold border-0 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-1" style="
                                @if($order->status == 'pending') background-color: #fef3c7; color: #b45309;
                                @elseif($order->status == 'proses') background-color: #dbeafe; color: #1e40af;
                                @elseif($order->status == 'selesai') background-color: #dcfce7; color: #166534;
                                @elseif($order->status == 'diambil') background-color: #f3f4f6; color: #1f2937;
                                @endif">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="diambil" {{ $order->status == 'diambil' ? 'selected' : '' }}>Diambil</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-sm text-center space-x-1" onclick="event.stopPropagation()">
                        <a href="{{ route('admin.orders.invoice', $order) }}" class="text-white px-2 py-1 rounded text-xs inline-block" style="background-color: #10b981;" title="Invoice">
                            <i class="fas fa-file-invoice"></i>
                        </a>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="text-white px-2 py-1 rounded text-xs inline-block" style="background-color: #56C5D0;" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 px-2 py-1" title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-5xl mb-3" style="color: #d1d5db;"></i>
                        <p class="text-sm">Tidak ada data yang ditemukan</p>
                        @if(request()->hasAny(['search', 'status', 'package_id', 'tanggal_dari', 'tanggal_sampai']))
                            <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">Reset Filter</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
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

// Auto change select color when status changes
document.querySelectorAll('select[name="status"]').forEach(select => {
    select.addEventListener('change', function() {
        const status = this.value;
        if (status === 'pending') {
            this.style.backgroundColor = '#fef3c7';
            this.style.color = '#b45309';
        } else if (status === 'proses') {
            this.style.backgroundColor = '#dbeafe';
            this.style.color = '#1e40af';
        } else if (status === 'selesai') {
            this.style.backgroundColor = '#dcfce7';
            this.style.color = '#166534';
        } else if (status === 'diambil') {
            this.style.backgroundColor = '#f3f4f6';
            this.style.color = '#1f2937';
        }
    });
});
</script>
@endpush
