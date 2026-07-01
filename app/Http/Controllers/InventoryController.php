<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatStok;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        // Mengambil produk aktif untuk Dropdown Input
        $produk = Produk::where('STATUS_AKTIF', 1)->get(); 
        
        // Mengambil histori barang masuk/keluar
        $riwayat = RiwayatStok::with(['produk', 'user'])->orderBy('TANGGAL', 'desc')->get();
        
        return view('admin.inventory.index', compact('produk', 'riwayat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ID_PRODUK' => 'required|exists:produk,ID_PRODUK',
            'TIPE_PERGERAKAN' => 'required|in:masuk,keluar',
            'JUMLAH' => 'required|integer|min:1',
            'KETERANGAN' => 'required|string|max:255'
        ]);

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
    }
}