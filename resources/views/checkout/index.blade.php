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
<div class="container py-5">
    <div class="row g-5">
        <!-- FORM PELANGGAN -->
        <div class="col-lg-7">
            <div class="checkout-card">
                <h3 class="mb-4">
                    Detail Pengiriman
                </h3>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Depan</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Belakang</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Alamat Lengkap</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select class="form-control">
                        <option>Transfer Bank</option>
                        <option>COD</option>
                        <option>E-Wallet</option>
                    </select>
                </div>
                    <div class="mb-3">
                        <label>Catatan Pesanan</label>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>
                </form>
            </div>
        </div>
        <!-- RINGKASAN PESANAN -->
        <div class="col-lg-5">
            <div class="checkout-card">
                <h3 class="mb-4">
                    Ringkasan Pesanan
                </h3>
                @php
                $total = 0;
                @endphp
                @if(session('cart'))
                    @foreach(session('cart') as $id => $item)
                        @php
                            $total += $item['harga'] * $item['jumlah'];
                        @endphp
                        <div class="checkout-item mb-3">
                            <img src="{{ asset('storage/' . $item['gambar']) }}"
                                width="70"
                                height="70"
                                style="object-fit:cover; border-radius:10px;">
                            <div>
                                <h6 class="mb-1">
                                    {{ $item['nama_produk'] }}
                                </h6>
                                <small>
                                    {{ $item['jumlah'] }} x
                                    Rp {{ number_format($item['harga'],0,',','.') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @endif
                <hr>
                <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <strong>
                    Rp {{ number_format($total,0,',','.') }}
                </strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Ongkir</span>
                    <strong>Rp15.000</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5">
                <strong>Total</strong>
                <strong class="text-primary">
                    Rp {{ number_format($total,0,',','.') }}
                </strong>
                </div>
                <div class="mt-4">
                    <label>Kode Voucher</label>
                    <div class="input-group">
                        <input type="text"
                               class="form-control"
                               placeholder="Masukkan Voucher">
                        <button class="btn btn-warning">
                            Terapkan
                        </button>
                    </div>
                </div>
                <form action="#" method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-checkout w-100 mt-4">
                    Lanjut ke Pembayaran
                </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection