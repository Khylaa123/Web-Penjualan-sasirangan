<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // Beri tahu nama tabelnya
    protected $table = 'KATEGORI_PRODUK';

    // Beri tahu primary key-nya
    protected $primaryKey = 'ID_KATEGORI';

    // Matikan timestamps karena tabel kita tidak punya created_at & updated_at
    public $timestamps = false;

    // Kolom apa saja yang boleh diisi
    protected $fillable = ['NAMA_KATEGORI', 'ICON'];
}