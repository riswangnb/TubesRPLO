<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsAppMessage;
use App\Models\Order;

class SendWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $orderId;

    public $attachmentUrl;
    public $templateKey;

    public $tries = 3;

    public function __construct($orderId, $attachmentUrl = null, $templateKey = null)
    {
        $this->orderId = $orderId;
        $this->attachmentUrl = $attachmentUrl;
        $this->templateKey = $templateKey;
    }

    public function handle()
    {
        $order = Order::with('pelanggan')->find($this->orderId);
        if (!$order || !$order->pelanggan) {
            return;
        }

        $pel = $order->pelanggan;
        $parts = Order::formatPhoneForFonnte($pel->telepon);

        // Build message from template with placeholders
        // Choose template by key if provided, fallback to message_template
        $template = null;
        if (!empty($this->templateKey)) {
            $template = config('fonnte.message_templates.' . $this->templateKey);
        }
        if (empty($template)) {
            $template = config('fonnte.message_template');
        }

        Log::debug('SendWhatsAppJob template selected', ['order_id' => $order->id, 'templateKey' => $this->templateKey, 'template' => $template]);
        $replacements = [
            '{name}' => $pel->nama ?? '',
            '{invoice}' => $order->invoice_number ?? '',
            '{date}' => optional($order->invoice_date)->format('Y-m-d') ?? now()->toDateString(),
            '{total}' => isset($order->total_harga) ? number_format($order->total_harga, 0, ',', '.') : '',
            '{package}' => optional($order->package)->deskripsi ?? optional($order->package)->nama ?? '',
        ];

        $message = strtr($template, $replacements);

        // If template supports {link} placeholder, use it; otherwise append link
        if (!empty($this->attachmentUrl)) {
            if (strpos($message, '{link}') !== false) {
                $message = str_replace('{link}', $this->attachmentUrl, $message);
            } else {
                $message .= "\n\nLihat resi: " . $this->attachmentUrl;
            }
        }

        $record = WhatsAppMessage::create([
            'order_id' => $order->id,
            'target' => $parts['target'],
            'country_code' => $parts['countryCode'],
            'message' => $message,
            'status' => 'queued',
        ]);

        // Use config to read values (works with config cache)
        if (!config('fonnte.send_enabled')) {
            Log::info('Fonnte send disabled by config (job).', ['order_id' => $order->id]);
            $record->update(['status' => 'disabled']);
            return;
        }

        $apiUrl = config('fonnte.api_url', 'https://api.fonnte.com/send');
        $apiKey = config('fonnte.api_key');

        if (empty($apiKey)) {
            Log::warning('Fonnte API key tidak dikonfigurasi, pesan tidak dikirim (job)', ['order_id' => $order->id]);
            $record->update(['status' => 'failed']);
            return;
        }

        $payload = [
            'target' => $parts['target'],
            'message' => $message,
            'countryCode' => $parts['countryCode'],
        ];

        Log::debug('SendWhatsAppJob request', ['url' => $apiUrl, 'payload' => $payload]);

        $response = Http::asForm()->withHeaders([
            'Authorization' => $apiKey,
        ])->post($apiUrl, $payload);

        $body = $response->body();

        $record->update([
            'response' => $body,
            'status' => $response->successful() ? 'sent' : 'failed',
            'request_id' => data_get(json_decode($body, true), 'requestid') ?? null,
        ]);

        if ($response->failed()) {
            Log::error('Gagal kirim WA (job)', ['order_id' => $order->id, 'status' => $response->status(), 'body' => $body]);
            // throw to allow retry according to $tries
            throw new \Exception('Fonnte send failed: ' . $response->status());
        }
    }
}
