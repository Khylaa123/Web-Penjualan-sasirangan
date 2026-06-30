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
    // Menampilkan halaman checkout
    public function index()
    {
        if (!session('cart')) {
            return redirect()->route('katalog.index')
                ->with('error', 'Keranjang masih kosong!');
        }

        return view('checkout.index');
    }

    // Cek Voucher
    public function cekVoucher(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required'
        ]);

        $voucher = Voucher::where('KODE_VOUCHER', $request->kode_voucher)
            ->where('STATUS_AKTIF', 'Aktif')
            ->first();

        if ($voucher) {

            session()->put('voucher', [
                'kode' => $voucher->KODE_VOUCHER,
                'potongan' => $voucher->POTONGAN_HARGA
            ]);

            return redirect()->back()->with(
                'success',
                'Voucher berhasil digunakan! Anda mendapat potongan Rp ' .
                    number_format($voucher->POTONGAN_HARGA, 0, ',', '.')
            );
        }

        return redirect()->back()->with(
            'error',
            'Kode voucher tidak valid atau sudah tidak aktif.'
        );
    }

    // Hapus Voucher
    public function hapusVoucher()
    {
        session()->forget('voucher');

        return redirect()->back()->with(
            'success',
            'Voucher berhasil dibatalkan.'
        );
    }

    // Proses Checkout
    public function proses(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong.'
            ], 400);
        }

        // Hitung subtotal
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        // Voucher
        $potongan = 0;

        if (session()->has('voucher')) {
            $potongan = session('voucher')['potongan'];
        }

        // Total akhir
        $totalAkhir = $subtotal - $potongan;

        if ($totalAkhir < 0) {
            $totalAkhir = 0;
        }

        // ID Pesanan
        $id_pesanan_baru = 'ORD-' . Auth::id() . '-' . substr(time(), -6);

        // Simpan pesanan
        $pesanan = Pesanan::create([
            'ID_PESANAN'       => $id_pesanan_baru,
            'ID_USER'          => Auth::id(),
            'ID_PENGIRIMAN'    => $request->id_pengiriman ?? 1,
            'TOTAL_BERAT_GRAM' => 0,
            'BIAYA_PENGIRIMAN' => 0,
            'SUBTOTAL_PRODUK'  => $subtotal,
            'POTONGAN_DISKON'  => $potongan,
            'TOTAL_AKHIR'      => $totalAkhir,
            'STATUS_PESANAN'   => 'Menunggu Pembayaran'
        ]);

        // Simpan detail pesanan
        foreach ($cart as $id_produk => $item) {
            DetailPesanan::create([
                'ID_PESANAN'   => $pesanan->ID_PESANAN,
                'ID_PRODUK'    => $id_produk,
                'HARGA_SAAT_BELI' => $item['harga'],
                'JUMLAH_BELI'     => $item['jumlah'],  // <--- UBAH DI SINI
                'SUBTOTAL'     => $item['harga'] * $item['jumlah'],
            ]);
        }
        // HAPUS BAGIAN PENGURANGAN STOK DI SINI
        // Kita pindahkan logikanya ke Callback Midtrans

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $pesanan->ID_PESANAN,
                'gross_amount' => $totalAkhir,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
        ];

        // Ambil Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Kosongkan keranjang & voucher
        session()->forget('cart');
        session()->forget('voucher');

        // Return JSON ke frontend
        return response()->json([
            'success'      => true,
            'snapToken'    => $snapToken,
            'redirect_url' => route('pesanan.index')
        ]);
    }
}