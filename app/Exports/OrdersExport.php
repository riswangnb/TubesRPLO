<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Order::with(['pelanggan', 'package']);

        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['tanggal_dari'])) {
            $query->whereDate('tanggal_order', '>=', $this->filters['tanggal_dari']);
        }

        if (!empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('tanggal_order', '<=', $this->filters['tanggal_sampai']);
        }

        if (!empty($this->filters['package_id'])) {
            $query->where('package_id', $this->filters['package_id']);
        }

        return $query->latest()->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Invoice',
            'Tanggal Order',
            'Nama Pelanggan',
            'Telepon',
            'Alamat',
            'Paket Layanan',
            'Berat (kg)',
            'Harga per kg',
            'Total Harga',
            'Status',
            'Catatan'
        ];
    }

    /**
     * @param Order $order
     */
    public function map($order): array
    {
        return [
            $order->invoice_number ?? '-',
            $order->tanggal_order ? (is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y H:i') : $order->tanggal_order->format('d/m/Y H:i')) : '-',
            $order->pelanggan->nama ?? '-',
            $order->pelanggan->telepon ?? '-',
            $order->pelanggan->alamat ?? '-',
            $order->package->nama ?? '-',
            $order->berat ?? 0,
            $order->package ? 'Rp ' . number_format($order->package->harga, 0, ',', '.') : '-',
            'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            ucfirst($order->status),
            $order->catatan ?? '-'
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '56C5D0']]],
        ];
    }
}
