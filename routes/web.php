<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Midtrans\Snap;

// Controllers
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
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
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\KatalogController;

Route::get('/', [FrontController::class, 'index'])->name('home');

Route::post('/midtrans-callback', [CallbackController::class, 'midtransCallback']);
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [FrontController::class, 'show'])->name('katalog.show');

Route::post('/keranjang/add/{id}', [KeranjangController::class, 'add'])->name('keranjang.add');

// Route untuk pengelolaan voucher di sisi Admin/Pegawai
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('voucher', VoucherController::class);
});

// Route Checkout & Profil (Semua User Login)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('checkout.proses');
    Route::post('/checkout/voucher', [CheckoutController::class, 'cekVoucher'])->name('checkout.voucher');
    Route::get('/checkout/voucher/hapus', [CheckoutController::class, 'hapusVoucher'])->name('checkout.voucher.hapus');
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profil.index');
});

// Area Khusus Admin & Pegawai
Route::middleware(['auth', 'verified', 'role:Admin,Pegawai'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profil-pelanggan', function () {
        return view('front.profile');
    })->name('profil-pelanggan');

    /*
    |--------------------------
    | DASHBOARD
    |--------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('kategori', KategoriController::class)->except(['destroy']);
    Route::resource('produk', ProdukController::class)->except(['destroy']);
    Route::resource('riwayat-stok', RiwayatStokController::class)->except(['edit', 'update', 'destroy', 'show']);

    // Pesanan & Laporan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id}/invoice', [PesananController::class, 'cetakInvoice'])->name('pesanan.invoice');
    Route::post('/pesanan/{id}/update', [PesananController::class, 'updateStatus'])->name('pesanan.update');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    
    // Area Spesifik Admin Saja
    Route::middleware(['role:Admin'])->group(function () {
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');
        Route::post('/pengguna', [UserController::class, 'store'])->name('users.store');
        Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});

// Area Khusus Pembeli (Pelanggan)
Route::middleware(['auth', 'role:Pembeli'])->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/remove/{id}', [KeranjangController::class, 'remove'])->name('keranjang.remove');
    
    Route::get('/riwayat-pesanan', [FrontController::class, 'riwayatPesanan'])->name('riwayat.pesanan');
    Route::get('/riwayat-pesanan/{id}', [FrontController::class, 'detailPesanan'])->name('riwayat.detail');
    Route::get('/pesanan/{id}/invoice', [PesananController::class, 'cetakInvoice'])->name('pesanan.invoice');
    
    // PERBAIKAN: Route Ulasan dipindah ke sini agar Pembeli memiliki hak akses (TIDAK 403 LAGI)
    Route::post('/ulasan/simpan', [UlasanController::class, 'store'])->name('ulasan.store');
});

require __DIR__.'/auth.php';