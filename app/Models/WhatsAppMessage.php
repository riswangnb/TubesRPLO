<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsAppMessage extends Model
{
    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'order_id', 'target', 'country_code', 'message', 'response', 'request_id', 'status'
    ];

    protected $casts = [
        'response' => 'string',
    ];
}
