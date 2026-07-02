<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Voucher;
use App\Models\MetodePengiriman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout
    public function index()
    {
        if (!session('cart')) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang kosong!');
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
        return redirect()->back()->with('success', 'Voucher berhasil dibatalkan.');
    }

    // Proses Checkout
    public function proses(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.'], 400);
        }

        // 1. Ambil data pengiriman secara dinamis berdasarkan input dropdown pembeli
        $id_pengiriman = $request->input('id_pengiriman');
        if (!$id_pengiriman) {
            return response()->json(['success' => false, 'message' => 'Silakan pilih metode pengiriman terlebih dahulu.'], 400);
        }

        $metode = MetodePengiriman::find($id_pengiriman);
        if (!$metode) {
            return response()->json(['success' => false, 'message' => 'Metode pengiriman tidak valid.'], 400);
        }

        // Ambil nominal biaya dari kolom BIAYA murni yang sudah kita buat di database sebelumnya
        $ongkir = $metode->BIAYA; 

        // 2. Hitung Total Belanjaan
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }
        
        $potongan = session()->has('voucher') ? session('voucher')['potongan'] : 0;
        
        // Rumus Total Akhir yang benar: (Subtotal - Diskon Voucher) + Biaya Ongkir Terpilih
        $totalAkhir = max($subtotal - $potongan, 0) + $ongkir;

        // 3. Proses Transaksi Database
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::create([
                'ID_PESANAN'       => 'INV-' . time(),
                'ID_USER'          => Auth::id(),
                'ID_PENGIRIMAN'    => $metode->ID_PENGIRIMAN, // Menyimpan ID pengiriman pilihan user
                'TANGGAL_PESAN'    => now(),
                'TOTAL_BERAT_GRAM' => 1000,
                'SUBTOTAL_PRODUK'  => $subtotal,
                'BIAYA_PENGIRIMAN' => $ongkir,      // Dinamis (0 jika ambil sendiri, 10rb jika COD, 15rb jika JNE)
                'TOTAL_AKHIR'      => $totalAkhir,   // Total akhir yang sinkron dengan ongkir baru
                'STATUS_PESANAN'   => 'Menunggu Pembayaran',
                'RESI_PENGIRIMAN'  => null
            ]);

            foreach ($cart as $id_produk => $item) {
                DetailPesanan::create([
                    'ID_PESANAN'      => $pesanan->ID_PESANAN,
                    'ID_PRODUK'       => $id_produk,
                    'HARGA_SAAT_BELI' => $item['harga'],
                    'JUMLAH_BELI'     => $item['jumlah'],
                    'SUBTOTAL'        => $item['harga'] * $item['jumlah']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal memproses pesanan: ' . $e->getMessage()], 500);
        }

        // 4. Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $pesanan->ID_PESANAN,
                    'gross_amount' => $totalAkhir
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name ?? 'Guest',
                    'email' => Auth::user()->email ?? 'guest@example.com'
                ]
            ]);

            session()->forget(['cart', 'voucher']);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $pesanan->ID_PESANAN,
                'redirect_url' => route('riwayat.detail', $pesanan->ID_PESANAN)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage()], 500);
        }
    }
}
