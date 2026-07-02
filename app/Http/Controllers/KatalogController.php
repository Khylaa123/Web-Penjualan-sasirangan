<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class KatalogController extends Controller
{
    public function index()
    {
        // 1. Ambil data kategori untuk menu/sidebar
        $kategori = Kategori::all();

        // 2. Ambil daftar produk utama dengan PAGINATION (misal: 9 produk per halaman)
        // Kuncinya ada di ->paginate(9) yang menggantikan ->get()
        $produk = Produk::where('STATUS_AKTIF', 1)
                        ->withAvg('ulasan as rata_rata_rating', 'RATING')
                        ->orderBy('ID_PRODUK', 'desc')
                        ->paginate(9); // Kamu bisa ganti angka 9 sesuai selera

        // 3. Ambil data Produk Unggulan (maksimal 3, pakai get karena tidak butuh pagination)
        $featured = Produk::where('STATUS_AKTIF', 1)
                          ->withAvg('ulasan as rata_rata_rating', 'RATING')
                          ->orderBy('DISKON_PERSEN', 'desc') 
                          ->orderBy('ID_PRODUK', 'desc')     
                          ->limit(3)                         
                          ->get();

        // 4. Kirim semua variabel ke view
        return view('katalog.index', compact('produk', 'kategori', 'featured'));
    }
}