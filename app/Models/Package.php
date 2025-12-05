<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'harga', 'durasi_hari'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
