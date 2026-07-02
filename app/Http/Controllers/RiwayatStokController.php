<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatStok;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class RiwayatStokController extends Controller
{
    // Menampilkan halaman riwayat barang masuk & keluar
    public function index()
    {
        // Ambil riwayat stok
        $riwayat = RiwayatStok::with(['produk', 'user'])->orderBy('TANGGAL', 'desc')->get();
        
        // Ambil data produk untuk dropdown di dalam Modal
        $produk = Produk::where('STATUS_AKTIF', 1)->get();
        
        // Pastikan nama foldernya sesuai dengan tempat kamu menyimpan file index.blade.php
        return view('riwayat_stok.index', compact('riwayat', 'produk'));
    }

    // Menyimpan data pergerakan stok
    public function store(Request $request)
    {
        $request->validate([
            'ID_PRODUK'       => 'required',
            'TIPE_PERGERAKAN' => 'required|in:masuk,keluar',
            'JUMLAH'          => 'required|integer|min:1',
            'KETERANGAN'      => 'required|string|max:255' // Ubah nullable jadi required jika wajib diisi
        ]);

        // Cek validasi khusus jika barang KELUAR (Logika yang sangat bagus!)
        if ($request->TIPE_PERGERAKAN == 'keluar') {
            $produk = Produk::findOrFail($request->ID_PRODUK);
            if ($produk->STOK < $request->JUMLAH) {
                return back()->withErrors(['JUMLAH' => 'Gagal! Stok produk saat ini ('.$produk->STOK.') tidak mencukupi untuk dikeluarkan.']);
            }
        }

        RiwayatStok::create([
            'ID_PRODUK'       => $request->ID_PRODUK,
            'ID_USER'         => Auth::id() ?? 1, // Fallback ke ID 1 jika belum login (untuk testing)
            'TIPE_PERGERAKAN' => $request->TIPE_PERGERAKAN,
            'JUMLAH'          => $request->JUMLAH,
            'KETERANGAN'      => $request->KETERANGAN
        ]);

        return redirect()->route('riwayat-stok.index')->with('success', 'Riwayat stok berhasil dicatat! Stok utama otomatis diperbarui.');
    }

    // Menghapus data pergerakan stok
    public function destroy($id)
    {
        $riwayat = RiwayatStok::findOrFail($id);
        
        // Hapus data riwayat. Pastikan Trigger MySQL di databasemu sudah siap menangani pengembalian stok saat data dihapus.
        $riwayat->delete();

        return redirect()->route('riwayat-stok.index')->with('success', 'Riwayat stok berhasil dihapus! Stok utama otomatis disesuaikan.');
    }
}