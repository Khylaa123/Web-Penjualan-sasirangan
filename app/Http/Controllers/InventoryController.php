<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatStok;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    // Menampilkan halaman Laporan Inventory (DataTables)
    public function index()
    {
        // Mengambil data riwayat stok beserta relasi produk dan user yang input
        $riwayat = RiwayatStok::with(['produk', 'user'])->orderBy('TANGGAL', 'desc')->get();
        $produk = Produk::where('STATUS_AKTIF', 1)->get(); // Untuk dropdown form input
        
        return view('admin.inventory.index', compact('riwayat', 'produk'));
    }

    // Fungsi untuk menambah pergerakan barang (Masuk/Keluar)
    public function store(Request $request)
    {
        $request->validate([
            'ID_PRODUK' => 'required|exists:produk,ID_PRODUK',
            'TIPE_PERGERAKAN' => 'required|in:masuk,keluar',
            'JUMLAH' => 'required|integer|min:1',
            'KETERANGAN' => 'required|string|max:255'
        ]);

        // Insert murni ke riwayat_stok. Stok di tabel produk akan terupdate otomatis oleh Trigger MySQL
        RiwayatStok::create([
            'ID_PRODUK' => $request->ID_PRODUK,
            'ID_USER' => Auth::id(), // Mencatat siapa pegawai yang input
            'TIPE_PERGERAKAN' => $request->TIPE_PERGERAKAN,
            'JUMLAH' => $request->JUMLAH,
            'KETERANGAN' => $request->KETERANGAN,
            // TANGGAL otomatis terisi oleh current_timestamp
        ]);

        return redirect()->back()->with('success', 'Data pergerakan stok berhasil dicatat.');
    }
}