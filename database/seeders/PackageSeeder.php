<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'nama' => 'Cuci Kering',
                'deskripsi' => 'Paket cuci dan kering saja. Cocok untuk pelanggan yang ingin menjemur sendiri di rumah.',
                'harga' => 5000.00,
                'durasi_hari' => 1
            ],
            [
                'nama' => 'Cuci Kering Lipat',
                'deskripsi' => 'Paket lengkap cuci, kering, dan lipat. Paket paling populer untuk kebutuhan laundry sehari-hari.',
                'harga' => 7000.00,
                'durasi_hari' => 2
            ],
            [
                'nama' => 'Cuci Kering Setrika',
                'deskripsi' => 'Paket premium dengan cuci, kering, dan setrika rapi. Ideal untuk pakaian formal dan kemeja.',
                'harga' => 10000.00,
                'durasi_hari' => 3
            ],
            [
                'nama' => 'Express 1 Hari',
                'deskripsi' => 'Layanan cuci kering lipat dengan pengerjaan cepat dalam 1 hari. Biaya tambahan untuk layanan kilat.',
                'harga' => 12000.00,
                'durasi_hari' => 1
            ],
            [
                'nama' => 'Setrika Saja',
                'deskripsi' => 'Khusus untuk setrika pakaian yang sudah bersih. Harga per kilogram.',
                'harga' => 4000.00,
                'durasi_hari' => 1
            ],
            [
                'nama' => 'Cuci Sepatu',
                'deskripsi' => 'Paket khusus untuk mencuci sepatu berbagai jenis. Harga per pasang sepatu.',
                'harga' => 25000.00,
                'durasi_hari' => 3
            ],
            [
                'nama' => 'Cuci Tas',
                'deskripsi' => 'Layanan cuci tas ransel, tas kantor, dan jenis tas lainnya. Harga per item.',
                'harga' => 30000.00,
                'durasi_hari' => 3
            ],
            [
                'nama' => 'Cuci Boneka',
                'deskripsi' => 'Paket khusus untuk mencuci boneka ukuran sedang hingga besar dengan treatment khusus.',
                'harga' => 15000.00,
                'durasi_hari' => 2
            ],
            [
                'nama' => 'Cuci Karpet',
                'deskripsi' => 'Layanan cuci karpet dengan treatment khusus. Harga per meter persegi.',
                'harga' => 20000.00,
                'durasi_hari' => 4
            ],
            [
                'nama' => 'Laundry Bed Cover',
                'deskripsi' => 'Paket untuk bed cover, sprei, dan selimut. Cocok untuk refresh perlengkapan tidur.',
                'harga' => 35000.00,
                'durasi_hari' => 3
            ]
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}
