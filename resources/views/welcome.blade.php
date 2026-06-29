@extends('layouts.front')

@section('title', 'Beranda')

@section('content')
<div class="container-fluid py-5 hero-header">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <!-- KIRI -->
            <div class="col-md-12 col-lg-7">
                <h4 class="mb-3 text-secondary">
                    100% Produk Lokal
                </h4>
                <h1 class="mb-4 hero-title">
                    Baju, Tas & Kain Sasirangan Khas Kalimantan
                </h1>
                <form action="{{ route('katalog.index') }}" method="GET">
                    <div class="position-relative mx-auto">
                        <input
                            name="search"
                            type="text"
                            class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill"
                            placeholder="Cari Kain Sasirangan...">
                        <button
                            type="submit"
                            class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                            style="top:0; right:25%;">
                            Cari Sekarang
                        </button>
                    </div>
                </form>
            </div>
            <!-- KANAN -->
            <div class="col-md-12 col-lg-5">
                <div id="carouselId"
                     class="carousel slide carousel-fade position-relative"
                     data-bs-ride="carousel"
                     data-bs-interval="5000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('front/img/Model-Sasirangan.png') }}"
                                 class="d-block w-100 carousel-img">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('front/img/Tas.png') }}"
                                 class="d-block w-100 carousel-img">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('front/img/Sasirangan1.png') }}"
                                 class="d-block w-100 carousel-img">
                        </div>
                    </div>
                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carouselId"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#carouselId"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FITUR TOKO -->
<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="feature-box">
                <i class="fa fa-tags fa-3x"></i>
                <h5>Motif Eksklusif</h5>
                <p>Khas Kalimantan Selatan</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-box">
                <i class="fa fa-shield-alt fa-3x"></i>
                <h5>Pembayaran Aman</h5>
                <p>Transaksi Terjamin</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-box">
                <i class="fa fa-award fa-3x"></i>
                <h5>Kualitas Premium</h5>
                <p>Sasirangan Asli</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-box">
                <i class="fa fa-store fa-3x"></i>
                <h5>Produk Lokal</h5>
                <p>UMKM Kalimantan Selatan</p>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid fruite">
    <div class="container">
        <div class="tab-class text-center">
            <div class="row g-4">
                <div class="col-lg-4 text-start">
                    <div class="section-title mb-5">
                    <h2 class="section-title">
                        Koleksi Sasirangan Terbaru
                    </h2>
                    <p class="section-subtitle">
                        Temukan berbagai motif sasirangan khas Kalimantan Selatan dengan kualitas terbaik.
                    </p>
                </div>
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
                    <div class="row justify-content-center g-4">
                        <div class="col-lg-12">
                            <div class="row justify-content-center g-4">
                                @foreach($produk as $p)
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                    <div class="rounded position-relative fruite-item border border-secondary shadow-sm">
                                        <div class="fruite-img">
                                            <img src="{{ $p->FOTO_PRODUK ? asset('storage/'.$p->FOTO_PRODUK) : asset('front/img/fruite-item-5.png') }}" class="img-fluid w-100 rounded-top" alt="{{ $p->NAMA_PRODUK }}">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">{{ $p->kategori->NAMA_KATEGORI }}</div>
                                        <div class="p-4 border-top-0 rounded-bottom">
                                            <h4>{{ $p->NAMA_PRODUK }}</h4>
                                            <p>{{ Str::limit($p->DESKRIPSI, 50) }}</p>
                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</p>
                                                <form action="{{ route('keranjang.add',$p->ID_PRODUK) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag me-2"></i>
                                                    Beli
                                                </button>
                                            </form>
                                            <a href="{{ route('katalog.show',$p->ID_PRODUK) }}"
                                            class="btn btn-outline-dark rounded-pill px-3 mt-2 w-100">
                                                Lihat Detail
                                            </a>
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
<!-- PROMO SASIRANGAN -->
<div class="promo-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 promo-content">
                <h2>
                    Koleksi Sasirangan Premium
                </h2>
                <p>
                    Temukan berbagai motif khas Kalimantan Selatan
                    dengan kualitas terbaik dan desain modern.
                </p>
                <a href="#"
                   class="btn btn-light rounded-pill px-4">
                    Belanja Sekarang
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('front/img/Sasirangan1.png') }}"
                     class="img-fluid promo-img">
            </div>
        </div>
    </div>
</div>
<!-- STATISTIK -->
<div class="container py-5">
    <div class="row text-center">
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <p>Pelanggan</p>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card">
                <div class="stat-number">150+</div>
                <p>Produk</p>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card">
                <div class="stat-number">98%</div>
                <p>Kepuasan</p>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
            <div class="stat-card">
                <div class="stat-number">10+</div>
                <p>Tahun Pengalaman</p>
            </div>
        </div>
    </div>
</div>
<!-- TESTIMONI -->
<div class="container py-5">
    <div class="text-center mb-5">
        <h2>
            Apa Kata Pelanggan?
        </h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="testimonial-card">
                <i class="fas fa-quote-left quote-icon"></i>
                <p>
                    Produknya sangat bagus dan motifnya khas sekali.
                </p>
                <h6>
                    Siti Aminah
                </h6>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <i class="fas fa-quote-left quote-icon"></i>
                <p>
                    Pengiriman cepat dan kualitas kain luar biasa.
                </p>
                <h6>
                    Ahmad Fauzi
                </h6>
            </div>
        </div>
        <div class="col-md-4">
            <div class="testimonial-card">
                <i class="fas fa-quote-left quote-icon"></i>
                <p>
                    Sangat cocok untuk hadiah dan acara resmi.
                </p>
                <h6>
                    Nurhaliza
                </h6>
            </div>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row align-items-center g-5">
        <div class="col-lg-6 text-center">
            <img src="{{ asset('front/img/Sasirangan1.png') }}"
                 class="culture-img">
        </div>
        <div class="col-lg-6 culture-content">
            <h2 class="fw-bold mb-4">
                Warisan Budaya Kalimantan Selatan
            </h2>
            <p>
                Sasirangan merupakan kain khas Kalimantan Selatan
                yang memiliki nilai budaya tinggi dan dibuat
                dengan teknik tradisional turun-temurun.
            </p>
            <p>
                Mellisari menghadirkan berbagai pilihan motif
                sasirangan berkualitas untuk kebutuhan fashion,
                souvenir, dan koleksi budaya.
            </p>
            <a href="#"
               class="btn btn-primary rounded-pill px-4">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</div>
@endsection