@extends('layouts.admin')

@section('title', 'Edit Pelanggan')
@section('header', 'Edit Pelanggan')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('admin.pelanggans.update', $pelanggan) }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelanggan *</label>
                <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('nama') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('nama') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">Telepon *</label>
                <input type="text" name="telepon" id="telepon" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('telepon') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('telepon') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('telepon', $pelanggan->telepon) }}" required>
                @error('telepon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('email') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('email') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" value="{{ old('email', $pelanggan->email) }}">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat *</label>
                <textarea name="alamat" id="alamat" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none" style="border-color: {{ $errors->has('alamat') ? '#ef4444' : '#d1d5db' }}; outline: 2px solid {{ $errors->has('alamat') ? '#fca5a5' : '#56C5D0' }}; outline-offset: -1px;" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                @error('alamat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="text-white px-6 py-2 rounded-lg font-semibold" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
                    Update
                </button>
                <a href="{{ route('admin.pelanggans.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
