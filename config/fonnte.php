<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fonnte API Configuration
    |--------------------------------------------------------------------------
    |
    | Use these config values instead of calling env() directly in jobs or
    | long-running processes. Change values in your .env and run
    | `php artisan config:clear` / `php artisan config:cache`.
    |
    */

    'send_enabled' => env('FONNTE_SEND_ENABLED', false),
    'api_url' => env('FONNTE_API_URL', 'https://api.fonnte.com/send'),
    'api_key' => env('FONNTE_API_KEY'),
    'default_country_code' => env('FONNTE_DEFAULT_COUNTRY_CODE', '62'),
    // Backwards-compatible single template (used if specific templates not set)
    'message_template' => env('FONNTE_MESSAGE_TEMPLATE', 'Halo {name}, pesanan Anda (No. {invoice}) telah selesai pada {date}. Total: {total}. Silakan ambil pesanan Anda di lokasi. Terima kasih.'),

    // Specific message templates for different triggers
    'message_templates' => [
        'created' => env('FONNTE_MESSAGE_TEMPLATE_CREATED', "*FAKTUR ELEKTRONIK* *TRANSAKSI REGULER*\nFreshClean Laundry\nJl. Bersih No. 123, Jakarta Selatan\n\nNomer Nota :\n*{invoice}*\n\nPelanggan Yth :\n{name}\n\nTanggal : {date}\n\nDetail pesanan:\n{package}\n\nTotal tagihan : Rp {total}\n\nUntuk melihat nota klik link di bawah:\n{link}\n\nTerima kasih"),
        'completed' => env('FONNTE_MESSAGE_TEMPLATE_COMPLETED', 'Halo {name}, pesanan Anda (No. {invoice}) telah selesai pada {date}. Total: {total}. Silakan ambil pesanan Anda di lokasi. Terima kasih.'),
    ],
];
