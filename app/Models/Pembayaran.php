<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    // Arahkan ke nama tabel di database kamu
    protected $table = 'pembayaran'; 
    
    // Jika tabel tidak menggunakan created_at dan updated_at
    public $timestamps = false; 

    // Daftarkan kolom yang boleh diisi (sesuaikan dengan CallbackController kamu sebelumnya)
    protected $fillable = [
        'ID_PESANAN',
        'TRANSACTION_ID',
        'PAYMENT_TYPE',
        'STATUS_BAYAR',
    ];

    // Relasi balik ke tabel Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'ID_PESANAN', 'ID_PESANAN');
    }
}