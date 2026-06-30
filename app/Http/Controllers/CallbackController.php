<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function midtransCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $transactionStatus = $request->transaction_status;
            $orderId = $request->order_id;

            // Cari pesanan berdasarkan Order ID
            $pesanan = Pesanan::with('detail')->where('ID_PESANAN', $orderId)->first();
            
            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            // Update atau Create Data Pembayaran
            Pembayaran::updateOrCreate(
                ['ID_PESANAN' => $orderId],
                [
                    'TRANSACTION_ID' => $request->transaction_id,
                    'PAYMENT_TYPE' => $request->payment_type,
                    'STATUS_BAYAR' => $transactionStatus,
                    // waktu_bayar bisa disesuaikan dengan $request->settlement_time jika ada
                ]
            );

            // LOGIKA PUSAT PERUBAHAN STATUS & PEMOTONGAN STOK
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                
                // Pastikan stok tidak dipotong dua kali jika status sudah Paid
                if ($pesanan->STATUS_PESANAN !== 'Paid') {
                    $pesanan->STATUS_PESANAN = 'Paid'; // Konsisten: Paid
                    $pesanan->save();

                    // PEMOTONGAN STOK TERJADI DI SINI SETELAH UANG DITERIMA
                    foreach ($pesanan->detail as $item) {
                        RiwayatStok::create([
                            'ID_PRODUK' => $item->ID_PRODUK,
                            'ID_USER' => $pesanan->ID_USER, // Menggunakan ID pembeli, karena Webhook tidak memiliki Session Auth
                            'TIPE_PERGERAKAN' => 'keluar',
                            'JUMLAH' => $item->JUMLAH,
                            'KETERANGAN' => 'Terjual (Paid) - Order ID: ' . $orderId,
                            'TANGGAL' => now()
                        ]);
                    }
                }

            } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $pesanan->STATUS_PESANAN = 'Cancelled';
                $pesanan->save();
                
            } elseif ($transactionStatus == 'pending') {
                $pesanan->STATUS_PESANAN = 'Pending';
                $pesanan->save();
            }

            return response()->json(['message' => 'Callback diproses dengan sukses']);
        }

        return response()->json(['message' => 'Invalid Signature Key'], 403);
    }
}