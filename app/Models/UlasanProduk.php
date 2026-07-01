<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanProduk extends Model
{
    // Sesuaikan nama tabel dengan yang ada di database kamu
    protected $table = 'ulasan_produk'; 
    protected $primaryKey = 'ID_ULASAN';
    public $timestamps = false;

    // Sesuaikan kolom ini dengan struktur tabel aslimu
    protected $fillable = [
        'ID_PRODUK', 
        'ID_USER', 
        'RATING', 
        'KOMENTAR', 
        'TANGGAL_ULASAN'
    ];

    // Relasi ke Detail Pesanan (Ulasan ini milik barang yang mana di pesanan)
    public function detailPesanan()
    {
        return $this->belongsTo(DetailPesanan::class, 'ID_DETAIL', 'ID_DETAIL');
    }

    // Relasi ke User (Siapa yang mengulas)
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'id');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ID_PRODUK', 'ID_PRODUK');
    }
}