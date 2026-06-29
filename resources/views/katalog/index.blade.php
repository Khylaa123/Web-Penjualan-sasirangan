@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5 katalog-banner">
    <h1 class="text-center text-white display-4 fw-bold">Katalog Sasirangan</h1>
</div>

<div class="container-fluid py-5" style="background: #f8f9fa;">
    <div class="container py-5">
        <h1 class="mb-4">Koleksi Produk Sasirangan Mellisari</h1>
        <p class="text-muted mb-5">
           Temukan berbagai motif kain sasirangan khas Kalimantan Selatan dengan kualitas terbaik.
        </p>

        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <form action="{{ route('katalog.index') }}" method="GET">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control p-3" placeholder="Kata kunci..." value="{{ request('search') }}">
                        <button type="submit" class="input-group-text bg-light p-3"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-4 d-none d-lg-block"></div> <div class="col-lg-4 col-md-6">
                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between align-items-center">
                    <label for="sort" class="text-muted mb-0">Pengurutan Default:</label>
                    <form action="{{ route('katalog.index') }}" method="GET" id="form-sort" class="m-0">
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                        <select id="sort" name="sort" class="border-0 form-select-sm bg-light me-3 fw-bold" onchange="document.getElementById('form-sort').submit();">
                            <option value="">Tidak ada</option>
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
                        <div class="mb-4">
                            <h4 class="mb-4">Kategori</h4>
                            <ul class="list-unstyled fruite-categorie">
                                <li>
                                    <div class="d-flex justify-content-between fruite-name mb-2">
                                        <a href="{{ route('katalog.index') }}" class="text-decoration-none text-muted">
                                            <i class="fas fa-tags me-2 text-primary"></i>Semua Kategori
                                        </a>
                                    </div>
                                </li>
                                @foreach($kategori as $kat)
                                <li>
                                    <div class="d-flex justify-content-between fruite-name mb-2">
                                        <a href="{{ route('katalog.index', ['kategori' => $kat->ID_KATEGORI]) }}" 
                                           class="text-decoration-none {{ request('kategori') == $kat->ID_KATEGORI ? 'text-primary fw-bold' : 'text-muted' }}">
                                            <i class="fas fa-tags me-2 text-primary"></i>{{ $kat->NAMA_KATEGORI }}
                                        </a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <h4 class="mb-4">Produk Pilihan</h4>
                        @foreach($featured as $feat)
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded me-3" style="width:90px; height:90px; overflow:hidden;">
                                <img src="{{ asset('storage/' . $feat->FOTO_PRODUK) }}" class="w-100 h-100" style="object-fit:cover;" alt="Produk Pilihan">
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">{{ Str::limit($feat->NAMA_PRODUK, 18) }}</h6>
                                <p class="fw-bold mb-0" style="color: #8B5E3C;">Rp {{ number_format($feat->HARGA,0,',','.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div> <div class="col-lg-9">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row g-4 justify-content-center">
                    @foreach($produk as $p)
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="card katalog-card border-0 position-relative shadow-sm h-100">
                            
                            <div class="text-white px-3 py-1 rounded position-absolute badge-katalog" style="background: #ffb524;">
                                {{ $p->kategori->NAMA_KATEGORI ?? 'Sasirangan' }}
                            </div>

                            <div class="overflow-hidden rounded-top" style="height: 240px;">
                                <img src="{{ asset('storage/'.$p->FOTO_PRODUK) }}" class="img-fluid w-100 h-100" style="object-fit:cover;" alt="{{ $p->NAMA_PRODUK }}">
                            </div>

                            <div class="card-body text-center p-4">
                                <h5 class="fw-bold text-dark">{{ $p->NAMA_PRODUK }}</h5>
                                <p class="text-muted small mb-3">
                                    {{ Str::limit($p->DESKRIPSI, 50, '...') }}
                                </p>
                                <h5 class="fw-bold text-dark mb-4">Rp {{ number_format($p->HARGA,0,',','.') }}</h5>
                                
                                <form action="{{ route('keranjang.add', $p->ID_PRODUK) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning rounded-pill px-4 py-2 w-100 fw-bold d-flex align-items-center justify-content-center gap-2">
                                        <i class="fa fa-shopping-bag"></i> Masukkan ke Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $produk->links('pagination::bootstrap-5') }}
                </div>
            </div> </div> </div>
</div>
@endsection