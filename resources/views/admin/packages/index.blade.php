@extends('layouts.admin')

@section('title', 'Packages')
@section('header', 'Manage Packages')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-xl font-bold text-gray-800">Daftar Packages</h3>
    <a href="{{ route('admin.packages.create') }}" class="text-white px-4 py-2 rounded-lg flex items-center space-x-2" style="background-color: #56C5D0;" onmouseover="this.style.backgroundColor='#3FA9B5'" onmouseout="this.style.backgroundColor='#56C5D0'">
        <i class="fas fa-plus"></i>
        <span>Tambah Package</span>
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Harga</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Durasi (Hari)</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-3 text-sm text-gray-600">#{{ $package->id }}</td>
                <td class="px-6 py-3 text-sm text-gray-600 font-semibold">{{ $package->nama }}</td>
                <td class="px-6 py-3 text-sm text-gray-600 font-semibold">Rp {{ number_format($package->harga, 0, ',', '.') }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $package->durasi_hari }} hari</td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ Str::limit($package->deskripsi, 50) }}</td>
                <td class="px-6 py-3 text-sm space-x-2">
                    <a href="{{ route('admin.packages.edit', $package) }}" class="text-white px-2 py-1 rounded-lg text-sm inline-block" style="background-color: #56C5D0;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
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
    {{ $packages->links() }}
</div>
@endsection
