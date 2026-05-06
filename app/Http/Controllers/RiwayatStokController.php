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
        $riwayat = RiwayatStok::with(['produk', 'user'])->orderBy('TANGGAL', 'desc')->get();
        return view('riwayat_stok.index', compact('riwayat'));
    }

    // Menampilkan form tambah stok masuk/keluar
    public function create()
    {
        $produk = Produk::where('STATUS_AKTIF', 1)->get();
        return view('riwayat_stok.create', compact('produk'));
    }

    // Menyimpan data pergerakan stok
    public function store(Request $request)
    {
        $request->validate([
            'ID_PRODUK'       => 'required',
            'TIPE_PERGERAKAN' => 'required|in:masuk,keluar',
            'JUMLAH'          => 'required|integer|min:1',
            'KETERANGAN'      => 'nullable|string|max:255'
        ]);

        // Cek validasi khusus jika barang KELUAR
        if ($request->TIPE_PERGERAKAN == 'keluar') {
            $produk = Produk::findOrFail($request->ID_PRODUK);
            if ($produk->STOK < $request->JUMLAH) {
                return back()->withErrors(['JUMLAH' => 'Gagal! Stok produk saat ini ('.$produk->STOK.') tidak mencukupi untuk dikeluarkan.']);
            }
        }

        RiwayatStok::create([
            'ID_PRODUK'       => $request->ID_PRODUK,
            // Jika belum login sempurna, sementara pakai ID 1 agar tidak error
            'ID_USER'         => Auth::id() ?? 1, 
            'TIPE_PERGERAKAN' => $request->TIPE_PERGERAKAN,
            'JUMLAH'          => $request->JUMLAH,
            'KETERANGAN'      => $request->KETERANGAN
        ]);

        return redirect()->route('riwayat-stok.index')->with('success', 'Riwayat stok berhasil dicatat! Stok utama otomatis diperbarui.');
    }
}