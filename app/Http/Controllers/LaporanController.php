<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class LaporanController extends Controller
{
    // Menampilkan halaman filter laporan
    public function index(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;

        // Mulai query pencarian (hanya pesanan yang sudah sukses/selesai/dikirim)
        $query = Pesanan::with('user')->whereIn('STATUS_PESANAN', ['Dikirim', 'Selesai']);

        // Jika user memilih tanggal filter
        if ($tgl_mulai && $tgl_sampai) {
            $query->whereBetween('TANGGAL_PESAN', [$tgl_mulai . ' 00:00:00', $tgl_sampai . ' 23:59:59']);
        }

        $pesanan = $query->orderBy('TANGGAL_PESAN', 'desc')->get();
        $total_pendapatan = $pesanan->sum('TOTAL_AKHIR');

        return view('laporan.index', compact('pesanan', 'tgl_mulai', 'tgl_sampai', 'total_pendapatan'));
    }

    // Menampilkan halaman khusus cetak (tanpa sidebar dsb)
    public function cetak(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $tgl_sampai = $request->tgl_sampai;

        $query = Pesanan::with('user')->whereIn('STATUS_PESANAN', ['Dikirim', 'Selesai']);

        if ($tgl_mulai && $tgl_sampai) {
            $query->whereBetween('TANGGAL_PESAN', [$tgl_mulai . ' 00:00:00', $tgl_sampai . ' 23:59:59']);
        }

        $pesanan = $query->orderBy('TANGGAL_PESAN', 'asc')->get();
        $total_pendapatan = $pesanan->sum('TOTAL_AKHIR');

        return view('laporan.cetak', compact('pesanan', 'tgl_mulai', 'tgl_sampai', 'total_pendapatan'));
    }
}