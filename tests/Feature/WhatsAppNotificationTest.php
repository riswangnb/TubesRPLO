<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Pelanggan;
use App\Models\Order;

uses(RefreshDatabase::class);

it('sends a whatsapp message when order status becomes selesai', function () {
    Http::fake();

    $pelanggan = Pelanggan::create([
        'nama' => 'Budi',
        'telepon' => '08123456789',
        'alamat' => 'Jl. Contoh No.1',
    ]);

    $order = Order::create([
        'pelanggan_id' => $pelanggan->id,
        'status' => 'proses',
        'tanggal_order' => now()->toDateString(),
        'invoice_number' => 'INV-TEST-0001',
    ]);

    // Trigger status change
    $order->status = 'selesai';
    $order->save();

    Http::assertSent(function ($request) use ($pelanggan) {
        $body = $request->body();
        $data = json_decode($body, true) ?: [];

        return isset($data['to'])
            && strpos($data['to'], '62') === 0
            && isset($data['message'])
            && str_contains($data['message'], $pelanggan->nama);
    });
});
