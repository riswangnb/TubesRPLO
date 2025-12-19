@extends('layouts.admin')

@section('title', 'Detail Order')
@section('header', 'Detail Order')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Order
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $order->invoice_number ?? 'Order #' . $order->id }}</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="far fa-calendar mr-1"></i>
                        Dibuat: {{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d F Y, H:i') : $order->tanggal_order->format('d F Y, H:i') }}
                    </p>
                </div>
                <div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold" style="
                        @if($order->status == 'pending') background-color: #fef3c7; color: #b45309;
                        @elseif($order->status == 'proses') background-color: #dbeafe; color: #1e40af;
                        @elseif($order->status == 'selesai') background-color: #dcfce7; color: #166534;
                        @elseif($order->status == 'diambil') background-color: #f3f4f6; color: #1f2937;
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="border-t border-b border-gray-200 py-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-user mr-2" style="color: #56C5D0;"></i>
                    Informasi Pelanggan
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="text-base font-semibold text-gray-800">{{ $order->pelanggan->nama }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Telepon</p>
                        <p class="text-base font-semibold text-gray-800">{{ $order->pelanggan->telepon }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="text-base font-semibold text-gray-800">{{ $order->pelanggan->alamat }}</p>
                    </div>
                    @if($order->pelanggan->email)
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-base font-semibold text-gray-800">{{ $order->pelanggan->email }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Details -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-box mr-2" style="color: #56C5D0;"></i>
                    Detail Layanan
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Paket Layanan</p>
                            <p class="text-base font-semibold text-gray-800">{{ $order->package->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Berat</p>
                            <p class="text-base font-semibold text-gray-800">{{ $order->berat ? number_format($order->berat, 1) . ' kg' : '-' }}</p>
                        </div>
                        @if($order->package)
                        <div>
                            <p class="text-sm text-gray-500">Harga per kg</p>
                            <p class="text-base font-semibold text-gray-800">Rp {{ number_format($order->package->harga, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estimasi Selesai</p>
                            <p class="text-base font-semibold text-gray-800">{{ $order->package->durasi_hari }} hari</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Deskripsi Layanan</p>
                            <p class="text-base text-gray-700">{{ $order->package->deskripsi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($order->catatan)
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">
                    <i class="fas fa-sticky-note mr-2" style="color: #56C5D0;"></i>
                    Catatan
                </h4>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <p class="text-sm text-gray-700">{{ $order->catatan }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-6">
                <i class="fas fa-history mr-2" style="color: #56C5D0;"></i>
                Timeline Status
            </h4>
            <div class="relative">
                <div class="absolute left-5 top-0 h-full w-0.5 bg-gray-200"></div>
                
                <div class="relative mb-6 flex items-start">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full z-10" style="background-color: {{ $order->status == 'pending' || $order->status == 'proses' || $order->status == 'selesai' || $order->status == 'diambil' ? '#56C5D0' : '#d1d5db' }};">
                        <i class="fas fa-clock text-white text-sm"></i>
                    </div>
                    <div class="ml-4 bg-gray-50 rounded-lg p-4 flex-1">
                        <p class="font-semibold text-gray-800">Order Dibuat (Pending)</p>
                        <p class="text-sm text-gray-500">Order berhasil dibuat dan menunggu diproses</p>
                        @if($order->created_at)
                        <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d F Y, H:i') }}</p>
                        @endif
                    </div>
                </div>

                <div class="relative mb-6 flex items-start">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full z-10" style="background-color: {{ $order->status == 'proses' || $order->status == 'selesai' || $order->status == 'diambil' ? '#56C5D0' : '#d1d5db' }};">
                        <i class="fas fa-spinner text-white text-sm"></i>
                    </div>
                    <div class="ml-4 bg-gray-50 rounded-lg p-4 flex-1">
                        <p class="font-semibold text-gray-800">Dalam Proses</p>
                        <p class="text-sm text-gray-500">Order sedang dikerjakan oleh team</p>
                        @if($order->status == 'proses' || $order->status == 'selesai' || $order->status == 'diambil')
                        <p class="text-xs text-gray-400 mt-1">Status saat ini</p>
                        @endif
                    </div>
                </div>

                <div class="relative mb-6 flex items-start">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full z-10" style="background-color: {{ $order->status == 'selesai' || $order->status == 'diambil' ? '#56C5D0' : '#d1d5db' }};">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                    <div class="ml-4 bg-gray-50 rounded-lg p-4 flex-1">
                        <p class="font-semibold text-gray-800">Selesai</p>
                        <p class="text-sm text-gray-500">Order sudah selesai dan siap diambil</p>
                        @if($order->status == 'selesai' || $order->status == 'diambil')
                        <p class="text-xs text-gray-400 mt-1">Status saat ini</p>
                        @endif
                    </div>
                </div>

                <div class="relative flex items-start">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full z-10" style="background-color: {{ $order->status == 'diambil' ? '#56C5D0' : '#d1d5db' }};">
                        <i class="fas fa-box-open text-white text-sm"></i>
                    </div>
                    <div class="ml-4 bg-gray-50 rounded-lg p-4 flex-1">
                        <p class="font-semibold text-gray-800">Diambil</p>
                        <p class="text-sm text-gray-500">Order telah diambil oleh pelanggan</p>
                        @if($order->status == 'diambil')
                        <p class="text-xs text-gray-400 mt-1">Status saat ini</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Total Pembayaran -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Total Pembayaran</h4>
            <div class="text-center py-6 bg-linear-to-r from-blue-50 to-cyan-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Total Harga</p>
                <p class="text-3xl font-bold" style="color: #56C5D0;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Update Status -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-sync-alt mr-2" style="color: #56C5D0;"></i>
                Update Status
            </h4>
            <div class="space-y-2">
                @if($order->status == 'pending')
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="proses">
                    <button type="submit" class="w-full text-center text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color: #3b82f6;">
                        <i class="fas fa-play mr-2"></i>Mulai Proses
                    </button>
                </form>
                @endif

                @if($order->status == 'proses')
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" class="w-full text-center text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color: #10b981;">
                        <i class="fas fa-check mr-2"></i>Tandai Selesai
                    </button>
                </form>
                @endif

                @if($order->status == 'selesai')
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="diambil">
                    <button type="submit" class="w-full text-center text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color: #6b7280;">
                        <i class="fas fa-box-open mr-2"></i>Sudah Diambil
                    </button>
                </form>
                @endif

                @if($order->status == 'diambil')
                <div class="text-center py-3 bg-gray-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
                    <p class="text-sm text-gray-600 font-semibold">Order Selesai</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Aksi Lainnya</h4>
            <div class="space-y-3">
                <a href="{{ route('admin.orders.invoice', $order) }}" class="block w-full text-center text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color: #10b981;">
                    <i class="fas fa-file-invoice mr-2"></i>Cetak Invoice
                </a>
                <a href="{{ route('admin.orders.edit', $order) }}" class="block w-full text-center text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90 transition" style="background-color: #56C5D0;">
                    <i class="fas fa-edit mr-2"></i>Edit Order
                </a>
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full text-center bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-trash mr-2"></i>Hapus Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Invoice Info -->
        @if($order->invoice_number)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Informasi Invoice</h4>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Nomor Invoice</p>
                    <p class="text-base font-mono font-semibold text-gray-800">{{ $order->invoice_number }}</p>
                </div>
                @if($order->invoice_date)
                <div>
                    <p class="text-sm text-gray-500">Tanggal Invoice</p>
                    <p class="text-base font-semibold text-gray-800">{{ \Carbon\Carbon::parse($order->invoice_date)->format('d F Y') }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- System Info -->
        <div class="bg-gray-50 rounded-lg p-4 text-xs text-gray-500">
            <p class="mb-1"><strong>Order ID:</strong> #{{ $order->id }}</p>
            @if($order->created_at)
            <p class="mb-1"><strong>Dibuat:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            @endif
            @if($order->updated_at)
            <p><strong>Update Terakhir:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
