<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePengiriman extends Model
{
    protected $table = 'metode_pengiriman';
    protected $primaryKey = 'ID_PENGIRIMAN';
    public $timestamps = false; 

    // Sesuaikan fillable dengan kolom di database aslimu
    protected $fillable = [
        'NAMA_KURIR', 
        'LAYANAN', 
        'ESTIMASI_HARI'
    ]; 
}