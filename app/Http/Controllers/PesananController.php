<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
            $pesanan = Pesanan::with('user')->orderBy('TANGGAL_PESAN', 'desc')->get();
        } else {
            // Jika Pembeli, HANYA ambil data pesanan miliknya sendiri
            $pesanan = Pesanan::where('ID_USER', $user->id)
                              ->orderBy('TANGGAL_PESAN', 'desc')
                              ->get();
        }

        return view('pesanan.index', compact('pesanan'));
    }

    // 2. Menampilkan Detail Pesanan (Invoice/Struk)
   public function show($id)
    {
        // Memuat pesanan utuh dari database
        $pesanan = Pesanan::with(['user', 'detail.produk'])->findOrFail($id);

        if (Auth::user()->role == 'Pembeli' && $pesanan->ID_USER != Auth::id()) {
            abort(403);
        }

        return view('pesanan.detail_pesanan', compact('pesanan'));
    }

    // 3. Update Status Pesanan - Memproses status dari Admin/Pegawai dan Pembeli
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::with('pengiriman')->findOrFail($id);
        $statusBaru = $request->input('status', $request->input('status_pesanan'));
        $resi = $request->input('resi', $request->input('resi_pengiriman'));

        if ($statusBaru == 'Diproses' || $statusBaru == 'Dibatalkan') {
            $pesanan->update([
                'STATUS_PESANAN' => $statusBaru,
            ]);

            return redirect()->back()->with('success', 'Status pesanan berhasil diubah menjadi ' . $statusBaru);
        }

        if ($statusBaru == 'Dikirim') {
            $namaKurir = strtoupper($pesanan->pengiriman->NAMA_KURIR ?? '');
            
            // Cek apakah metode pengiriman termasuk ekspedisi (JNE/J&T/dll) atau instan/ambil sendiri
            $isEkspedisi = ($pesanan->ID_PENGIRIMAN == 3) || in_array($namaKurir, ['JNE', 'J&T', 'KURIR / JNE', 'EKSPEDISI']);

            if ($isEkspedisi) {
                // Jika ekspedisi, wajib mengisi nomor resi asli
                $request->validate([
                    'resi' => 'required|string|max:50',
                ], [
                    'resi.required' => 'Nomor Resi wajib diisi untuk kurir ekspedisi!'
                ]);

                $nomorResi = $resi;
            } else {
                // Jika instan (Gojek/Ambil Sendiri/COD), otomatis diset TANPA-RESI oleh sistem
                $nomorResi = 'TANPA-RESI';
            }

            $pesanan->update([
                'STATUS_PESANAN' => 'Dikirim',
                'RESI_PENGIRIMAN' => $nomorResi
            ]);

            return redirect()->back()->with('success', 'Pesanan berhasil dikirim. (Metode: ' . ($pesanan->pengiriman->NAMA_KURIR ?? 'Instan') . ')');
        }

        if ($statusBaru == 'Selesai') {
            $pesanan->update([
                'STATUS_PESANAN' => 'Selesai'
            ]);

            return redirect()->back()->with('success', 'Terima kasih! Pesanan telah selesai diterima.');
        }

        return redirect()->back()->with('error', 'Status pesanan tidak valid.');
    }

    public function cetakInvoice($id)
    {
        // Memuat data pesanan utuh untuk di-convert ke PDF
        $pesanan = Pesanan::with(['user', 'detail.produk'])->where('ID_PESANAN', $id)->firstOrFail();

        if (Auth::user()->role == 'Pembeli' && $pesanan->ID_USER != Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pesanan.invoice', compact('pesanan'));
        return $pdf->stream('invoice-' . $pesanan->ID_PESANAN . '.pdf');
    }
}