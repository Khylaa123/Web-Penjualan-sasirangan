<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// INI YANG DIGANTI YA BOSS
Route::get('/', [FrontController::class, 'index'])->name('home');

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
    Route::post('/pesanan/{id}/update', [PesananController::class, 'updateStatus'])->name('pesanan.update');

    // Rute Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    // ==========================================
    // AREA KHUSUS ADMIN (Dilindungi Middleware)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');
    });
});

require __DIR__.'/auth.php';