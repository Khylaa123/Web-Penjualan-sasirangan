@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Checkout</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('keranjang.index') }}">Keranjang</a></li>
        <li class="breadcrumb-item active text-white">Checkout</li>
    </ol>
</div>

<div class="container-fluid py-5">
    <div class="container py-5 text-center">
        <h2>Halaman Checkout Berhasil Diakses! 🎉</h2>
        <p>Di sini nanti kita akan buat Form Pengiriman dan Form Input Voucher Promo.</p>
    </div>
</div>
@endsection