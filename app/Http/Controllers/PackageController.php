<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return response()->json(Package::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'durasi_hari' => 'required|integer',
        ]);
        $package = Package::create($validated);
        return response()->json($package, 201);
    }

    public function show($id)
    {
        $package = Package::findOrFail($id);
        return response()->json($package);
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'sometimes|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'sometimes|numeric',
            'durasi_hari' => 'sometimes|integer',
        ]);
        $package->update($validated);
        return response()->json($package);
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return response()->json(['message' => 'Package deleted']);
    }
}
