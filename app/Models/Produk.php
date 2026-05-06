<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // Beri tahu nama tabel dan primary key
    protected $table = 'PRODUK';
    protected $primaryKey = 'ID_PRODUK';
    public $timestamps = false;

    // Kolom yang boleh diisi (Sesuaikan dengan rancangan database Anda)
   protected $fillable = [
        'ID_KATEGORI', 
        'KODE_PRODUK', // Kolom baru
        'NAMA_PRODUK', 
        'DESKRIPSI', 
        'BERAT_GRAM', 
        'HARGA',       // Kolom baru
        'STOK',        // Kolom baru
        'GAMBAR_UTAMA', 
        'STATUS_AKTIF'
    ];
    // Relasi ke tabel Kategori (Satu produk punya satu kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'ID_KATEGORI', 'ID_KATEGORI');
    }
    // Relasi ke tabel Varian (Satu Produk punya Banyak Varian)
    public function varian()
    {
        return $this->hasMany(Varian::class, 'ID_PRODUK', 'ID_PRODUK');
    }

    // Relasi ke tabel detail_produk (Satu Produk punya Banyak Detail/Ukuran)
    public function detail()
    {
        return $this->hasMany(DetailProduk::class, 'ID_PRODUK', 'ID_PRODUK');
    }
}