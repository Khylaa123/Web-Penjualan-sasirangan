<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // WAJIB: Import package PDF-nya

class InventoryController extends Controller
{
    // =========================
    // 1. TAMPILKAN DATA INVENTORY
    // =========================
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->search) {
            $query->where('NAMA_PRODUK', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('ID_KATEGORI', $request->kategori);
        }

        if ($request->stok == 'menipis') {
            $query->where('STOK', '<=', 10);
        } elseif ($request->stok == 'habis') {
            $query->where('STOK', '<=', 0);
        } elseif ($request->stok == 'aman') {
            $query->where('STOK', '>', 10);
        }

        $produk = $query->get();

        $total_produk = Produk::count();
        $total_stok = Produk::sum('STOK');
        $stok_menipis = Produk::where('STOK', '<=', 10)->count();

        $nilai_inventory = Produk::all()->sum(function ($item) {
            return ($item->HARGA ?? 0) * ($item->STOK ?? 0);
        });

        $kategori_list = Kategori::all();

        return view('inventory.index', compact(
            'produk',
            'total_produk',
            'total_stok',
            'stok_menipis',
            'nilai_inventory',
            'kategori_list'
        ));
    }

    // =========================
    // 2. EXPORT PDF INVENTORY
    // =========================
    public function pdf()
    {
        // Ambil semua data produk untuk PDF
        $produk = Produk::with('kategori')->get();

        $total_produk = $produk->count();
        $total_stok = $produk->sum('STOK');

        $nilai_inventory = $produk->sum(function ($item) {
            return ($item->HARGA ?? 0) * ($item->STOK ?? 0);
        });

        // Load view PDF (Pastikan file view-mu bernama pdf.blade.php dan ada di folder resources/views/inventory/)
        $pdf = Pdf::loadView('inventory.pdf', compact(
            'produk',
            'total_produk',
            'total_stok',
            'nilai_inventory'
        ));

        // Download otomatis dengan nama file rapi
        return $pdf->download('Laporan_Inventory_Mellisari.pdf');
    }

    // =========================
    // 3. DELETE INVENTORY
    // =========================
    public function destroy(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $id_produk = $produk->ID_PRODUK;
        
        $produk->delete();

        // Catat riwayat penghapusan stok
        RiwayatStok::create([
            'ID_PRODUK' => $id_produk,
            'ID_USER' => Auth::id(),
            'TIPE_PERGERAKAN' => $request->TIPE_PERGERAKAN ?? 'Keluar',
            'JUMLAH' => $request->JUMLAH ?? 0,
            'KETERANGAN' => $request->KETERANGAN ?? 'Dihapus dari sistem',
            'TANGGAL' => now(), 
        ]);

        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus.');
    }
}