<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryExportController extends Controller
{
    public function export()
    {
        $produk = Produk::with('kategori')->get();

        $total_produk = $produk->count();
        $total_stok = $produk->sum('STOK');

        $nilai_inventory = $produk->sum(function ($item) {
            return ($item->HARGA ?? 0) * ($item->STOK ?? 0);
        });

        // Load view PDF
        $pdf = Pdf::loadView('inventory.pdf', compact(
            'produk',
            'total_produk',
            'total_stok',
            'nilai_inventory'
        ));

        // PERBAIKAN: Menggunakan stream() agar PDF terbuka (Preview) di browser, bukan langsung terdownload
        return $pdf->stream('Laporan_Inventory_Mellisari.pdf');
    }
}