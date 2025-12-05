<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return response()->json(\App\Models\Pelanggan::with('orders')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            // tambahkan field lain sesuai kebutuhan
        ]);
        $pelanggan = \App\Models\Pelanggan::create($validated);
        return response()->json($pelanggan, 201);
    }

    public function show($id)
    {
        $pelanggan = \App\Models\Pelanggan::with('orders')->findOrFail($id);
        return response()->json($pelanggan);
    }

    public function update(Request $request, $id)
    {
        $pelanggan = \App\Models\Pelanggan::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'sometimes|string',
            'alamat' => 'sometimes|string',
            'telepon' => 'sometimes|string',
            // tambahkan field lain sesuai kebutuhan
        ]);
        $pelanggan->update($validated);
        return response()->json($pelanggan);
    }

    public function destroy($id)
    {
        $pelanggan = \App\Models\Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return response()->json(['message' => 'Pelanggan deleted']);
    }
}
