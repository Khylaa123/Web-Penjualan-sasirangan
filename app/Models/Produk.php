<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // Beri tahu nama tabel dan primary key
    protected $table = 'produk'; // Pastikan sesuai nama tabel di database kamu (huruf kecil)
    protected $primaryKey = 'ID_PRODUK';
    public $timestamps = false;

    // Kolom yang boleh diisi (Fillable)
    protected $fillable = [
        'ID_KATEGORI', 
        'KODE_PRODUK', // <-- Ini yang paling penting untuk kode otomatis
        'NAMA_PRODUK', 
        'DESKRIPSI', 
        'BERAT_GRAM', 
        'HARGA',       
        'DISKON_PERSEN',
        'STOK',        
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

    // SIHIR ACCESSOR: Menghitung harga otomatis jika ada diskon
    public function getHargaAkhirAttribute()
    {
        if ($this->DISKON_PERSEN > 0) {
            $potongan = $this->HARGA * ($this->DISKON_PERSEN / 100);
            return $this->HARGA - $potongan;
        }
        return $this->HARGA;
    }

    // Relasi ke Ulasan Produk
    public function ulasan()
    {
        return $this->hasMany(UlasanProduk::class, 'ID_PRODUK', 'ID_PRODUK');
    }

    // Accessor tambahan untuk mendapatkan Rata-Rata Rating (Opsional tapi keren)
    public function getRataRataRatingAttribute()
    {
        return $this->ulasan()->avg('RATING') ?? 0;
    }
}