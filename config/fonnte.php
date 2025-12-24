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
    'message_template' => env('FONNTE_MESSAGE_TEMPLATE', 'Halo {name}, pesanan Anda (No. {invoice}) telah selesai pada {date}. Total: {total}. Silakan ambil pesanan Anda di lokasi. Terima kasih.'),
];
