<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UlasanProduk;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input yang dikirim dari Modal
        $request->validate([
            'ID_PESANAN' => 'required',
            'RATING'     => 'required|integer|min:1|max:5',
            'KOMENTAR'   => 'required|string|max:500'
        ]);

        $id_user = Auth::id();
        $id_pesanan = $request->ID_PESANAN;

        // 2. Cari data pesanan dan ambil 'detail'-nya
        $pesanan = Pesanan::with('detail')
            ->where('ID_PESANAN', $id_pesanan)
            ->where('ID_USER', $id_user) 
            ->first();

        // 3. Validasi Keamanan (Harus ada pesanan dan status Selesai)
        if (!$pesanan || $pesanan->STATUS_PESANAN !== 'Selesai') {
            return redirect()->back()->with('error', 'Maaf, Anda hanya bisa memberikan ulasan pada pesanan yang telah selesai.');
        }

        // 4. Ambil ID_DETAIL dari pesanan tersebut
        $detailPesanan = $pesanan->detail->first();
        if (!$detailPesanan) {
            return redirect()->back()->with('error', 'Data produk pada pesanan ini tidak ditemukan.');
        }

        // INI KUNCI UTAMANYA: Kita ambil ID_DETAIL
        $id_detail = $detailPesanan->ID_DETAIL;

        // 5. Cek apakah ID_DETAIL ini sudah pernah diulas sebelumnya
        $sudahUlas = UlasanProduk::where('ID_DETAIL', $id_detail)->first();

        if ($sudahUlas) {
            // Jika sudah ada, Update ulasan lama
            $sudahUlas->update([
                'RATING'         => $request->RATING,
                'KOMENTAR'       => $request->KOMENTAR,
                'TANGGAL_ULASAN' => now()
            ]);
            return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui!');
        }

        // 6. Simpan ulasan baru dengan mencantumkan ID_DETAIL sesuai kolom databasemu
        UlasanProduk::create([
            'ID_DETAIL'      => $id_detail,
            'RATING'         => $request->RATING,
            'KOMENTAR'       => $request->KOMENTAR,
            'TANGGAL_ULASAN' => now()
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');
    }
}