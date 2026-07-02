<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // QUERY INVENTORY (FILTER)
        // =========================
        $query = Produk::with('kategori');

        // SEARCH
        if ($request->search) {
            $query->where('NAMA_PRODUK', 'like', '%' . $request->search . '%');
        }

        // FILTER KATEGORI
        if ($request->kategori) {
            $query->where('ID_KATEGORI', $request->kategori);
        }

        // FILTER STOK
        if ($request->stok == 'menipis') {
            $query->where('STOK', '<=', 10);
        } elseif ($request->stok == 'habis') {
            $query->where('STOK', '<=', 0);
        } elseif ($request->stok == 'aman') {
            $query->where('STOK', '>', 10);
        }

        $produk = $query->get();

        // =========================
        // STATISTIK GLOBAL (OPTIMIZED)
        // =========================
        $total_produk = Produk::count();

        $total_stok = Produk::sum('STOK');

        $stok_menipis = Produk::where('STOK', '<=', 10)->count();

        $nilai_inventory = Produk::all()->sum(function ($item) {
            return ($item->HARGA ?? 0) * ($item->STOK ?? 0);
        });

        // =========================
        // DATA DROPDOWN KATEGORI
        // =========================
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
    // DELETE INVENTORY
    // =========================
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Produk berhasil dihapus dari inventory');
    }
}