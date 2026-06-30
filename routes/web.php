<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CallbackController;
use App\Http\Controllers\UlasanController;
use Illuminate\Support\Facades\Route;
use Midtrans\Config;
use Midtrans\Snap;

// INI YANG DIGANTI YA BOSS
Route::get('/', [FrontController::class, 'index'])->name('home');

// Route untuk Webhook Midtrans (TANPA /api)
Route::post('/midtrans-callback', [CallbackController::class, 'midtransCallback']);

// Rute Halaman Katalog
Route::get('/katalog', [FrontController::class, 'katalog'])->name('katalog.index');

// Rute Detail Produk
Route::get('/katalog/{id}', [FrontController::class, 'show'])->name('katalog.show');

// Rute Aksi Tambah ke Keranjang
Route::post('/keranjang/add/{id}', [KeranjangController::class, 'add'])->name('keranjang.add');

// Rute Checkout (Pastikan rute ini dibungkus middleware Auth ya, supaya yang bisa checkout cuma yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('checkout.proses');
    Route::post('/checkout/voucher', [CheckoutController::class, 'cekVoucher'])->name('checkout.voucher');
    Route::get('/checkout/voucher/hapus', [CheckoutController::class, 'hapusVoucher'])->name('checkout.voucher.hapus');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Profil Bawaan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Dashboard Utama Kita
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Master Data (Kecuali Hapus)
    Route::resource('kategori', KategoriController::class)->except(['destroy']);
    Route::resource('produk', ProdukController::class)->except(['destroy']);
    Route::resource('riwayat-stok', RiwayatStokController::class)->except(['edit', 'update', 'destroy', 'show']);

    // Rute Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id}/invoice', [PesananController::class, 'cetakInvoice'])->name('pesanan.invoice');
    Route::post('/pesanan/{id}/update', [PesananController::class, 'updateStatus'])->name('pesanan.update');

    // Rute Keranjang Belanja
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/remove/{id}', [KeranjangController::class, 'remove'])->name('keranjang.remove');

    // Rute Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // Rute Ulasan Produk
    Route::post('/ulasan/simpan', [UlasanController::class, 'store'])->name('ulasan.store');

 // ==========================================
    // AREA KHUSUS ADMIN (Dilindungi Middleware)
    // ==========================================
    Route::middleware(['auth', 'cekrole:admin'])->group(function () {
        // Hak akses Hapus Master Data
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        
        // Route Manajemen Pengguna
        Route::get('/kelola-akun', [UserController::class, 'index'])->name('users.index');
        Route::post('/kelola-akun/simpan', [UserController::class, 'store'])->name('users.store');
        Route::post('/kelola-akun/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/kelola-akun/{id}/hapus', [UserController::class, 'destroy'])->name('users.destroy');
    });
    });

Route::get('/test-snap', function () {
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    $params = [
        'transaction_details' => [
            'order_id' => 'ORD-999-' . time(), 
            'gross_amount' => 170000, 
        ],
        'customer_details' => [
            'first_name' => 'KHAYLA ANNISA PUTRI',
            'email' => 'khayla@gmail.com',
        ],
    ];

    return response()->json(['snap_token' => Snap::getSnapToken($params)]);
});

require __DIR__.'/auth.php';