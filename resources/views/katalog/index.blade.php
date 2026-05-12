@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Katalog Sasirangan</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item active text-white">Katalog</li>
    </ol>
</div>
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Koleksi Produk Kami</h1>
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
                    <div class="col-6"></div>
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
                                    <h4 class="mb-2">Filter Harga</h4>
                                    <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500000" value="0" oninput="amount.value=rangeInput.value">
                                    <output id="amount" name="amount" min-velue="0" max-value="500000" for="rangeInput">0</output>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <h4 class="mb-3">Produk Pilihan</h4>
                                @foreach($featured as $feat)
                                <div class="d-flex align-items-center justify-content-start mb-3">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="{{ asset('storage/' . $feat->FOTO_PRODUK) }}" class="img-fluid rounded" alt="{{ $feat->NAMA_PRODUK }}" style="object-fit: cover; width: 100%; height: 100%;">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">{{ $feat->NAMA_PRODUK }}</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">Rp {{ number_format($feat->HARGA, 0, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">
                            
                            {{-- Notifikasi --}}
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @forelse($produk as $p)
                            <div class="col-md-6 col-lg-6 col-xl-4">
                                <div class="rounded position-relative fruite-item h-100 d-flex flex-column">
                                    <div class="fruite-img">
                                        <img src="{{ asset('storage/' . $p->FOTO_PRODUK) }}" class="img-fluid w-100 rounded-top" alt="{{ $p->NAMA_PRODUK }}" style="height: 250px; object-fit: cover;">
                                    </div>
                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                        {{ $p->kategori->NAMA_KATEGORI ?? 'Kain' }}
                                    </div>
                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom flex-grow-1 d-flex flex-column">
                                        <h4><a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="text-dark">{{ $p->NAMA_PRODUK }}</a></h4>
                                        <p>{{ Str::limit($p->DESKRIPSI, 60) }}</p>
                                        <div class="d-flex justify-content-between flex-lg-wrap mt-auto">
                                            <p class="text-dark fs-5 fw-bold mb-0">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</p>
                                            
                                            <div class="d-flex gap-1"> {{-- Pakai gap-1 biar tombolnya mepet rapi --}}
                                                <a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-eye text-primary"></i>
                                                </a>

                                                <form action="{{ route('keranjang.add', $p->ID_PRODUK) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <i class="fa fa-shopping-bag text-primary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5">
                                <h5>Motif Sasirangan tidak ditemukan.</h5>
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
    </div>
</div>
@endsection