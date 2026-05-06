<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama (Kartu Atas)
        $total_produk = Produk::count();
        $total_kategori = DB::table('kategori_produk')->count();
        $total_pesanan = DB::table('pesanan')->count();
        
        $total_omset = DB::table('pesanan')
                        ->whereIn('STATUS_PESANAN', ['Diproses', 'Dikirim', 'Selesai'])
                        ->sum('TOTAL_AKHIR');

        $pesanan_baru = DB::table('pesanan')->where('STATUS_PESANAN', 'Menunggu Pembayaran')->count();

        // 2. Data Tabel Bawah
        $stok_menipis = Produk::where('STOK', '<=', 10)->where('STATUS_AKTIF', 1)->orderBy('STOK', 'asc')->take(5)->get();
        $produk_terbaru = Produk::orderBy('ID_PRODUK', 'desc')->take(5)->get();

        // ==========================================
        // 3. DATA UNTUK GRAFIK (CHART)
        // ==========================================
        
        // Data Grafik Batang (Jumlah Pesanan Berdasarkan Status)
        $grafik_pesanan = DB::table('pesanan')
            ->select('STATUS_PESANAN', DB::raw('count(*) as total'))
            ->groupBy('STATUS_PESANAN')
            ->pluck('total', 'STATUS_PESANAN')
            ->toArray();

        // Susun urutan datanya agar grafiknya rapi
        $data_grafik_pesanan = [
            $grafik_pesanan['Menunggu Pembayaran'] ?? 0,
            $grafik_pesanan['Diproses'] ?? 0,
            $grafik_pesanan['Dikirim'] ?? 0,
            $grafik_pesanan['Selesai'] ?? 0,
            $grafik_pesanan['Dibatalkan'] ?? 0,
        ];

        // Data Grafik Bundaran (Jumlah Produk Berdasarkan Kategori)
        $grafik_kategori = DB::table('produk')
            ->join('kategori_produk', 'produk.ID_KATEGORI', '=', 'kategori_produk.ID_KATEGORI')
            ->select('kategori_produk.NAMA_KATEGORI', DB::raw('count(produk.ID_PRODUK) as total'))
            ->groupBy('kategori_produk.NAMA_KATEGORI')
            ->get();
            
        $label_kategori = $grafik_kategori->pluck('NAMA_KATEGORI');
        $data_kategori = $grafik_kategori->pluck('total');

        return view('dashboard.index', compact(
            'total_produk', 'total_kategori', 'total_pesanan', 'total_omset',
            'pesanan_baru', 'stok_menipis', 'produk_terbaru',
            'data_grafik_pesanan', 'label_kategori', 'data_kategori'
        ));
    }
}