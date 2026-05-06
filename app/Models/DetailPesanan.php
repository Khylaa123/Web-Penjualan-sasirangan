<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'ID_DETAIL';
    public $timestamps = false;

    protected $fillable = ['ID_PESANAN', 'ID_PRODUK', 'JUMLAH', 'HARGA_SATUAN', 'SUBTOTAL'];

    public function produk() {
        return $this->belongsTo(Produk::class, 'ID_PRODUK', 'ID_PRODUK');
    }
}