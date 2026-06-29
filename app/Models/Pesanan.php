<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'ID_PESANAN';
    public $incrementing = false; 
    protected $keyType = 'string';
    public $timestamps = false; 

    protected $fillable = [
        'ID_USER', 
        'ID_PENGIRIMAN', 
        'TANGGAL_PESAN', 
        'TOTAL_BERAT_GRAM', 
        'SUBTOTAL_PRODUK', 
        'BIAYA_PENGIRIMAN', 
        'TOTAL_AKHIR', 
        'STATUS_PESANAN', 
        'RESI_PENGIRIMAN'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'ID_USER', 'id');
    }

    public function detail() {
        return $this->hasMany(DetailPesanan::class, 'ID_PESANAN', 'ID_PESANAN');
    }

    // TAMBAHAN BARU: Relasi ke tabel metode_pengiriman
    public function pengiriman() {
        return $this->belongsTo(MetodePengiriman::class, 'ID_PENGIRIMAN', 'ID_PENGIRIMAN');
    }
}