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

    // --- ACCESOR: Hitung Otomatis Harga Setelah Diskon Tanpa Ubah Database ---
    public function getHargaSetelahDiskonAttribute()
    {
        if ($this->DISKON_PERSEN > 0) {
            return $this->HARGA - ($this->HARGA * ($this->DISKON_PERSEN / 100));
        }
        return $this->HARGA;
    }

    // Relasi ke Detail Pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'ID_PRODUK', 'ID_PRODUK');
    }

    // --- RELASI LUAS: Ambil semua data ulasan produk dari tabel seberang ---
    public function ulasan()
{
    return $this->hasManyThrough(
        \App\Models\UlasanProduk::class,
        \App\Models\DetailPesanan::class,
        'ID_PRODUK', // Foreign key di tabel detail_pesanan
        'ID_DETAIL', // Foreign key di tabel ulasan_produk
        'ID_PRODUK', // Local key di tabel produk
        'ID_DETAIL'  // Local key di tabel detail_pesanan
        );
    }

    // Accessor tambahan untuk mendapatkan Rata-Rata Rating (Opsional tapi keren)
    public function getRataRataRatingAttribute()
    {
        return $this->ulasan()->avg('RATING') ?? 0;
    }
}