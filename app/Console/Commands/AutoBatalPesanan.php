<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;
use App\Models\RiwayatStok;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoBatalPesanan extends Command
{
    // Ini nama perintah yang akan kita panggil nanti
    protected $signature = 'app:auto-batal-pesanan';

    // Deskripsi tugas robot ini
    protected $description = 'Membatalkan pesanan yang belum dibayar lebih dari 24 jam dan mengembalikan stok';

    public function handle()
    {
        // 1. Cari pesanan yang statusnya 'Menunggu Pembayaran' 
        // dan tanggal pesannya sudah lewat dari 24 jam yang lalu
        $batasWaktu = Carbon::now()->subHours(24);
        
        $pesananKadaluarsa = Pesanan::with('detail')
            ->where('STATUS_PESANAN', 'Menunggu Pembayaran')
            ->where('TANGGAL_PESAN', '<=', $batasWaktu)
            ->get();

        $jumlahBatal = 0;

        // 2. Looping setiap pesanan yang nyangkut
        foreach ($pesananKadaluarsa as $pesanan) {
            
            // Ubah statusnya jadi Dibatalkan
            $pesanan->update([
                'STATUS_PESANAN' => 'Dibatalkan'
            ]);

            // 3. Kembalikan stoknya! (Looping detail pesanan)
            foreach ($pesanan->detail as $detail) {
                RiwayatStok::create([
                    'ID_PRODUK'       => $detail->ID_PRODUK,
                    'ID_USER'         => $pesanan->ID_USER, // User yang dulu memesan
                    'TIPE_PERGERAKAN' => 'Masuk', // Stok masuk lagi ke gudang
                    'JUMLAH'          => $detail->JUMLAH,
                    'TANGGAL'         => now(),
                    'KETERANGAN'      => 'Batal Otomatis (Expired > 24 Jam) - Order ID: ' . $pesanan->ID_PESANAN
                ]);
            }
            
            $jumlahBatal++;
        }

        // Catat di log server sebagai bukti robotnya bekerja
        if ($jumlahBatal > 0) {
            Log::info("Cron Job Berjalan: $jumlahBatal pesanan expired berhasil dibatalkan otomatis.");
            $this->info("$jumlahBatal pesanan berhasil dibatalkan.");
        } else {
            $this->info("Aman. Tidak ada pesanan yang kadaluarsa hari ini.");
        }
    }
}