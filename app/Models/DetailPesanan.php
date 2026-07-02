<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'ID_DETAIL';
    public $timestamps = false;

    protected $fillable = [
        'ID_PESANAN',
        'ID_PRODUK',
        'HARGA_SAAT_BELI',
        'JUMLAH_BELI',
        'SUBTOTAL'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'ID_PESANAN', 'ID_PESANAN');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ID_PRODUK', 'ID_PRODUK');
    }
}