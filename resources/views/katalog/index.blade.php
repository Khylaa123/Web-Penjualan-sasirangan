@extends('layouts.front')

@section('title', 'Katalog Produk')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Katalog Produk</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item active text-white">Katalog</li>
    </ol>
</div>

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            
            <div class="col-lg-3">
                <div class="mb-4">
                    <form action="{{ route('katalog.index') }}" method="GET">
                        <div class="input-group w-100">
                            <input type="text" name="search" class="form-control p-3" placeholder="Cari produk..." value="{{ request('search') }}">
                            <button type="submit" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="mb-4">
                    <h4>Kategori</h4>
                    <ul class="list-unstyled fruite-categorie">
                        <li>
                            <div class="d-flex justify-content-between fruite-name">
                                <a href="{{ route('katalog.index') }}">
                                    <i class="fas fa-tags me-2"></i>Semua Produk
                                </a>
                            </div>
                        </li>
                        @foreach($kategori as $kat)
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

                <div class="mt-5">
                    <h4 class="fw-bold mb-4">Produk Unggulan</h4>
                    @foreach($featured as $f)
                    <div class="d-flex mb-3 align-items-center">
                        <img src="{{ asset('storage/'.$f->FOTO_PRODUK) }}" width="70" height="70" class="rounded" style="object-fit: cover;">
                        <div class="ms-3">
                            <h6 class="mb-1"><a href="{{ route('katalog.show', $f->ID_PRODUK) }}" class="text-dark">{{ $f->NAMA_PRODUK }}</a></h6>
                            <small class="fw-bold text-primary">Rp {{ number_format($f->HARGA,0,',','.') }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4 justify-content-center">
                    @forelse($produk as $p)
                    <div class="col-md-6 col-lg-4">
                        <div class="rounded position-relative fruite-item h-100 d-flex flex-column border border-secondary shadow-sm">
                            <div class="fruite-img">
                                <img src="{{ asset('storage/' . $p->FOTO_PRODUK) }}" class="img-fluid w-100 rounded-top" alt="{{ $p->NAMA_PRODUK }}" style="height: 250px; object-fit: cover;">
                            </div>
                            
                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                                {{ $p->kategori->NAMA_KATEGORI ?? 'Umum' }}
                            </div>

                            <div class="p-4 rounded-bottom flex-grow-1 d-flex flex-column">
                                <h5 class="mb-3"><a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="text-dark">{{ $p->NAMA_PRODUK }}</a></h5>
                                
                                <div class="d-flex justify-content-between flex-lg-wrap mt-auto pt-2">
                                    <div class="w-100 mb-3 text-center">
                                        <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($p->HARGA,0,',','.') }}</p>
                                    </div>
                                    
                                    <a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="btn border border-secondary rounded-pill px-3 py-2 w-100 text-primary">
                                        <i class="fa fa-eye me-2"></i> Detail Produk
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <h5 class="text-muted">Produk yang Anda cari tidak ditemukan.</h5>
                    </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $produk->links('pagination::bootstrap-5') }}
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection