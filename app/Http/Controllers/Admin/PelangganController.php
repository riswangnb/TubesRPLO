<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::latest()->paginate(10);
        return view('admin.pelanggans.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('admin.pelanggans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Pelanggan::create($validated);
        return redirect()->route('admin.pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggans.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $pelanggan->update($validated);
        return redirect()->route('admin.pelanggans.index')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('admin.pelanggans.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
