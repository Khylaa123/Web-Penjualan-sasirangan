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
use App\Http\Controllers\InventoryExportController;

Route::get('/inventory/export/pdf', [InventoryExportController::class, 'export'])->name('inventory.pdf');

Route::get('/', [FrontController::class, 'index'])->name('home');

Route::post('/midtrans-callback', [CallbackController::class, 'midtransCallback']);

Route::get('/katalog', [FrontController::class, 'katalog'])->name('katalog.index');
Route::get('/katalog/{id}', [FrontController::class, 'show'])->name('katalog.show');

Route::post('/keranjang/add/{id}', [KeranjangController::class, 'add'])->name('keranjang.add');

/*
|--------------------------------------------------------------------------
| CHECKOUT (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [CheckoutController::class, 'proses'])->name('checkout.proses');
    Route::post('/checkout/voucher', [CheckoutController::class, 'cekVoucher'])->name('checkout.voucher');
    Route::get('/checkout/voucher/hapus', [CheckoutController::class, 'hapusVoucher'])->name('checkout.voucher.hapus');
});

/*
|--------------------------------------------------------------------------
| AUTH + VERIFIED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
     Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
     Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    /*
    |--------------------------
    | PROFILE
    |--------------------------
    */
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

    /*
    |--------------------------
    | MASTER DATA
    |--------------------------
    */
    Route::resource('kategori', KategoriController::class)->except(['destroy']);

    Route::resource('produk', ProdukController::class)->only([
        'index', 'create', 'store'
    ]);

    Route::resource('riwayat-stok', RiwayatStokController::class)
        ->except(['edit', 'update', 'destroy', 'show']);

    /*
    |--------------------------
    | INVENTORY (FIXED - NO DUPLICATE)
    |--------------------------
    */
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('inventory.index');

    /*
    |--------------------------
    | PESANAN
    |--------------------------
    */
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{id}/invoice', [PesananController::class, 'cetakInvoice'])->name('pesanan.invoice');
    Route::post('/pesanan/{id}/update', [PesananController::class, 'updateStatus'])->name('pesanan.update');

    /*
    |--------------------------
    | RIWAYAT PESANAN
    |--------------------------
    */
    Route::get('/riwayat-pesanan', [FrontController::class, 'riwayatPesanan'])->name('riwayat.pesanan');
    Route::get('/riwayat-pesanan/{id}', [FrontController::class, 'detailPesanan'])->name('riwayat.detail');

    /*
    |--------------------------
    | KERANJANG / LAPORAN / ULASAN
    |--------------------------
    */
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/remove/{id}', [KeranjangController::class, 'remove'])->name('keranjang.remove');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

    Route::post('/ulasan/simpan', [UlasanController::class, 'store'])->name('ulasan.store');

    /*
    |--------------------------
    | ADMIN AREA
    |--------------------------
    */
    Route::middleware(['role:Admin'])->group(function () {

        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])
            ->name('kategori.destroy');

        Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])
            ->name('produk.destroy');

        Route::get('/kelola-akun', [UserController::class, 'index'])->name('users.index');
        Route::post('/kelola-akun/simpan', [UserController::class, 'store'])->name('users.store');
        Route::post('/kelola-akun/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/kelola-akun/{id}/hapus', [UserController::class, 'destroy'])->name('users.destroy');
    });

});

/*
|--------------------------------------------------------------------------
| MIDTRANS TEST
|--------------------------------------------------------------------------
*/
Route::get('/test-snap', function () {

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    $params = [
        'transaction_details' => [
            'order_id' => 'ORD-' . time(),
            'gross_amount' => 170000
        ],
        'customer_details' => [
            'first_name' => 'User Test',
            'email' => 'test@gmail.com'
        ],
    ];

    return response()->json([
        'snap_token' => Snap::getSnapToken($params)
    ]);
});

require __DIR__.'/auth.php';