<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class ProdukController extends Controller
{
    // 1. Menampilkan daftar produk
    public function index()
    {
        $produk = Produk::with('kategori')->get();
        return view('produk.index', compact('produk'));
    }

    // 2. Form tambah produk
    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    // 3. Simpan produk (langsung masuk inventory)
    public function store(Request $request)
    {
        $request->validate([
            'ID_KATEGORI'  => 'required',
            'NAMA_PRODUK'  => 'required|string|max:100',
            'DESKRIPSI'    => 'nullable|string',
            'BERAT_GRAM'   => 'required|integer|min:0',
            'HARGA'        => 'required|numeric|min:0',
            'STOK'         => 'required|integer|min:0',
            'STATUS_AKTIF' => 'required',
            'GAMBAR_UTAMA' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $kategori = Kategori::findOrFail($request->ID_KATEGORI);
        $prefix = $kategori->PREFIX_KODE ?? 'BRG';

        $produkTerakhir = Produk::where('ID_KATEGORI', $request->ID_KATEGORI)
                                ->orderBy('ID_PRODUK', 'desc')
                                ->first();

        if ($produkTerakhir && $produkTerakhir->KODE_PRODUK) {
            $pecahKode = explode('-', $produkTerakhir->KODE_PRODUK);
            $nomorUrut = (int) end($pecahKode) + 1;
        } else {
            $nomorUrut = 1;
        }

        $kodeProdukBaru = $prefix . '-' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        $nama_foto = null;
        if ($request->hasFile('GAMBAR_UTAMA')) {
            $file = $request->file('GAMBAR_UTAMA');
            $nama_foto = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $nama_foto);
        }

        Produk::create([
            'ID_KATEGORI'  => $request->ID_KATEGORI,
            'KODE_PRODUK'  => $kodeProdukBaru,
            'NAMA_PRODUK'  => $request->NAMA_PRODUK,
            'DESKRIPSI'    => $request->DESKRIPSI,
            'BERAT_GRAM'   => $request->BERAT_GRAM,
            'HARGA'        => $request->HARGA,
            'STOK'         => $request->STOK,
            'STATUS_AKTIF' => $request->STATUS_AKTIF,
            'GAMBAR_UTAMA' => $nama_foto
        ]);

        // langsung masuk inventory
        return redirect()->route('inventory.index')
            ->with('success', 'Produk masuk ke inventory (tanpa drama edit).');
    }

    // 6. Hapus produk (admin only biasanya)
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->GAMBAR_UTAMA && file_exists(public_path('uploads/produk/' . $produk->GAMBAR_UTAMA))) {
            unlink(public_path('uploads/produk/' . $produk->GAMBAR_UTAMA));
        }

        $produk->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Produk berhasil dihapus dari inventory.');
    }

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

        // Jika kamu pakai cara mapping manual, pastikan baris ini ada:
        $produk->DISKON_PERSEN = $request->DISKON_PERSEN ?? 0;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }
}
