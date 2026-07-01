<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UlasanProduk;
use App\Models\Pesanan;
use Illuminate\Support\Facades\\Auth;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi inputan dari form Frontend
        $request->validate([
            'id_produk' => 'required',
            'rating'    => 'required|integer|min:1|max:5',
            'komentar'  => 'required|string|max:500'
        ]);

        $id_user = Auth::id();
        $id_produk = $request->id_produk;

        // 2. LOGIKA INTI: Cek apakah user pernah beli produk ini DAN statusnya 'Selesai'
        // Kita menggunakan whereHas untuk mengecek ke dalam tabel detail_pesanan
        $pernahBeli = Pesanan::where('ID_USER', $id_user)
            ->where('STATUS_PESANAN', 'Selesai')
            ->whereHas('detail', function ($query) use ($id_produk) {
                $query->where('ID_PRODUK', $id_produk);
            })->exists();

        // Jika tidak pernah beli atau belum selesai, tolak!
        if (!$pernahBeli) {
            return redirect()->back()->with('error', 'Maaf, Anda hanya bisa memberikan ulasan pada produk yang telah dibeli dan pesanannya telah selesai.');
        }

        // 3. (Opsional) Cek apakah user sudah pernah mengulas produk ini sebelumnya
        $sudahUlas = UlasanProduk::where('ID_USER', $id_user)
            ->where('ID_PRODUK', $id_produk)
            ->first();

        if ($sudahUlas) {
            // Jika sudah ada, kita update saja ulasan lamanya
            $sudahUlas->update([
                'RATING' => $request->rating,
                'KOMENTAR' => $request->komentar,
                'TANGGAL_ULASAN' => now()
            ]);
            return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui!');
        }

        // 4. Jika lolos semua cek, simpan ulasan baru
        UlasanProduk::create([
            'ID_PRODUK'      => $id_produk,
            'ID_USER'        => $id_user,
            'RATING'         => $request->rating,
            'KOMENTAR'       => $request->komentar,
            'TANGGAL_ULASAN' => now()
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');
    }
}