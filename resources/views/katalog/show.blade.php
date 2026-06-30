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
            <div class="col-lg-9">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="product-image-wrapper">
                        <img src="{{ asset('front/img/sasirangankuning.png') }}"
                        class="img-fluid rounded shadow"
                        alt="Sasirangan Kuning">
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="fw-bold mb-3">{{ $produk->NAMA_PRODUK }}</h4>
                        <p class="mb-3">Kategori: {{ $produk->kategori->NAMA_KATEGORI ?? 'Umum' }}</p>
                        @if(isset($produk->DISKON_PERSEN) && $produk->DISKON_PERSEN > 0)
                        <p class="text-muted text-decoration-line-through">
                            Rp {{ number_format($produk->HARGA,0,',','.') }}
                        </p>
                        <h5 class="text-danger fw-bold">
                            Rp {{ number_format($produk->harga_akhir,0,',','.') }}
                        </h5>
                        @else
                        <h5 class="fw-bold">
                            Rp {{ number_format($produk->HARGA,0,',','.') }}
                        </h5>
                        <span class="badge bg-success">
                            Stok Tersedia
                        </span>
                        @endif
                        <div class="d-flex mb-4 text-warning">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <span class="ms-2 text-muted">
                            (5.0)
                        </span>
                         </div>
                        <div class="product-description">
                        <p>
                            {{ $produk->DESKRIPSI }}
                        </p>
                        <p>
                            Produk sasirangan khas Kalimantan Selatan dengan kualitas terbaik,
                            cocok digunakan sebagai bahan pakaian, souvenir, maupun koleksi budaya.
                        </p>
                        <p>
                            Dibuat menggunakan teknik tradisional sasirangan yang menjadi
                            warisan budaya masyarakat Banjar.
                        </p>
                        </div>
                        <div class="quantity-box mb-4">
                        <button type="button"
                                class="qty-btn"
                                onclick="decreaseQty()">
                            -
                        </button>
                        <input type="text"
                            id="qty"
                            value="1"
                            class="qty-input"
                            readonly>
                        <button type="button"
                                class="qty-btn"
                                onclick="increaseQty()">
                            +
                        </button>
                        </div>
                        <form action="{{ route('keranjang.add', $produk->ID_PRODUK) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Masukkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h5>Keunggulan Produk</h5>
                    <ul class="list-unstyled mt-3">
                        <li>✓ Sasirangan Asli</li>
                        <li>✓ Handmade</li>
                        <li>✓ Kualitas Premium</li>
                        <li>✓ Produk Lokal Kalimantan</li>
                    </ul>
                </div>
                </div>
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
                                <div class="mt-5">
                                <h4 class="fw-bold">
                                    Produk Unggulan
                                </h4>
                                @foreach($produk_terkait->take(3) as $unggulan)
                                <div class="d-flex mb-3">
                                    <img src="{{ asset('storage/'.$unggulan->FOTO_PRODUK) }}"
                                        width="70"
                                        height="70"
                                        class="rounded">
                                    <div class="ms-3">
                                        <h6>
                                            {{ $unggulan->NAMA_PRODUK }}
                                        </h6>
                                        <small>
                                            Rp {{ number_format($unggulan->HARGA,0,',','.') }}
                                        </small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-tabs mt-5">
        <ul class="nav nav-tabs">
        <li class="nav-item">
            <button class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#deskripsi">
                Deskripsi
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#detail">
                Detail Produk
            </button>
        </li>
        </ul>
    <div class="tab-content p-4 bg-white shadow-sm">
        <div class="tab-pane fade show active"
             id="deskripsi">
            {{ $produk->DESKRIPSI }}
        </div>
        <div class="product-meta mt-3">
            <span class="badge bg-light text-dark me-2">
                Berat:
                {{ $produk->BERAT_GRAM }} Gram
            </span>
            <span class="badge bg-light text-dark">
                Asal:
                Kalimantan Selatan
            </span>
        </div>
        <div class="tab-pane fade"
             id="detail">
            <table class="table">
                <tr>
        <th width="35%">Nama Produk</th>
        <td>{{ $produk->NAMA_PRODUK }}</td>
        </tr>
        <tr>
        <th>Kategori</th>
            <td>{{ $produk->kategori->NAMA_KATEGORI }}</td>
        </tr>
        <tr>
            <th>Berat</th>
            <td>{{ $produk->BERAT_GRAM }} Gram</td>
        </tr>
        <tr>
            <th>Asal Produk</th>
            <td>Kalimantan Selatan</td>
            </tr>
        <tr>
            <th>Kondisi</th>
            <td>Baru</td>
            </tr>
            <tr>
            <th>Kualitas</th>
            <td>Premium</td>
        </tr>
        </table>
        </div>
        </div>
        
        <h1 class="fw-bold mt-5 mb-4">Produk Terkait</h1>
        <div class="vesitable"></div>  
        
        {{-- BAGIAN PRODUK TERKAIT YANG DIPERBAIKI --}}
        <div class="row g-4 mt-2">
            @foreach($produk_terkait as $pt)
            <div class="col-md-6 col-lg-3">
                <div class="rounded position-relative fruite-item h-100 d-flex flex-column">
                    <div class="fruite-img">
                        <img src="{{ asset('storage/' . $pt->FOTO_PRODUK) }}" class="img-fluid w-100 rounded-top" alt="{{ $pt->NAMA_PRODUK }}" style="height: 250px; object-fit: cover;">
                    </div>
                    
                    {{-- Tag Kategori diperbaiki penutup tag dan posisinya --}}
                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                        {{ $pt->kategori->NAMA_KATEGORI ?? 'Produk' }}
                    </div>

                    @if(isset($pt->DISKON_PERSEN) && $pt->DISKON_PERSEN > 0)
                    <div class="badge bg-danger position-absolute" style="top:10px; left:10px;">
                        -{{ $pt->DISKON_PERSEN }}%
                    </div>
                    @endif
                    
                    <div class="p-4 border border-secondary border-top-0 rounded-bottom flex-grow-1 d-flex flex-column">
                        <h4><a href="{{ route('katalog.show', $pt->ID_PRODUK) }}" class="text-dark">{{ $pt->NAMA_PRODUK }}</a></h4>
                        
                        {{-- Opsional: Menambahkan deskripsi singkat agar struktur card serupa dengan referensi --}}
                        <p class="text-muted mb-3" style="font-size: 0.9rem;">
                            {{ Str::limit($pt->DESKRIPSI ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 50) }}
                        </p>

                        <div class="d-flex justify-content-between flex-lg-wrap mt-auto pt-2">
                            <div class="w-100 mb-3">
                                @if(isset($pt->DISKON_PERSEN) && $pt->DISKON_PERSEN > 0)
                                <p class="text-muted text-decoration-line-through mb-0" style="font-size: 0.85rem;">
                                    Rp {{ number_format($pt->HARGA,0,',','.') }}
                                </p>
                                <p class="text-danger fs-5 fw-bold mb-0">
                                    Rp {{ number_format($pt->harga_akhir,0,',','.') }}
                                </p>
                                @else
                                <p class="text-dark fs-5 fw-bold mb-0">
                                    Rp {{ number_format($pt->HARGA,0,',','.') }}
                                </p>
                                @endif
                            </div>
                            
                            {{-- Tambahan Form/Tombol Masukkan Keranjang --}}
                            <form action="{{ route('keranjang.add', $pt->ID_PRODUK) }}" method="POST" class="w-100 mt-2">
                                @csrf
                                <button type="submit" class="btn border border-secondary rounded-pill px-3 py-2 w-100 text-primary">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Masukkan ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- AKHIR BAGIAN PRODUK TERKAIT --}}
        
        </div>
    </div>
</div>
<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}
function decreaseQty() {
    let qty = document.getElementById('qty');
    if(parseInt(qty.value) > 1){
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>
@endsection