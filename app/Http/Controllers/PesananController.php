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

    // 3. Update Status Pesanan - Memproses status dari Admin/Pegawai dan Pembeli
    public function updateStatus(Request $request, $id)
    {
        // 1. Cari pesanan berdasarkan ID, dan load data kurirnya secara otomatis (Eager Loading)
        $pesanan = Pesanan::with('pengiriman')->findOrFail($id);

        // ====================================================================
        // AKSI ADMIN/PEGAWAI: Mengirim Pesanan (Ubah status jadi 'Dikirim')
        // ====================================================================
        if ($request->status_pesanan == 'Dikirim') {
            
            // Ambil nama kurir dari database dan ubah ke huruf besar semua agar validasi mudah
            $namaKurir = strtoupper($pesanan->pengiriman->NAMA_KURIR);
            
            // Daftar nama kurir instan yang TIDAK WAJIB memiliki nomor resi
            $kurirInstan = ['AMBIL DI TOKO', 'GOJEK', 'GRAB', 'GOJEK/GRAB'];

            // Cek apakah kurir yang dipakai pembeli ada di dalam daftar kurir instan di atas?
            if (!in_array($namaKurir, $kurirInstan)) {
                
                // JIKA KURIR EKSPEDISI (JNE, J&T, POS, dll): Resi WAJIB diisi!
                $request->validate([
                    'resi_pengiriman' => 'required|string|max:50',
                ], [
                    'resi_pengiriman.required' => 'Nomor Resi wajib diisi untuk kurir ekspedisi!'
                ]);
                
                $nomorResi = $request->resi_pengiriman;
                
            } else {
                
                // JIKA AMBIL DI TOKO atau GOJEK: Abaikan validasi resi.
                // Jika Admin tidak mengisi apa-apa, otomatis diisi tulisan 'TANPA-RESI'.
                // Tapi jika Admin mengisi (misal: isi Plat Nomor Driver), maka simpan isian tersebut.
                $nomorResi = $request->resi_pengiriman ?? 'TANPA-RESI'; 
                
            }

            // Eksekusi Update ke Database
            $pesanan->update([
                'STATUS_PESANAN' => 'Dikirim',
                'RESI_PENGIRIMAN' => $nomorResi
            ]);

            return redirect()->back()->with('success', 'Pesanan berhasil dikirim. (Metode: ' . $pesanan->pengiriman->NAMA_KURIR . ')');
        }

        // ====================================================================
        // AKSI PEMBELI: Menyelesaikan Pesanan (Ubah status jadi 'Selesai')
        // ====================================================================
        if ($request->status_pesanan == 'Selesai') {
            
            $pesanan->update([
                'STATUS_PESANAN' => 'Selesai'
            ]);

            return redirect()->back()->with('success', 'Terima kasih! Pesanan telah selesai diterima.');
        }

        // Jika status yang dikirim form tidak valid
        return redirect()->back()->with('error', 'Status pesanan tidak valid.');
    }

    // 4. Cetak Struk/Invoice (Download PDF)
    public function cetakInvoice($id)
    {
        // Ambil data pesanan
        $pesanan = Pesanan::with(['user', 'detail.produk'])->findOrFail($id);

        // Pastikan pembeli hanya bisa cetak pesanannya sendiri
        if (Auth::user()->role == 'Pembeli' && $pesanan->ID_USER != Auth::id()) {
            abort(403, 'Akses Ditolak! Anda tidak bisa mencetak pesanan orang lain.');
        }

        // Load view HTML dan ubah jadi PDF
        $pdf = Pdf::loadView('pesanan.invoice', compact('pesanan'));
        
        // Return download langsung ke perangkat pembeli
        return $pdf->download('Invoice-Sasirangan-' . $pesanan->ID_PESANAN . '.pdf');
        
        // (Opsional) Kalau mau cuma tampil di tab browser dulu baru diprint, 
        // ganti kata download jadi stream: return $pdf->stream(...);
    }
}