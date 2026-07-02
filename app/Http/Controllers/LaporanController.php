<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // 1. Menampilkan Halaman Utama Laporan + Filter Tanggal
    public function index(Request $request)
    {
        $tgl_mulai = $request->input('tgl_mulai');
        $tgl_sampai = $request->input('tgl_sampai');

        $query = Pesanan::with(['user', 'pembayaran'])
            ->whereHas('pembayaran', function ($q) {
                $q->where('STATUS_BAYAR', 'settlement');
            });

        if (!empty($tgl_mulai) && !empty($tgl_sampai)) {
            $query->whereBetween('TANGGAL_PESAN', [$tgl_mulai . ' 00:00:00', $tgl_sampai . ' 23:59:59']);
        }

        $pesanan = $query->orderBy('TANGGAL_PESAN', 'desc')->get();
        $total_pendapatan = $pesanan->sum('TOTAL_AKHIR');

        return view('laporan.index', compact('pesanan', 'total_pendapatan', 'tgl_mulai', 'tgl_sampai'));
    }

    // 2. Fungsi untuk Menangani Cetak Laporan
    public function cetak(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;

        $query = Pesanan::with(['user', 'pembayaran'])
            ->whereHas('pembayaran', function($q) {
                $q->where('STATUS_BAYAR', 'settlement');
            });

        if ($tgl_mulai && $tgl_sampai) {
            $query->whereBetween('TANGGAL_PESAN', [$tgl_mulai . ' 00:00:00', $tgl_sampai . ' 23:59:59']);
        }

        $pesanan = $query->orderBy('TANGGAL_PESAN', 'desc')->get();
        $total_pendapatan = $pesanan->sum('TOTAL_AKHIR');

        // PERBAIKAN: Hapus "admin." karena foldermu langsung bernama "laporan"
        return view('laporan.cetak', compact('pesanan', 'total_pendapatan', 'tgl_mulai', 'tgl_sampai'));
    }
}