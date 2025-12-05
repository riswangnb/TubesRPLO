@extends('layouts.admin')

@section('title', 'Edit Order')
@section('header', 'Edit Order')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.orders.update', $order) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label for="pelanggan_id" class="block text-sm font-semibold text-gray-700 mb-2">Pelanggan *</label>
                <select name="pelanggan_id" id="pelanggan_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('pelanggan_id') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('pelanggan_id') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $order->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>
                            {{ $pelanggan->nama }} ({{ $pelanggan->telepon }})
                        </option>
                    @endforeach
                </select>
                @error('pelanggan_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="package_id" class="block text-sm font-semibold text-gray-700 mb-2">Package</label>
                <select name="package_id" id="package_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('package_id') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('package_id') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;">
                    <option value="">-- Pilih Package --</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}" {{ old('package_id', $order->package_id) == $package->id ? 'selected' : '' }}>
                            {{ $package->nama }} (Rp {{ number_format($package->harga, 0, ',', '.') }}/kg)
                        </option>
                    @endforeach
                </select>
                @error('package_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal_order" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Order</label>
                    <input type="date" name="tanggal_order" id="tanggal_order" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('tanggal_order') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('tanggal_order') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('tanggal_order', $order->tanggal_order->format('Y-m-d')) }}">
                    @error('tanggal_order') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="berat" class="block text-sm font-semibold text-gray-700 mb-2">Berat (kg)</label>
                    <input type="number" step="0.1" name="berat" id="berat" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('berat') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('berat') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('berat', $order->berat) }}">
                    @error('berat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                <select name="status" id="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('status') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('status') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" required>
                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="proses" {{ old('status', $order->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ old('status', $order->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="diambil" {{ old('status', $order->status) == 'diambil' ? 'selected' : '' }}>Diambil</option>
                </select>
                @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="catatan" class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('catatan') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('catatan') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;">{{ old('catatan', $order->catatan) }}</textarea>
                @error('catatan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="text-white px-6 py-2 rounded-lg font-semibold" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
                    Update
                </button>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
