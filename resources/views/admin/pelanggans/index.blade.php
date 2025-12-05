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

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Telepon</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Alamat</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $pelanggan)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-600">#{{ $pelanggan->id }}</td>
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
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $pelanggans->links() }}
</div>
@endsection
