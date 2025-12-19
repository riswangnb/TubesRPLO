<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = ['pelanggan_id', 'package_id', 'tanggal_order', 'total_harga', 'berat', 'status', 'catatan', 'invoice_number', 'invoice_date'];

    protected $casts = [
        'tanggal_order' => 'datetime',
        'invoice_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->invoice_number)) {
                $order->invoice_number = self::generateInvoiceNumber();
            }
            if (empty($order->invoice_date)) {
                $order->invoice_date = Carbon::now()->format('Y-m-d');
            }
        });
    }

    public static function generateInvoiceNumber()
    {
        $date = Carbon::now();
        $prefix = 'INV-' . $date->format('Ymd') . '-';
        
        // Cari invoice terakhir hari ini
        $lastInvoice = self::whereDate('invoice_date', $date->format('Y-m-d'))
            ->where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastInvoice) {
            // Ambil nomor urut terakhir dan tambahkan 1
            $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
