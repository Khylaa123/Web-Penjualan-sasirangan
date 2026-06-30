<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\RiwayatStok;
use App\Models\Voucher;
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

    // 2. Fungsi Cek Voucher
    public function cekVoucher(Request $request)
    {
        $request->validate(['kode_voucher' => 'required']);

        $voucher = Voucher::where('KODE_VOUCHER', $request->kode_voucher)
                          ->where('STATUS_AKTIF', 'Aktif')
                          ->first();

        if ($voucher) {
            // Simpan data diskon ke session sementara
            session()->put('voucher', [
                'kode' => $voucher->KODE_VOUCHER,
                'potongan' => $voucher->POTONGAN_HARGA
            ]);
            return redirect()->back()->with('success', 'Voucher berhasil digunakan! Anda mendapat potongan Rp ' . number_format($voucher->POTONGAN_HARGA, 0, ',', '.'));
        }

        return redirect()->back()->with('error', 'Kode voucher tidak valid atau sudah tidak aktif.');
    }

    // 3. Fungsi Hapus Voucher
    public function hapusVoucher()
    {
        session()->forget('voucher');
        return redirect()->back()->with('success', 'Voucher berhasil dibatalkan.');
    }

    // 4. Fungsi Proses Checkout (Modifikasi - dengan support diskon)
    public function proses(Request $request)
    {
        $cart = session()->get('cart');
        if(!$cart) return redirect()->route('katalog.index');

        $subtotal = 0;
        foreach($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        // Cek apakah ada diskon dari session
        $potongan = 0;
        if (session()->has('voucher')) {
            $potongan = session('voucher')['potongan'];
        }

        // Kalkulasi Total Akhir
        $totalAkhir = $subtotal - $potongan;
        if ($totalAkhir < 0) { $totalAkhir = 0; } // Mencegah total menjadi minus

        // Simpan ke tabel pesanan (Sekarang ada data POTONGAN_DISKON)
        $pesanan = Pesanan::create([
            'ID_USER'           => Auth::id(),
            'TANGGAL_PESANAN'   => now(),
            'SUBTOTAL_PRODUK'   => $subtotal,
            'POTONGAN_DISKON'   => $potongan, // <-- Masuk ke database
            'TOTAL_AKHIR'       => $totalAkhir,
            'STATUS_PESANAN'    => 'Menunggu Pembayaran'
        ]);

        // Simpan detail pesanan & potong stok
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

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => $pesanan->ID_PESANAN . '-' . time(),
                'gross_amount' => $totalAkhir, // Uang yang ditagih sudah dikurangi diskon!
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = Snap::getSnapToken($params);

        // KOSONGKAN KERANJANG & VOUCHER SETELAH CHECKOUT SUKSES
        session()->forget('cart');
        session()->forget('voucher');

        return redirect()->route('pesanan.show', $pesanan->ID_PESANAN)
                         ->with('snapToken', $snapToken)
                         ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}