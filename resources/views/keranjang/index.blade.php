@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Keranjang Belanja</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item active text-white">Keranjang</li>
    </ol>
</div>
<div class="container-fluid py-5">
    <div class="container py-5">
        
        {{-- Alert Notifikasi Jika Ada Pesan Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @php $totalKeseluruhan = 0; @endphp
                    
                    {{-- Looping Data dari Session Keranjang --}}
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $totalKeseluruhan += $details['harga'] * $details['jumlah']; @endphp
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $details['gambar']) }}" class="cart-product-img" alt="{{ $details['nama_produk'] }}">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $details['nama_produk'] }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">Rp {{ number_format($details['harga'], 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <input type="text" class="form-control form-control-sm text-center border-0" value="{{ $details['jumlah'] }}" readonly>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}</p>
                                </td>
                                <td>
                                    <form action="{{ route('keranjang.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-circle cart-delete-btn" onclick="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center py-5">
                            <i class="fa fa-shopping-cart fa-4x text-secondary mb-3"></i>
                            <h4>Keranjang Belanja Kosong</h4>
                            <p class="text-muted">
                                Belum ada produk yang ditambahkan.
                            </p>
                            <a href="{{ url('/') }}"
                            class="btn btn-primary rounded-pill px-4">
                                Mulai Belanja
                            </a>
                        </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        @if(session('cart'))
        <div class="row g-4 justify-content-end mt-5">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded cart-total-card">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Total <span class="fw-normal">Belanja</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Pengiriman:</h5>
                            <div class="">
                                <p class="mb-0">Dihitung saat Checkout</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('checkout.index') }}"
                    class="btn btn-primary w-100 rounded-pill py-3 fw-bold">
                        Lanjut Checkout
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection