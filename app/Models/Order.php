<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['pelanggan_id', 'package_id', 'tanggal_order', 'total_harga', 'berat', 'status', 'catatan'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
