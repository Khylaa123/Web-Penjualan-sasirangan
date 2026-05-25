<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    // 1. Menampilkan Daftar Pesanan
    public function index()
    {
        $user = Auth::user();

        // Cek siapa yang sedang login
        if ($user->role == 'Admin' || $user->role == 'Pegawai') {
            // Jika Admin/Pegawai, ambil SEMUA data pesanan, urutkan dari yang terbaru
            // (Eager loading 'user' agar bisa menampilkan nama pembeli di tabel)
            $pesanan = Pesanan::with('user')->orderBy('TANGGAL_PESANAN', 'desc')->get();
        } else {
            // Jika Pembeli, HANYA ambil data pesanan miliknya sendiri
            $pesanan = Pesanan::where('ID_USER', $user->id)
                              ->orderBy('TANGGAL_PESANAN', 'desc')
                              ->get();
        }

        return view('pesanan.index', compact('pesanan'));
    }

    // 2. Menampilkan Detail Pesanan (Invoice/Struk)
    public function show($id)
    {
        // Ambil data pesanan beserta relasi user dan detail barang yang dibeli
        $pesanan = Pesanan::with(['user', 'detail.produk'])->findOrFail($id);

        // Keamanan tambahan: Cegah pembeli mengintip pesanan orang lain lewat URL
        if (Auth::user()->role == 'Pembeli' && $pesanan->ID_USER != Auth::id()) {
            abort(403, 'Akses Ditolak! Ini bukan pesanan Anda.');
        }

        return view('pesanan.show', compact('pesanan'));
    }

    // 3. Update Status Pesanan (Hanya untuk Admin/Pegawai)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Lunas,Diproses,Selesai,Dibatalkan'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'STATUS_PESANAN' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diubah menjadi: ' . $request->status);
    }
}