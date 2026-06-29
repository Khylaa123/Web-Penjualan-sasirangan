<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    // 1. Fungsi untuk MENAMPILKAN form tambah data
    public function create()
    {
        return view('kategori.create');
    }

    // 2. Fungsi untuk MENYIMPAN data dari form ke database
    public function store(Request $request)
    {
        // 1. Validasi Input Kategori
        $request->validate([
            'NAMA_KATEGORI' => 'required|string|max:50',
            'ICON'          => 'nullable|string'
        ]);

        // 2. LOGIKA GENERATE PREFIX OTOMATIS
        // Ubah nama kategori jadi huruf kapital semua dan hilangkan spasi berlebih
        $nama_kategori = strtoupper(trim($request->NAMA_KATEGORI));
        
        // Pecah nama kategori berdasarkan spasi (Contoh: "Kain" "Sasirangan" "Meteran")
        $kata = explode(' ', $nama_kategori);
        $prefix = '';

        if (count($kata) >= 3) {
            // Jika 3 kata atau lebih, ambil huruf pertama dari 3 kata pertama (Kain Sasirangan Meteran -> KSM)
            $prefix = substr($kata[0], 0, 1) . substr($kata[1], 0, 1) . substr($kata[2], 0, 1);
        } elseif (count($kata) == 2) {
            // Jika 2 kata, ambil 1 huruf dari kata pertama, 2 huruf dari kata kedua (Kain Sasirangan -> KSA)
            $prefix = substr($kata[0], 0, 1) . substr($kata[1], 0, 2);
        } else {
            // Jika cuma 1 kata, ambil 3 huruf pertama dari kata itu (Baju -> BAJ)
            $prefix = substr($nama_kategori, 0, 3);
        }

        // Bersihkan dari simbol/angka jika ada, pastikan murni huruf A-Z
        $prefix = preg_replace('/[^A-Z]/', '', $prefix);


        // 3. Simpan ke Database
        Kategori::create([
            'NAMA_KATEGORI' => $request->NAMA_KATEGORI,
            'PREFIX_KODE'   => $prefix, // <-- Masukkan hasil singkatan otomatis ke sini
            'ICON'          => $request->ICON
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori baru berhasil ditambahkan dengan prefix: ' . $prefix);
    }

    // 3. Fungsi untuk MENAMPILKAN form Edit Data
    public function edit($id)
    {
        // Cari data kategori berdasarkan ID_KATEGORI
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    // 4. Fungsi untuk MENYIMPAN PERUBAHAN data (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'NAMA_KATEGORI' => 'required|string|max:50',
            'ICON' => 'nullable|string|max:255'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'NAMA_KATEGORI' => $request->NAMA_KATEGORI,
            'ICON' => $request->ICON
        ]);

        return redirect()->route('kategori.index')->with('success', 'Data Kategori berhasil diperbarui!');
    }

    // 5. Fungsi untuk MENGHAPUS data (Delete)
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        // Syarat TA: Pesan data sudah terhapus
        return redirect()->route('kategori.index')->with('success', 'Data Kategori berhasil dihapus!');
    }
};