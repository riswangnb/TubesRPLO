<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendWhatsAppJob;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\Auth;

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

        // After create, record initial status log
        static::created(function ($order) {
            try {
                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'status' => $order->status ?? 'pending',
                    'note' => 'Order dibuat',
                    'user_id' => Auth::id() ?? null,
                ]);
                // If a public invoice file exists (created by controller), dispatch WhatsApp job with URL
                try {
                    $filename = $order->invoice_number . '.html';
                    $path = public_path('invoices' . DIRECTORY_SEPARATOR . $filename);
                    if (file_exists($path)) {
                        $invoiceUrl = url('invoices/' . $filename);
                        // Dispatch created template
                        SendWhatsAppJob::dispatch($order->id, $invoiceUrl, 'created');
                    }
                } catch (\Throwable $e) {
                    report($e);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        });

        static::updated(function ($order) {
            // If status changed, create status log
            if ($order->isDirty('status')) {
                try {
                    OrderStatusLog::create([
                        'order_id' => $order->id,
                        'status' => $order->status,
                        'note' => 'Status diubah dari ' . $order->getOriginal('status') . ' ke ' . $order->status,
                        'user_id' => Auth::id() ?? null,
                    ]);
                } catch (\Throwable $e) {
                    report($e);
                }

                // Dispatch WhatsApp when status becomes 'selesai'
                if ($order->status === 'selesai' && $order->getOriginal('status') !== 'selesai') {
                    // Use completed template when status becomes selesai
                    SendWhatsAppJob::dispatch($order->id, null, 'completed');
                }
            }
        });

    }

    protected static function formatPhoneForFonnte($raw)
    {
        // Hapus semua karakter bukan digit
        $digits = preg_replace('/[^0-9]/', '', $raw);

        $defaultCc = config('fonnte.default_country_code', env('FONNTE_DEFAULT_COUNTRY_CODE', '62'));

        // Jika dimulai dengan 0 -> target tanpa 0, kirim countryCode terpisah
        if (strlen($digits) > 0 && $digits[0] === '0') {
            return [
                'target' => substr($digits, 1),
                'countryCode' => $defaultCc,
            ];
        }

        // Jika dimulai dengan country code (mis. 62...), keluarkan country code dan sisanya sebagai target
        if (strpos($digits, $defaultCc) === 0) {
            return [
                'target' => substr($digits, strlen($defaultCc)),
                'countryCode' => $defaultCc,
            ];
        }

        // Fallback: kirim seluruh digits sebagai target dan default country code
        return [
            'target' => $digits,
            'countryCode' => $defaultCc,
        ];
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

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class, 'order_id');
    }
}
