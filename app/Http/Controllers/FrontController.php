<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        
        // Ubah latest() menjadi orderBy('ID_PRODUK', 'desc')
        $produk = Produk::with('kategori')->orderBy('ID_PRODUK', 'desc')->take(8)->get();

        return view('welcome', compact('kategori', 'produk'));
    }

    public function produk()
    {
        // Sama, gunakan orderBy agar aman
        $produk = Produk::with('kategori')->orderBy('ID_PRODUK', 'desc')->paginate(12);
        
        return view('katalog', compact('produk'));
    }
}