<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    // INI KUNCI JAWABANNYA: Kasih tau Laravel nama tabel yang benar
    protected $table = 'riwayat_stok'; 
    
    // Kasih tau Laravel primary key-nya
    protected $primaryKey = 'ID_RIWAYAT';
    
    // Matikan timestamps bawaan karena kita pakai TANGGAL
    public $timestamps = false; 

    protected $fillable = [
        'ID_PRODUK', 
        'ID_USER', 
        'TIPE_PERGERAKAN', 
        'JUMLAH', 
        'KETERANGAN'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'ID_PRODUK', 'ID_PRODUK');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_USER', 'id');
    }
}