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
        'ID_PESANAN',
        'ID_USER', 
        'ID_PESANAN',
        'ID_PENGIRIMAN', 
        'TANGGAL_PESAN', 
        'TOTAL_BERAT_GRAM', 
        'SUBTOTAL_PRODUK', 
        'BIAYA_PENGIRIMAN', 
        'TOTAL_AKHIR', 
        'STATUS_PESANAN', 
        'RESI_PENGIRIMAN',
        'TOTAL_BERAT_GRAM'
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

    // Relasi ke tabel pembayaran (1 Pesanan memiliki 1 riwayat Pembayaran di Midtrans)
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'ID_PESANAN', 'ID_PESANAN');
    }
}