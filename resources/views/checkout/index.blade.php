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
    <form action="{{ route('checkout.proses') }}" method="POST">
        @csrf
        <div class="row g-5">
            
            <div class="col-lg-7">
                <div class="checkout-card">
                    <h3 class="mb-4">Detail Pengiriman</h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Depan</label>
                            <input type="text" name="nama_depan" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Belakang</label>
                            <input type="text" name="nama_belakang" class="form-control">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="COD">COD</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Catatan Pesanan</label>
                        <textarea name="catatan_pesanan" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-card">
                    <h3 class="mb-4">Ringkasan Pesanan</h3>
                    
                    @php
                        $total = 0;
                        $ongkir = 15000;
                    @endphp
                    
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $item)
                            @php
                                $total += $item['harga'] * $item['jumlah'];
                            @endphp
                            <div class="checkout-item mb-3">
                                <img src="{{ asset('storage/' . $item['gambar']) }}"
                                     width="70" height="70"
                                     style="object-fit:cover; border-radius:10px;">
                                <div>
                                    <h6 class="mb-1">{{ $item['nama_produk'] }}</h6>
                                    <small>
                                        {{ $item['jumlah'] }} x Rp {{ number_format($item['harga'],0,',','.') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($total,0,',','.') }}</strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <strong>Rp {{ number_format($ongkir,0,',','.') }}</strong>
                    </div>
                    <hr>
                    
                    <div class="d-flex justify-content-between fs-5">
                        <strong>Total Keseluruhan</strong>
                        <strong class="text-primary">
                            Rp {{ number_format($total + $ongkir, 0, ',', '.') }}
                        </strong>
                    </div>
                    
                    <div class="mt-4">
                        <label>Kode Voucher</label>
                        <div class="input-group">
                            <input type="text" name="kode_voucher" class="form-control" placeholder="Masukkan Voucher">
                            <button type="button" class="btn btn-warning">Terapkan</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-checkout w-100 mt-4">
                        Lanjut ke Pembayaran
                    </button>
                    
                </div>
            </div>
            
        </div>
    </form>
</div>
@endsection