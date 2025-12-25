<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['pelanggan', 'package']);

        // Search berdasarkan invoice atau nama pelanggan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('telepon', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_order', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_order', '<=', $request->tanggal_sampai);
        }

        // Filter berdasarkan package
        if ($request->filled('package_id')) {
            $query->where('package_id', $request->package_id);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        $packages = Package::all();
        
        return view('admin.orders.index', compact('orders', 'packages'));
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

        $order = Order::create($validated);

        // Render invoice view HTML and save to public/invoices so pelanggan dapat mengaksesnya
        try {
            $order->load(['pelanggan', 'package']);
            // Render as public invoice (hide admin-only controls)
            $html = view('admin.orders.invoice', ['order' => $order, 'is_public' => true])->render();
            $dir = public_path('invoices');
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = $order->invoice_number . '.html';
            $path = $dir . DIRECTORY_SEPARATOR . $filename;
            file_put_contents($path, $html);

            // Dispatch WhatsApp job with invoice URL (keamanan: route invoice mungkin butuh auth, adjust jika perlu)
            $invoiceUrl = url('invoices/' . $filename);
            \App\Jobs\SendWhatsAppJob::dispatch($order->id, $invoiceUrl, 'created');
        } catch (\Throwable $e) {
            // Jangan ganggu alur utama jika gagal membuat file atau dispatch job
            report($e);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dibuat');
    }

    public function show(Order $order)
    {
        $order->load(['pelanggan', 'package']);
        return view('admin.orders.show', compact('order'));
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

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,proses,selesai,diambil'
        ]);

        $order->update(['status' => $validated['status']]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate',
                'status' => $order->status
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['search', 'status', 'tanggal_dari', 'tanggal_sampai', 'package_id']);
        $filename = 'orders_' . date('Y-m-d_His') . '.xlsx';
        return Excel::download(new OrdersExport($filters), $filename);
    }
}
