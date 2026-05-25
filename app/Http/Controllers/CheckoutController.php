<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\RiwayatStok;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // 1. Menampilkan halaman form Checkout
    public function index()
    {
        if(!session('cart')) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang masih kosong!');
        }
        return view('checkout.index');
    }

    // 2. Memproses data saat tombol "Buat Pesanan" diklik
    public function proses(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->route('katalog.index');
        }

        $totalAkhir = 0;
        foreach($cart as $item) {
            $totalAkhir += $item['harga'] * $item['jumlah'];
        }

        // 1. Simpan ke tabel pesanan
        $pesanan = Pesanan::create([
            'ID_USER'           => Auth::id(),
            'TANGGAL_PESANAN'   => now(),
            'SUBTOTAL_PRODUK'   => $totalAkhir,
            'TOTAL_AKHIR'       => $totalAkhir,
            'STATUS_PESANAN'    => 'Pending'
        ]);

        // 2. Simpan detail pesanan & potong stok
        foreach($cart as $id_produk => $item) {
            DetailPesanan::create([
                'ID_PESANAN'   => $pesanan->ID_PESANAN,
                'ID_PRODUK'    => $id_produk,
                'JUMLAH'       => $item['jumlah'],
                'HARGA_SATUAN' => $item['harga'],
                'SUBTOTAL'     => $item['harga'] * $item['jumlah']
            ]);

            RiwayatStok::create([
                'ID_PRODUK'       => $id_produk,
                'ID_USER'         => Auth::id(),
                'TIPE_PERGERAKAN' => 'Keluar',
                'JUMLAH'          => $item['jumlah'],
                'TANGGAL'         => now(),
                'KETERANGAN'      => 'Terjual - Order ID: ' . $pesanan->ID_PESANAN
            ]);
        }

        // 3. KONFIGURASI MIDTRANS
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // 4. BUAT PARAMETER TRANSAKSI UNTUK MIDTRANS
        $params = array(
            'transaction_details' => array(
                'order_id' => $pesanan->ID_PESANAN . '-' . time(), // Order ID harus unik
                'gross_amount' => $totalAkhir,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        // Dapatkan Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Kosongkan keranjang
        session()->forget('cart');

        // Lempar Token ini ke halaman detail pesanan
        return redirect()->route('pesanan.show', $pesanan->ID_PESANAN)
                         ->with('snapToken', $snapToken)
                         ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}