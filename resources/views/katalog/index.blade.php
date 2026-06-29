@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5 katalog-banner">
    <h1 class="text-center text-white display-4 fw-bold">
        katalog Sasirangan
</h1>
</div>
<div class="container-fluid page-header py-5" 
     style="background: linear-gradient(rgb(252, 251, 251), rgb(134, 134, 134)), 
     url('{{ asset('img/bg-sasirangan.jpg') }}');
     background-size: cover;
     background-position: center;">
    <div class="container py-5">
        <h1 class="mb-4">Koleksi Produk Sasirangan Mellisari</h1>
        <p class="text-muted mb-5">
           Temukan berbagai motif kain sasirangan khas Kalimantan Selatan
           dengan kualitas terbaik.
        </p>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">                  
                    <div class="col-xl-3">
                        <form action="{{ route('katalog.index') }}" method="GET">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" name="search" class="form-control p-3" placeholder="Cari motif/produk..." value="{{ request('search') }}">
                                <button type="submit" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6"></div>
                    <div class="col-xl-3">
                        <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                            <label for="sort">Urutkan:</label>
                            <form action="{{ route('katalog.index') }}" method="GET" id="form-sort">
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                                @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                                <select id="sort" name="sort" class="border-0 form-select-sm bg-light me-3" onchange="document.getElementById('form-sort').submit();">
                                    <option value="">Default</option>
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Kategori</h4>
                                    <ul class="list-unstyled fruite-categorie">
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('katalog.index') }}"><i class="fas fa-tags me-2"></i>Semua Kategori</a>
                                            </div>
                                        </li>
                                        @foreach($kategori as $kat)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{ route('katalog.index', ['kategori' => $kat->ID_KATEGORI]) }}" class="{{ request('kategori') == $kat->ID_KATEGORI ? 'text-primary fw-bold' : '' }}">
                                                    <i class="fas fa-tags me-2"></i>{{ $kat->NAMA_KATEGORI }}
                                                </a>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-3">Filter Harga</h4>
                                    <div class="card shadow-sm border-0">
                                    <div class="card-body text-center">
                                        <img src="{{ asset('front/img/sasirangankuning.png') }}"
                                             class="img-fluid rounded"
                                             style="height:180px;
                                                    width:100%;
                                                    object-fit:cover;">
                                        <h6>Sasirangan Premium</h6>
                                        <a href="{{ route('katalog.index') }}"
                                        class="btn btn-primary rounded-pill mt-2">
                                            Lihat Produk
                                        </a>
                                    </div>
                                </div>
                                    <h4 class="mb-3">Produk Unggulan</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                            <div class="border rounded shadow-sm p-3 bg-white">
                            <h5 class="fw-bold mb-3">Produk Pilihan</h5>
                            @foreach($featured as $feat)
                            <div class="d-flex align-items-center mb-3">
                            <div class="rounded me-3"
                                 style="width:90px;height:90px;overflow:hidden;">
                            <img src="{{ asset('storage/' . $feat->FOTO_PRODUK) }}"
                                 class="w-100 h-100"
                                 style="object-fit:cover;">
                            </div>
                            <div>
                            <h6 class="mb-1 fw-bold text-dark">
                                {{ Str::limit($feat->NAMA_PRODUK, 18) }}
                            </h6>
                                <p class="fw-bold text-warning mb-0">
                                    Rp {{ number_format($feat->HARGA,0,',','.') }}
                                    </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                       @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4 katalog-grid">

@foreach($produk as $p)

<div class="col-md-6 col-xl-4">

            <div class="card katalog-card border-0 h-100">

                <img src="{{ asset('storage/'.$p->FOTO_PRODUK) }}"
     class="card-img-top katalog-img"
     alt="{{ $p->NAMA_PRODUK }}">

                <div class="card-body">

                    <span class="badge bg-secondary mb-2">
                        {{ $p->kategori->NAMA_KATEGORI ?? 'Sasirangan' }}
                    </span>

                    <h5>{{ $p->NAMA_PRODUK }}</h5>

                    <p class="text-muted">
                        {{ Str::limit($p->DESKRIPSI, 60) }}
                    </p>

                    <h5 class="fw-bold">
                        Rp {{ number_format($p->HARGA,0,',','.') }}
                    </h5>

                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between">

                    <a href="{{ route('katalog.show',$p->ID_PRODUK) }}"
                       class="btn btn-outline-secondary">
                        Detail
                    </a>

                    <form action="{{ route('keranjang.add',$p->ID_PRODUK) }}"
                          method="POST">
                        @csrf

                        <button class="btn btn-primary">
                            <i class="fa fa-shopping-bag"></i>
                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

    <div class="mt-4">
        {{ $produk->links('pagination::bootstrap-5') }}
    </div>

</div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection