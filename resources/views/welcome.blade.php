@extends('layouts.front')

@section('title', 'Beranda')

@section('content')
<div class="container-fluid py-5 mb-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3 text-secondary">100% Produk Lokal</h4>
                <h1 class="mb-5 display-3 text-primary">Kain Sasirangan Khas Kalimantan</h1>
                <div class="position-relative mx-auto">
                    <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Cari Kain...">
                    <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Cari Sekarang</button>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active rounded">
                            <img src="{{ asset('front/img/hero-img-1.png') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                            <a href="#" class="btn px-4 py-2 text-white rounded">Sasirangan Sutra</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <h1>Katalog Produk</h1>
                </div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">
                        <li class="nav-item">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                <span class="text-dark" style="width: 130px;">Semua Produk</span>
                            </a>
                        </li>
                        @foreach($kategori as $k)
                        <li class="nav-item">
                            <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-{{ $k->ID_KATEGORI }}">
                                <span class="text-dark" style="width: 130px;">{{ $k->NAMA_KATEGORI }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="row g-4">
                                @foreach($produk as $p)
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="rounded position-relative fruite-item border border-secondary shadow-sm">
                                        <div class="fruite-img">
                                            <img src="{{ $p->FOTO_PRODUK ? asset('storage/'.$p->FOTO_PRODUK) : asset('front/img/fruite-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="{{ $p->NAMA_PRODUK }}">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $p->kategori->NAMA_KATEGORI }}</div>
                                        <div class="p-4 border-top-0 rounded-bottom">
                                            <h4>{{ $p->NAMA_PRODUK }}</h4>
                                            <p>{{ Str::limit($p->DESKRIPSI, 50) }}</p>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</p>
                                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Keranjang</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
@endsection