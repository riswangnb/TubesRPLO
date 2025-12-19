@extends('layouts.admin')

@section('title', 'Pelanggans')
@section('header', 'Manage Pelanggans')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-bold text-gray-800">Daftar Pelanggans</h3>
    <a href="{{ route('admin.pelanggans.create') }}" class="text-white px-4 py-2 rounded-lg flex items-center space-x-2" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
        <i class="fas fa-plus"></i>
        <span>Tambah Pelanggan</span>
    </a>
</div>

<!-- Search Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.pelanggans.index') }}" class="flex gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, telepon, atau email..." class="w-full px-4 py-2 border rounded-lg focus:outline-none" style="border-color: #d1d5db; outline: 2px solid #56C5D0; outline-offset: -1px;">
        </div>
        <button type="submit" class="text-white px-6 py-2 rounded-lg font-semibold" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
            <i class="fas fa-search mr-2"></i>Cari
        </button>
        @if(request('search'))
        <a href="{{ route('admin.pelanggans.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold">
            <i class="fas fa-redo"></i>
        </a>
        @endif
    </form>
</div>

<!-- Results Info -->
@if(request('search'))
<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
    <p class="text-sm text-blue-800">
        <i class="fas fa-info-circle mr-2"></i>
        Menampilkan {{ $pelanggans->total() }} hasil untuk pencarian "<strong>{{ request('search') }}</strong>"
    </p>
</div>
@endif

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Telepon</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Alamat</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggans as $pelanggan)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-600 font-semibold">{{ $pelanggan->nama }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $pelanggan->telepon }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $pelanggan->email ?? '-' }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ Str::limit($pelanggan->alamat, 40) }}</td>
                <td class="px-6 py-3 text-sm space-x-2">
                    <a href="{{ route('admin.pelanggans.edit', $pelanggan) }}" class="text-white px-2 py-1 rounded-lg text-sm inline-block" style="background-color: #56C5D0;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.pelanggans.destroy', $pelanggan) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                    <i class="fas fa-users text-4xl mb-3" style="color: #d1d5db;"></i>
                    <p>Tidak ada data yang ditemukan</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $pelanggans->links() }}
</div>
@endsection
