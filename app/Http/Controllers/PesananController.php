<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        // Ubah urutan berdasarkan TANGGAL_PESAN
        $pesanan = Pesanan::with('user')->orderBy('TANGGAL_PESAN', 'desc')->get();
        return view('pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'detail.produk'])->findOrFail($id);
        return view('pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'STATUS_PESANAN' => $request->status,
            'RESI_PENGIRIMAN' => $request->resi ?? $pesanan->RESI_PENGIRIMAN // Sesuaikan nama kolom resi
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}