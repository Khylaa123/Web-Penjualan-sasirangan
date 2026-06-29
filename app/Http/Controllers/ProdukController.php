<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori; // Panggil model Kategori untuk relasi

class ProdukController extends Controller
{
    // 1. Menampilkan daftar produk
    public function index()
    {
        // Ambil semua produk beserta data kategorinya (Eager Loading)
        $produk = Produk::with('kategori')->get();
        return view('produk.index', compact('produk'));
    }

    // 2. Menampilkan form tambah produk
    public function create()
    {
        // Ambil semua data kategori untuk dimasukkan ke opsi Dropdown (Pilihan)
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    // 3. Fungsi untuk MENYIMPAN produk baru ke database
    public function store(Request $request)
    {
        // 1. Validasi Input (Tetap sama seperti yang kamu buat)
        $request->validate([
            'ID_KATEGORI'  => 'required',
            'NAMA_PRODUK'  => 'required|string|max:100',
            'DESKRIPSI'    => 'nullable|string',
            'BERAT_GRAM'   => 'required|integer|min:0',
            'HARGA'        => 'required|numeric|min:0', 
            'STOK'         => 'required|integer|min:0', 
            'STATUS_AKTIF' => 'required',
            'GAMBAR_UTAMA' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2. GENERATE KODE PRODUK OTOMATIS (SKU)
        // Ambil data kategori yang dipilih untuk mendapatkan Prefix-nya
        $kategori = Kategori::findOrFail($request->ID_KATEGORI);
        
        // Gunakan prefix dari database, jika kosong gunakan default 'BRG'
        $prefix = $kategori->PREFIX_KODE ? $kategori->PREFIX_KODE : 'BRG'; 

        // Cari produk terakhir di kategori yang sama untuk menentukan nomor urut selanjutnya
        $produkTerakhir = Produk::where('ID_KATEGORI', $request->ID_KATEGORI)
                                ->orderBy('ID_PRODUK', 'desc')
                                ->first();

        if ($produkTerakhir && $produkTerakhir->KODE_PRODUK) {
            // Jika sudah ada (contoh: KNS-002), pecah stringnya, ambil angkanya, lalu tambah 1
            $pecahKode = explode('-', $produkTerakhir->KODE_PRODUK);
            $nomorUrut = (int) end($pecahKode) + 1; 
        } else {
            // Jika ini adalah produk pertama di kategori tersebut
            $nomorUrut = 1; 
        }

        // Format nomor urut jadi 3 digit angka (contoh hasil: KNS-001, KNS-002)
        $kodeProdukBaru = $prefix . '-' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);


        // 3. Proses Upload Gambar
        $nama_foto = null;
        if ($request->hasFile('GAMBAR_UTAMA')) {
            $file = $request->file('GAMBAR_UTAMA');
            $nama_foto = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $nama_foto);
        }

        // 4. Simpan ke Database beserta KODE_PRODUK yang sudah digenerate
        Produk::create([
            'ID_KATEGORI'  => $request->ID_KATEGORI,
            'KODE_PRODUK'  => $kodeProdukBaru, // <-- Masukkan kode otomatis di sini
            'NAMA_PRODUK'  => $request->NAMA_PRODUK,
            'DESKRIPSI'    => $request->DESKRIPSI,
            'BERAT_GRAM'   => $request->BERAT_GRAM,
            'HARGA'        => $request->HARGA,
            'STOK'         => $request->STOK,
            'STATUS_AKTIF' => $request->STATUS_AKTIF,
            'GAMBAR_UTAMA' => $nama_foto
        ]);

        // Redirect atau return response sesuai kebutuhan sistem kamu
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan dengan kode: ' . $kodeProdukBaru);
    }

    // Fungsi untuk MENGHAPUS produk
    public function destroy($id)
    {
        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Cek apakah produk punya gambar, kalau ada hapus juga file fisiknya
        if ($produk->GAMBAR_UTAMA && file_exists(public_path('uploads/produk/' . $produk->GAMBAR_UTAMA))) {
            unlink(public_path('uploads/produk/' . $produk->GAMBAR_UTAMA));
        }

        // Hapus data dari database
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    // Menampilkan form edit produk
    // Menampilkan form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Ganti KategoriProduk menjadi Kategori (Sesuai dengan nama file Model Anda)
        $kategori = \App\Models\Kategori::all(); 

        return view('produk.edit', compact('produk', 'kategori'));
    }

    // Memproses update data ke database
    public function update(Request $request, $id)
    {
        // Validasi sekarang wajibkan Harga dan Stok
        $request->validate([
            'ID_KATEGORI'  => 'required',
            'NAMA_PRODUK'  => 'required|string|max:150',
            'DESKRIPSI'    => 'required|string',
            'BERAT_GRAM'   => 'required|integer|min:0',
            'HARGA'        => 'required|numeric|min:0',
            'STOK'         => 'required|integer|min:0',
            'STATUS_AKTIF' => 'required',
            'GAMBAR_UTAMA' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $produk = Produk::findOrFail($id);
        $nama_foto = $produk->GAMBAR_UTAMA;

        // Jika Admin mengupload gambar baru
        if ($request->hasFile('GAMBAR_UTAMA')) {
            if ($nama_foto && file_exists(public_path('uploads/produk/' . $nama_foto))) {
                unlink(public_path('uploads/produk/' . $nama_foto));
            }
            $file = $request->file('GAMBAR_UTAMA');
            $nama_foto = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $nama_foto);
        }

        // Update data ke database (Kode Produk tidak diubah karena permanen)
        $produk->update([
            'ID_KATEGORI'  => $request->ID_KATEGORI,
            'NAMA_PRODUK'  => $request->NAMA_PRODUK,
            'DESKRIPSI'    => $request->DESKRIPSI,
            'BERAT_GRAM'   => $request->BERAT_GRAM,
            'HARGA'        => $request->HARGA,
            'STOK'         => $request->STOK,
            'STATUS_AKTIF' => $request->STATUS_AKTIF,
            'GAMBAR_UTAMA' => $nama_foto
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }
}