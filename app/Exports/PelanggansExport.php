<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PelanggansExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pelanggan::orderBy('nama')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama',
            'Telepon',
            'Email',
            'Alamat',
            'Total Orders',
            'Tanggal Daftar'
        ];
    }

    /**
     * @param Pelanggan $pelanggan
     */
    public function map($pelanggan): array
    {
        return [
            $pelanggan->nama,
            $pelanggan->telepon,
            $pelanggan->email ?? '-',
            $pelanggan->alamat,
            $pelanggan->orders()->count(),
            $pelanggan->created_at ? $pelanggan->created_at->format('d/m/Y') : '-'
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
