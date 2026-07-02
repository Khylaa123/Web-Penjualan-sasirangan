<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

// Controllers
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryExportController; // PERBAIKAN: Import Controller Export
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [CheckoutController::class, 'prosesCheckout'])->name('checkout.proses');
    
    // Inventory (Ditambah rute PDF agar tombol Export PDF di view tidak error)
    Route::get('/inventory/pdf', [InventoryController::class, 'pdf'])->name('inventory.pdf');
    Route::resource('inventory', InventoryController::class);
});

// Area Khusus Admin & Pegawai
Route::middleware(['auth', 'role:Admin,Pegawai'])->group(function () {
    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');

    // Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');

    // PERBAIKAN: Stok & Riwayat Stok (Ubah nama rute menjadi riwayat-stok.index)
    Route::get('/riwayat-stok', [RiwayatStokController::class, 'index'])->name('riwayat-stok.index');
    Route::post('/riwayat-stok/update', [RiwayatStokController::class, 'updateStok'])->name('riwayat-stok.update');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // Manajemen Pesanan Toko (Sisi Admin)
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // Batasan Khusus Hanya Admin
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
    
    Route::get('/ulasan/create/{id_produk}', [UlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/ulasan/store', [UlasanController::class, 'store'])->name('ulasan.store');
});

require __DIR__.'/auth.php';