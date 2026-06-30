@extends('layouts.front')

@section('content')
<!-- Page Header -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Keranjang Belanja</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item active text-white">Keranjang</li>
    </ol>
</div>

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
        <div class="table-responsive">
            <table class="table text-center align-middle" style="border-collapse: separate; border-spacing: 0 15px;">
                <thead class="bg-light" style="border-radius: 10px;">
                    <tr>
                        <th class="py-3 border-0 rounded-start">Gambar</th>
                        <th class="py-3 border-0 text-start">Nama Produk</th>
                        <th class="py-3 border-0">Harga</th>
                        <th class="py-3 border-0">Satuan</th> <!-- Judul diubah -->
                        <th class="py-3 border-0">Total</th>
                        <th class="py-3 border-0 rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $total += $details['harga'] * $details['jumlah']; @endphp
                        <tr class="shadow-sm bg-white">
                            <td class="p-3 border-0 rounded-start">
                                <img src="{{ asset('storage/'.$details['gambar']) }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="Produk">
                            </td>
                            <td class="p-3 border-0 text-start">
                                <span class="fw-bold text-dark d-block" style="font-size: 1.1rem;">{{ $details['nama_produk'] ?? $details['name'] }}</span>
                            </td>
                            <td class="p-3 border-0">
                                Rp {{ number_format($details['harga'], 0, ',', '.') }}
                            </td>
                            
                            <!-- KOLOM SATUAN (Jumlah + Meter) -->
                            <td class="p-3 border-0">
                                <div class="fw-bold fs-5 text-dark">
                                    {{ $details['jumlah'] }} <span class="text-muted small">Meter</span>
                                </div>
                            </td>

                            <td class="p-3 border-0 text-primary fw-bold">
                                Rp {{ number_format($details['harga'] * $details['jumlah'], 0, ',', '.') }}
                            </td>
                            <td class="p-3 border-0 rounded-end">
                                <form action="{{ route('keranjang.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 40px; height: 40px;" onclick="return confirm('Hapus produk ini?');">
                                        <i class="fa fa-times text-white"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Belanja & Checkout -->
        <div class="row g-4 justify-content-end mt-4">
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded p-4 shadow-sm border">
                    <h3 class="fw-bold mb-4 text-dark">Total Belanja</h3>
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="fw-normal text-muted">Subtotal:</h6>
                        <p class="mb-0 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    <div class="d-flex justify-content-between mb-4 border-bottom pb-3">
                        <h6 class="fw-normal text-muted">Pengiriman:</h6>
                        <p class="mb-0 text-muted small">Dihitung saat Checkout</p>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold text-dark">Total</h5>
                        <h5 class="fw-bold text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-secondary rounded-pill w-100 py-3 text-white fw-bold fs-5" style="background-color: #8C8C8C; border: none;">Lanjut Checkout</a>
                </div>
            </div>
        </div>
        
        @else
        <div class="text-center py-5">
            <i class="fa fa-shopping-cart text-muted mb-4" style="font-size: 80px; opacity: 0.5;"></i>
            <h4 class="text-muted fw-bold mb-3">Keranjang belanja Anda masih kosong</h4>
            <a href="{{ route('katalog.index') }}" class="btn btn-primary rounded-pill px-5 py-3 text-white fw-bold">Jelajahi Katalog</a>
        </div>
        @endif
        
    </div>
</div>
@endsection