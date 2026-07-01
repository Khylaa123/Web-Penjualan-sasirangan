<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Merujuk ke nama tabel asli di database kamu
    protected $table = 'kategori_produk';
    
    protected $primaryKey = 'ID_KATEGORI';
    
    public $timestamps = false;

    protected $fillable = [
        'NAMA_KATEGORI',
        'PREFIX_KODE',
        'ICON'
    ];

    // Relasi ke Produk (Satu kategori memiliki banyak produk)
    public function produk()
    {
        return $this->hasMany(Produk::class, 'ID_KATEGORI', 'ID_KATEGORI');
    }
}