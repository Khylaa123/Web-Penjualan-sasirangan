<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class KeranjangController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        return view('keranjang.index');
    }

    // Fungsi untuk menghapus produk dari keranjang
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    // Fungsi untuk menambahkan produk ke keranjang
    public function add(Request $request, $id)
    {
        // Cari data produk berdasarkan ID
        $produk = Produk::findOrFail($id);
        
        // Ambil sesi keranjang saat ini
        $cart = session()->get('cart', []);

        // Tangkap input angka dari Front-End (jika tidak ada input, anggap 1)
        $jumlah_pesan = (int) $request->input('jumlah', 1);

        // Jika produk sudah ada di keranjang, tambah jumlahnya sesuai inputan
        if(isset($cart[$id])) {
            $cart[$id]['jumlah'] += $jumlah_pesan; 
        } else {
            // Jika belum ada, buat item baru di keranjang
            $cart[$id] = [
                "nama_produk" => $produk->NAMA_PRODUK,
                "jumlah"      => $jumlah_pesan, 
                "harga"       => $produk->harga_akhir, 
                "gambar"      => $produk->GAMBAR_UTAMA, 
                "berat"       => $produk->BERAT_GRAM
            ];
        }

        // Simpan kembali ke sesi
        session()->put('cart', $cart);

        return redirect()->back()->with('success', $produk->NAMA_PRODUK . ' berhasil ditambahkan ke keranjang sebanyak ' . $jumlah_pesan . ' item!');
    }
}