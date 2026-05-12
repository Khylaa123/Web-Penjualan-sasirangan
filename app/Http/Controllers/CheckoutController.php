<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Pengecekan: Jangan izinkan masuk checkout kalau keranjang kosong
        if(!session('cart')) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang belanja masih kosong, silakan belanja dulu!');
        }

        // Tampilkan halaman checkout
        return view('checkout.index');
    }
}