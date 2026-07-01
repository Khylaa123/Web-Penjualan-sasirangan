<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\RiwayatStok;
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

        // 1. Ambil data pengiriman
        $metode = MetodePengiriman::first();
        if (!$metode) {
            return redirect()->back()->with('error', 'Data pengiriman belum diatur di database.');
        }

        // 2. Hitung Total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }
        
        $potongan = session()->has('voucher') ? session('voucher')['potongan'] : 0;
        $totalAkhir = max($subtotal - $potongan, 0);

        // 3. Proses Transaksi Database
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::create([
                'ID_PESANAN'       => 'INV-' . time(),
                'ID_USER'          => Auth::id(),
                'ID_PENGIRIMAN'    => $metode->ID_PENGIRIMAN,
                'TANGGAL_PESAN'    => now(),
                'TOTAL_BERAT_GRAM' => 1000,
                'SUBTOTAL_PRODUK'  => $subtotal,
                'BIAYA_PENGIRIMAN' => 15000,
                'TOTAL_AKHIR'      => $totalAkhir,
                'STATUS_PESANAN'   => 'Menunggu Pembayaran',
                'RESI_PENGIRIMAN'  => null
            ]);

            foreach ($cart as $id_produk => $item) {
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
                    'KETERANGAN'      => 'Order ID: ' . $pesanan->ID_PESANAN
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }

        // 4. Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $pesanan->ID_PESANAN, 
                'gross_amount' => $totalAkhir
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name, 
                'email' => Auth::user()->email
            ]
        ]);

        session()->forget(['cart', 'voucher']);
        
        return redirect()->route('pesanan.show', $pesanan->ID_PESANAN)
            ->with('snapToken', $snapToken);
    }
}