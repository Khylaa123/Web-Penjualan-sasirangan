<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\RiwayatStok; // Untuk berjaga-jaga kalau batal
use Illuminate\Support\Facades\Log; // Untuk mencatat log error

class CallbackController extends Controller
{
    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        
        // 1. Ambil data dari Midtrans
        $order_id = $request->order_id;
        $status_code = $request->status_code;
        $gross_amount = $request->gross_amount;
        $transaction_status = $request->transaction_status;
        
        // 2. Keamanan: Buat signature key untuk dicocokkan dengan Midtrans
        $hashed = hash("sha512", $order_id . $status_code . $gross_amount . $serverKey);
        
        // Jika kuncinya sama, berarti ini benar-benar Midtrans (Bukan hacker)
        if ($hashed == $request->signature_key) {
            
            // PERBAIKAN LOGIKA EXPLODE ID
            $pecah_id = explode('-', $order_id);
            array_pop($pecah_id); // Buang array paling belakang (timestamp)
            $id_pesanan_asli = implode('-', $pecah_id); // Gabungkan sisanya (Menghasilkan: ORD-999)
            
            // Cari data pesanannya di database
            $pesanan = Pesanan::find($id_pesanan_asli);
            
            if ($pesanan) {
                // 3. Logic Perubahan Status
                if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
                    // JIKA PEMBAYARAN SUKSES
                    $pesanan->update(['STATUS_PESANAN' => 'Diproses']);
                    
                } else if ($transaction_status == 'cancel' || $transaction_status == 'deny' || $transaction_status == 'expire') {
                    // JIKA PEMBAYARAN GAGAL/BATAL
                    $pesanan->update(['STATUS_PESANAN' => 'Dibatalkan']);
                    
                    // Kembalikan stok barang karena transaksinya batal!
                    $detail_pesanan = $pesanan->detail; 
                    foreach($detail_pesanan as $detail) {
                        RiwayatStok::create([
                            'ID_PRODUK'       => $detail->ID_PRODUK,
                            'ID_USER'         => $pesanan->ID_USER,
                            'TIPE_PERGERAKAN' => 'Masuk', // Stok masuk lagi
                            'JUMLAH'          => $detail->JUMLAH,
                            'TANGGAL'         => now(),
                            'KETERANGAN'      => 'Pembayaran Batal - Order ID: ' . $id_pesanan_asli
                        ]);
                    }
                } else if ($transaction_status == 'pending') {
                    // JIKA BELUM BAYAR (Menunggu)
                    $pesanan->update(['STATUS_PESANAN' => 'Menunggu Pembayaran']);
                }
            }
        }
        
        // Wajib mengembalikan response 200 OK ke Midtrans
        return response()->json(['message' => 'Callback diterima']);
    }
}