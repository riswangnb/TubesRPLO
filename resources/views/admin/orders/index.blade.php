@extends('layouts.admin')

@section('title', 'Orders')
@section('header', 'Manage Orders')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-bold text-gray-800">Daftar Orders</h3>
    <a href="{{ route('admin.orders.create') }}" class="text-white px-4 py-2 rounded-lg flex items-center space-x-2" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
        <i class="fas fa-plus"></i>
        <span>Tambah Order</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pelanggan</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Package</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Berat (kg)</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-600">#{{ $order->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $order->pelanggan->nama }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $order->package->nama ?? '-' }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $order->berat ?? '-' }}</td>
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
                <td class="px-6 py-3 text-sm text-gray-600">{{ $order->tanggal_order->format('d/m/Y') }}</td>
                <td class="px-6 py-3 text-sm space-x-2">
                    <a href="{{ route('admin.orders.edit', $order) }}" class="text-white px-2 py-1 rounded-lg text-sm inline-block" style="background-color: #56C5D0;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
