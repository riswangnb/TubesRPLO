@extends('layouts.admin')

@section('title', 'Tambah Package')
@section('header', 'Tambah Package Baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.packages.store') }}">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Package *</label>
                <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('nama') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('nama') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('nama') }}" required>
                @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('deskripsi') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('deskripsi') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp) *</label>
                    <input type="number" name="harga" id="harga" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('harga') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('harga') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('harga') }}" required>
                    @error('harga') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="durasi_hari" class="block text-sm font-semibold text-gray-700 mb-2">Durasi (Hari) *</label>
                    <input type="number" name="durasi_hari" id="durasi_hari" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('durasi_hari') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('durasi_hari') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('durasi_hari', 1) }}" required>
                    @error('durasi_hari') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="text-white px-6 py-2 rounded-lg font-semibold" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
                    Simpan
                </button>
                <a href="{{ route('admin.packages.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
