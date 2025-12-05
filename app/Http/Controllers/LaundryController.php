<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function index()
    {
        return response()->json(\App\Models\Order::with(['pelanggan', 'package'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'package_id' => 'nullable|exists:packages,id',
            'tanggal_order' => 'nullable|date',
            'total_harga' => 'nullable|numeric',
            'berat' => 'nullable|numeric',
            'status' => 'nullable|in:pending,proses,selesai,diambil',
            'catatan' => 'nullable|string',
        ]);

        // Jika package_id disediakan, ambil harga dari package
        if ($validated['package_id']) {
            $package = \App\Models\Package::find($validated['package_id']);
            // Hitung total harga: harga package * berat (jika ada)
            if (isset($validated['berat']) && $validated['berat']) {
                $validated['total_harga'] = $package->harga * $validated['berat'];
            } else {
                $validated['total_harga'] = $package->harga;
            }
        }

        $order = \App\Models\Order::create($validated);
        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = \App\Models\Order::with(['pelanggan', 'package'])->findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $validated = $request->validate([
            'pelanggan_id' => 'sometimes|exists:pelanggans,id',
            'package_id' => 'nullable|exists:packages,id',
            'tanggal_order' => 'nullable|date',
            'total_harga' => 'nullable|numeric',
            'berat' => 'nullable|numeric',
            'status' => 'nullable|in:pending,proses,selesai,diambil',
            'catatan' => 'nullable|string',
        ]);

        // Jika package_id diupdate, recalculate total_harga
        if (isset($validated['package_id']) && $validated['package_id']) {
            $package = \App\Models\Package::find($validated['package_id']);
            $berat = $validated['berat'] ?? $order->berat;
            if ($berat) {
                $validated['total_harga'] = $package->harga * $berat;
            } else {
                $validated['total_harga'] = $package->harga;
            }
        } elseif (isset($validated['berat']) && $validated['berat']) {
            // Jika hanya berat yang diupdate, recalculate dari package yang sudah ada
            $package = $order->package;
            if ($package) {
                $validated['total_harga'] = $package->harga * $validated['berat'];
            }
        }

        $order->update($validated);
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
