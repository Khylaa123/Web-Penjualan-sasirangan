<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function penjualan()
    {
        // Hanya ambil transaksi yang uangnya masuk (settlement/lunas)
        $laporanPenjualan = Pesanan::with(['user', 'pembayaran'])
            ->whereHas('pembayaran', function($query) {
                $query->where('STATUS_BAYAR', 'settlement');
            })
            ->orderBy('TANGGAL_PESAN', 'desc')
            ->get();

        return view('admin.laporan.penjualan', compact('laporanPenjualan'));
    }
}