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
        // Validasi: Pastikan nama kategori wajib diisi (Syarat pesan error TA)
        $request->validate([
            'NAMA_KATEGORI' => 'required|string|max:50',
            'ICON' => 'nullable|string|max:255'
        ], [
            'NAMA_KATEGORI.required' => 'Nama Kategori wajib diisi!' // Pesan error kustom
        ]);

        // Simpan data ke database
        Kategori::create([
            'NAMA_KATEGORI' => $request->NAMA_KATEGORI,
            'ICON' => $request->ICON
        ]);

        // Lempar kembali ke halaman index dan bawa pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Data Kategori berhasil disimpan!');
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