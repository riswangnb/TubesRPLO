<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Package;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['pelanggan', 'package'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $packages = Package::all();
        return view('admin.orders.create', compact('pelanggans', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'package_id' => 'nullable|exists:packages,id',
            'tanggal_order' => 'nullable|date',
            'berat' => 'nullable|numeric',
            'status' => 'required|in:pending,proses,selesai,diambil',
            'catatan' => 'nullable|string',
        ]);

        // Hitung total harga
        if ($validated['package_id']) {
            $package = Package::find($validated['package_id']);
            $validated['total_harga'] = $package->harga * ($validated['berat'] ?? 1);
        }

        Order::create($validated);
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dibuat');
    }

    public function edit(Order $order)
    {
        $pelanggans = Pelanggan::all();
        $packages = Package::all();
        return view('admin.orders.edit', compact('order', 'pelanggans', 'packages'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'package_id' => 'nullable|exists:packages,id',
            'tanggal_order' => 'nullable|date',
            'berat' => 'nullable|numeric',
            'status' => 'required|in:pending,proses,selesai,diambil',
            'catatan' => 'nullable|string',
        ]);

        // Hitung total harga
        if ($validated['package_id']) {
            $package = Package::find($validated['package_id']);
            $validated['total_harga'] = $package->harga * ($validated['berat'] ?? 1);
        }

        $order->update($validated);
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil diupdate');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus');
    }

    public function invoice(Order $order)
    {
        $order->load(['pelanggan', 'package']);
        return view('admin.orders.invoice', compact('order'));
    }
}
