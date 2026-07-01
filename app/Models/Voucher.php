<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';
    protected $primaryKey = 'ID_VOUCHER';
    public $timestamps = false;

    protected $fillable = [
        'KODE_VOUCHER', 'POTONGAN_HARGA', 'STATUS_AKTIF'
    ];
}