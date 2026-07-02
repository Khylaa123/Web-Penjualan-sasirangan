<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class InventoryController extends Controller
{
<<<<<<< HEAD
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
=======
    public function index()
    {
        // Mengambil produk aktif untuk Dropdown Input
        $produk = Produk::where('STATUS_AKTIF', 1)->get(); 
        
        // Mengambil histori barang masuk/keluar
        $riwayat = RiwayatStok::with(['produk', 'user'])->orderBy('TANGGAL', 'desc')->get();
        
        return view('admin.inventory.index', compact('produk', 'riwayat'));
    }

    public function store(Request $request)
>>>>>>> 8ea2df5af7b9939347e9f9b7c1211e01aa3913c3
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

<<<<<<< HEAD
        return redirect()->route('inventory.index')
            ->with('success', 'Produk berhasil dihapus dari inventory');
=======
        RiwayatStok::create([
            'ID_PRODUK' => $request->ID_PRODUK,
            'ID_USER' => Auth::id(),
            'TIPE_PERGERAKAN' => $request->TIPE_PERGERAKAN,
            'JUMLAH' => $request->JUMLAH,
            'KETERANGAN' => $request->KETERANGAN,
            'TANGGAL' => now(), 
        ]);

        // Stok utama di tabel produk akan terupdate otomatis karena kamu punya Trigger MySQL
        return redirect()->back()->with('success', 'Data Inventory berhasil dicatat. Stok telah diperbarui.');
>>>>>>> 8ea2df5af7b9939347e9f9b7c1211e01aa3913c3
    }
}