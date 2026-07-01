<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Pesanan;
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

    public function katalog(Request $request)
    {
        $kategori = Kategori::all();
        
        // Siapkan query dasar
        $query = Produk::with('kategori');

        // 1. Filter Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where('NAMA_PRODUK', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Kategori (Jika diklik dari sidebar)
        if ($request->has('kategori')) {
            $query->where('ID_KATEGORI', $request->kategori);
        }

        // 3. Sorting (Urutkan)
        if ($request->has('sort')) {
            if ($request->sort == 'termurah') {
                $query->orderBy('HARGA', 'asc');
            } elseif ($request->sort == 'termahal') {
                $query->orderBy('HARGA', 'desc');
            } elseif ($request->sort == 'terbaru') {
                // Urutkan berdasarkan ID terbaru jika kolom created_at tidak ada
                $query->orderBy('ID_PRODUK', 'desc'); 
            }
        }

        // Eksekusi query dengan paginasi, dan bawa parameter URL (biar pas pindah halaman filternya gak hilang)
        $produk = $query->paginate(9)->withQueryString();

        // 4. Ambil 3 Produk Acak untuk fitur "Featured Products" di Sidebar
        $featured = Produk::inRandomOrder()->limit(3)->get();

        return view('katalog.index', compact('kategori', 'produk', 'featured'));
    }

    public function show($id)
    {
        // Cari produk berdasarkan ID, sertakan relasi kategori
        $produk = Produk::with('kategori')->findOrFail($id);
        
        // Ambil data kategori untuk sidebar
        $kategori_sidebar = Kategori::all();

        // Ambil produk terkait (produk dengan kategori yang sama, kecuali produk ini sendiri)
        $produk_terkait = Produk::where('ID_KATEGORI', $produk->ID_KATEGORI)
                                ->where('ID_PRODUK', '!=', $id)
                                ->limit(4)
                                ->get();

        return view('katalog.show', compact('produk', 'kategori_sidebar', 'produk_terkait'));
    }
        public function riwayatPesanan()
    {
        // Ambil data pesanan khusus milik pelanggan yang sedang login
        $pesanan = Pesanan::where('ID_USER', auth()->user()->id)
                        ->orderBy('TANGGAL_PESAN', 'desc')
                        ->get();

        return view('front.riwayat_pesanan', compact('pesanan'));
    }

    public function detailPesanan($id)
    {
        // Cari detail pesanan berdasarkan ID dan pastikan milik user yang login
        $pesanan = Pesanan::with('detail.produk')
                        ->where('ID_USER', auth()->user()->id)
                        ->findOrFail($id);

        return view('front.detail_pesanan', compact('pesanan'));
    }
}