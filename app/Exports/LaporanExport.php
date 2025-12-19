<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Order::with(['pelanggan', 'package']);

        if ($this->startDate) {
            $query->whereDate('tanggal_order', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('tanggal_order', '<=', $this->endDate);
        }

        return $query->orderBy('tanggal_order', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Invoice',
            'Tanggal',
            'Pelanggan',
            'Paket',
            'Berat (kg)',
            'Total Harga',
            'Status'
        ];
    }

    /**
     * @param Order $order
     */
    public function map($order): array
    {
        return [
            $order->invoice_number ?? '-',
            $order->tanggal_order ? (is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') : $order->tanggal_order->format('d/m/Y')) : '-',
            $order->pelanggan->nama ?? '-',
            $order->package->nama ?? '-',
            $order->berat ?? 0,
            'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            ucfirst($order->status)
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

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Orders';
    }
}
