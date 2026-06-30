<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'ID_DETAIL';
    public $timestamps = false;

   // PASTIKAN SEMUA KOLOM INI ADA DI DALAM $fillable
    protected $fillable = [
        'ID_PESANAN', 
        'ID_PRODUK', 
        'HARGA_SAAT_BELI', // Pastikan namanya persis dengan yang ada di database
        'JUMLAH_BELI', // <--- UBAH DI SINI
        'SUBTOTAL'
];
    public function produk() {
        return $this->belongsTo(Produk::class, 'ID_PRODUK', 'ID_PRODUK');
    }
}