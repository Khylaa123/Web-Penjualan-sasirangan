@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Detail Produk</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('katalog.index') }}">Katalog</a></li>
        <li class="breadcrumb-item active text-white">{{ $produk->NAMA_PRODUK }}</li>
    </ol>
</div>
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-lg-8 col-xl-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="border rounded">
                            <a href="#">
                                <img src="{{ asset('storage/' . $produk->FOTO_PRODUK) }}" class="img-fluid rounded" alt="{{ $produk->NAMA_PRODUK }}" style="width: 100%; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">{{ $produk->NAMA_PRODUK }}</h4>
                        <p class="mb-3">Kategori: {{ $produk->kategori->NAMA_KATEGORI ?? 'Umum' }}</p>
                        <h5 class="fw-bold mb-3">Rp {{ number_format($produk->HARGA, 0, ',', '.') }}</h5>
                        <div class="d-flex mb-4">
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p class="mb-4">{{ $produk->DESKRIPSI }}</p>
                        <p class="mb-4">Berat: {{ $produk->BERAT_GRAM }} Gram</p>

                        <form action="{{ route('keranjang.add', $produk->ID_PRODUK) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Masukkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-xl-3">
                <div class="row g-4 fruite">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <h4>Kategori Lainnya</h4>
                            <ul class="list-unstyled fruite-categorie">
                                @foreach($kategori_sidebar as $kat)
                                <li>
                                    <div class="d-flex justify-content-between fruite-name">
                                        <a href="{{ route('katalog.index', ['kategori' => $kat->ID_KATEGORI]) }}">
                                            <i class="fas fa-tags me-2"></i>{{ $kat->NAMA_KATEGORI }}
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="fw-bold mb-0">Produk Terkait</h1>
        <div class="vesitable">
            <div class="row g-4 mt-2">
                @foreach($produk_terkait as $pt)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="rounded position-relative fruite-item h-100 d-flex flex-column">
                        <div class="fruite-img">
                            <img src="{{ asset('storage/' . $pt->FOTO_PRODUK) }}" class="img-fluid w-100 rounded-top" alt="{{ $pt->NAMA_PRODUK }}" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">{{ $pt->kategori->NAMA_KATEGORI ?? 'Kain' }}</div>
                        <div class="p-4 border border-secondary border-top-0 rounded-bottom flex-grow-1 d-flex flex-column">
                            <h4><a href="{{ route('katalog.show', $pt->ID_PRODUK) }}" class="text-dark">{{ $pt->NAMA_PRODUK }}</a></h4>
                            <div class="d-flex justify-content-between flex-lg-wrap mt-auto pt-3">
                                <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($pt->HARGA, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection