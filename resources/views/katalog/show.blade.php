@extends('layouts.front')

@section('title', $produk->NAMA_PRODUK)

@section('content')

<style>
    :root {
        --primary:   #7c3aed;
        --primary-d: #6d28d9;
        --primary-l: #ede9fe;
        --accent:    #f59e0b;
        --dark:      #1e1b2e;
        --text:      #374151;
        --text-soft: #6b7280;
        --border:    #e5e7eb;
        --bg-soft:   #fafafa;
        --radius:    14px;
        --radius-sm: 8px;
        --shadow:    0 2px 16px rgba(0,0,0,0.07);
        --shadow-md: 0 4px 32px rgba(0,0,0,0.10);
    }
    * { box-sizing: border-box; }
    body { font-family: 'Inter', system-ui, sans-serif; color: var(--text); }

    /* PAGE HEADER */
    .page-header-custom {
        background: linear-gradient(135deg, #1e1b2e 0%, #2d1b6e 50%, #4c1d95 100%);
        padding: 3rem 0 2rem; text-align: center;
    }
    .page-header-custom h1 {
        color: #fff; font-size: clamp(1.4rem, 2.5vw, 1.9rem);
        font-weight: 800; margin-bottom: 0.65rem; letter-spacing: -0.3px;
    }
    .breadcrumb-custom {
        display: flex; justify-content: center; align-items: center;
        gap: 8px; list-style: none; padding: 0; margin: 0; font-size: 0.82rem;
    }
    .breadcrumb-custom li { color: rgba(255,255,255,0.55); }
    .breadcrumb-custom li a { color: rgba(255,255,255,0.75); text-decoration: none; transition: color 0.15s; }
    .breadcrumb-custom li a:hover { color: #fff; }
    .breadcrumb-custom li.active { color: #fbbf24; font-weight: 600; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .breadcrumb-sep { color: rgba(255,255,255,0.3); }

    /* WRAP */
    .detail-wrap { max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem; }

    /* ALERT */
    .alert-success-custom {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: var(--radius-sm); padding: 12px 16px;
        font-size: 0.88rem; color: #166534;
        margin-bottom: 1.5rem;
    }
    .alert-success-custom svg { flex-shrink: 0; }

    /* MAIN GRID */
    .detail-main { display: grid; grid-template-columns: 1fr 1fr 260px; gap: 2rem; margin-bottom: 3.5rem; }

    /* Product image */
    .prod-img-main {
        border-radius: var(--radius); overflow: hidden;
        border: 1px solid var(--border); box-shadow: var(--shadow);
        background: var(--bg-soft);
    }
    .prod-img-main img { width: 100%; height: 420px; object-fit: cover; display: block; }

    /* Product info */
    .prod-info { display: flex; flex-direction: column; }

    .prod-cat-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--primary-l); color: var(--primary);
        font-size: 0.75rem; font-weight: 700;
        padding: 4px 12px; border-radius: 99px;
        margin-bottom: 0.85rem; width: fit-content;
    }

    .prod-title {
        font-size: clamp(1.3rem, 2vw, 1.65rem);
        font-weight: 800; color: var(--dark);
        line-height: 1.25; margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
    }

    .prod-rating-row {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 1rem; font-size: 0.85rem;
    }
    .prod-stars { color: #f59e0b; letter-spacing: 1px; font-size: 0.9rem; }
    .prod-rating-val { font-weight: 700; color: var(--dark); }
    .prod-rating-cnt { color: var(--text-soft); }

    .prod-price-orig { font-size: 0.85rem; color: #9ca3af; text-decoration: line-through; margin-bottom: 3px; }
    .prod-price {
        font-size: 1.6rem; font-weight: 900; color: var(--dark);
        letter-spacing: -0.5px; margin-bottom: 0.4rem;
    }
    .prod-price.disc { color: #ef4444; }

    .stock-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #f0fdf4; color: #166534;
        font-size: 0.75rem; font-weight: 700;
        padding: 3px 10px; border-radius: 99px;
        border: 1px solid #bbf7d0; margin-bottom: 1.25rem;
    }

    .prod-divider { height: 1px; background: var(--border); margin: 1.25rem 0; }

    .prod-desc-text {
        font-size: 0.9rem; color: var(--text);
        line-height: 1.75; margin-bottom: 1.25rem;
    }

    /* Quantity input */
    .qty-label {
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        color: var(--text-soft); margin-bottom: 0.6rem;
        display: block;
    }
    .qty-row {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 0.5rem;
    }
    .qty-btn {
        width: 38px; height: 38px; border-radius: var(--radius-sm);
        background: var(--primary-l); color: var(--primary);
        border: 1.5px solid #c4b5fd; font-size: 1.1rem;
        font-weight: 700; cursor: pointer; display: flex;
        align-items: center; justify-content: center;
        transition: background 0.13s, border-color 0.13s;
        flex-shrink: 0;
    }
    .qty-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
    .qty-input {
        width: 64px; height: 38px; text-align: center;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: 0.95rem; font-weight: 700; color: var(--dark);
        outline: none; background: #fff;
    }
    .qty-unit {
        font-size: 0.88rem; font-weight: 600; color: var(--text-soft);
    }
    .qty-note {
        font-size: 0.76rem; color: #ef4444;
        margin-bottom: 1.1rem; display: block;
    }

    .btn-add-cart {
        display: flex; align-items: center; justify-content: center;
        gap: 9px; width: 100%; background: var(--primary); color: #fff;
        border: none; border-radius: var(--radius-sm);
        padding: 13px 20px; font-size: 0.92rem; font-weight: 800;
        cursor: pointer; transition: background 0.15s, transform 0.12s, box-shadow 0.15s;
        box-shadow: 0 4px 14px rgba(124,58,237,0.28);
        text-decoration: none;
    }
    .btn-add-cart:hover {
        background: var(--primary-d); transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124,58,237,0.35); color: #fff;
    }

    /* SIDEBAR */
    .sidebar-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 1.3rem;
        margin-bottom: 1.1rem;
    }
    .sidebar-title {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1.2px; color: var(--text-soft);
        margin-bottom: 0.9rem; padding-bottom: 0.6rem;
        border-bottom: 1px solid var(--border);
    }

    /* Keunggulan */
    .benefit-list { list-style: none; padding: 0; margin: 0; }
    .benefit-list li {
        display: flex; align-items: center; gap: 9px;
        padding: 7px 0; border-bottom: 1px solid var(--border);
        font-size: 0.84rem; color: var(--text); font-weight: 500;
    }
    .benefit-list li:last-child { border-bottom: none; }
    .benefit-list .check {
        width: 20px; height: 20px; background: #f0fdf4;
        border-radius: 50%; display: flex; align-items: center;
        justify-content: center; flex-shrink: 0; color: #16a34a;
    }

    /* Cat list */
    .cat-list { list-style: none; padding: 0; margin: 0; }
    .cat-list li { margin-bottom: 2px; }
    .cat-list a {
        display: flex; align-items: center; gap: 8px; padding: 7px 9px;
        border-radius: var(--radius-sm); font-size: 0.84rem;
        color: var(--text); text-decoration: none; font-weight: 500;
        transition: background 0.13s, color 0.13s;
    }
    .cat-list a:hover { background: var(--primary-l); color: var(--primary); text-decoration: none; }

    /* Featured mini */
    .featured-item {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 0; border-bottom: 1px solid var(--border);
    }
    .featured-item:last-child { border-bottom: none; }
    .featured-img {
        width: 50px; height: 50px; border-radius: var(--radius-sm);
        object-fit: cover; flex-shrink: 0; border: 1px solid var(--border);
    }
    .featured-name {
        font-size: 0.8rem; font-weight: 600; color: var(--dark);
        text-decoration: none; display: -webkit-box;
        -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; line-height: 1.35; margin-bottom: 2px;
        transition: color 0.13s;
    }
    .featured-name:hover { color: var(--primary); }
    .featured-price { font-size: 0.77rem; font-weight: 700; color: var(--primary); }

    /* RELATED SECTION */
    .section-heading {
        font-size: 1.3rem; font-weight: 800; color: var(--dark);
        letter-spacing: -0.3px; margin-bottom: 1.5rem;
        padding-bottom: 0.75rem; border-bottom: 2px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }
    .section-heading::before {
        content: '';
        display: block; width: 4px; height: 22px;
        background: var(--primary); border-radius: 99px;
        flex-shrink: 0;
    }

    /* Related card */
    .prod-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--border); overflow: hidden;
        display: flex; flex-direction: column; height: 100%;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .prod-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
    .prod-img-wrap { position: relative; overflow: hidden; background: var(--bg-soft); }
    .prod-img-wrap img { width: 100%; height: 190px; object-fit: cover; transition: transform 0.35s; display: block; }
    .prod-card:hover .prod-img-wrap img { transform: scale(1.05); }
    .prod-rel-cat-tag {
        position: absolute; top: 10px; right: 10px;
        background: var(--dark); color: #fff;
        font-size: 0.68rem; font-weight: 700;
        padding: 3px 9px; border-radius: 99px;
    }
    .prod-rel-disc-tag {
        position: absolute; top: 10px; left: 10px;
        background: #ef4444; color: #fff;
        font-size: 0.68rem; font-weight: 700;
        padding: 3px 9px; border-radius: 99px;
    }
    .rel-body { padding: 0.9rem 1rem 1rem; display: flex; flex-direction: column; flex: 1; }
    .rel-name {
        font-size: 0.88rem; font-weight: 700; color: var(--dark);
        text-decoration: none; line-height: 1.35; margin-bottom: 0.6rem;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
        transition: color 0.13s;
    }
    .rel-name:hover { color: var(--primary); }
    .rel-price-orig { font-size: 0.74rem; color: #9ca3af; text-decoration: line-through; margin-bottom: 1px; }
    .rel-price { font-size: 0.97rem; font-weight: 800; color: var(--dark); margin-bottom: 0.75rem; flex: 1; }
    .rel-price.disc { color: #ef4444; }
    .btn-rel-buy {
        display: flex; align-items: center; justify-content: center;
        gap: 7px; background: var(--primary-l); color: var(--primary);
        border: 1.5px solid #c4b5fd; border-radius: var(--radius-sm);
        padding: 8px 12px; font-size: 0.8rem; font-weight: 700;
        cursor: pointer; width: 100%; transition: all 0.15s;
        text-decoration: none;
    }
    .btn-rel-buy:hover {
        background: var(--primary); color: #fff;
        border-color: var(--primary); text-decoration: none;
    }

    @media (max-width: 1024px) {
        .detail-main { grid-template-columns: 1fr 1fr; }
        .detail-main > :nth-child(3) { grid-column: span 2; }
    }
    @media (max-width: 640px) {
        .detail-main { grid-template-columns: 1fr; }
        .detail-main > :nth-child(3) { grid-column: span 1; }
        .prod-img-main img { height: 280px; }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header-custom">
    <h1>Detail Produk</h1>
    <ol class="breadcrumb-custom">
        <li><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-sep">›</li>
        <li><a href="{{ route('katalog.index') }}">Katalog</a></li>
        <li class="breadcrumb-sep">›</li>
        <li class="active">{{ $produk->NAMA_PRODUK }}</li>
    </ol>
</div>

<div class="detail-wrap">

    @if(session('success'))
    <div class="alert-success-custom">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- MAIN LAYOUT --}}
    <div class="detail-main">

        {{-- FOTO --}}
        <div class="prod-img-main">
            <img src="{{ asset('storage/'.$produk->FOTO_PRODUK) }}" alt="{{ $produk->NAMA_PRODUK }}">
        </div>

        {{-- INFO & FORM --}}
        <div class="prod-info">
            <div class="prod-cat-pill">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                    <line x1="7" y1="7" x2="7.01" y2="7"/>
                </svg>
                {{ $produk->kategori->NAMA_KATEGORI ?? 'Umum' }}
            </div>

            <h1 class="prod-title">{{ $produk->NAMA_PRODUK }}</h1>

            <<h1 class="prod-title">{{ $produk->NAMA_PRODUK }}</h1>

@php
    // Menghitung rata-rata rating dari semua ulasan yang masuk ke produk ini
    $rataRataRating = $produk->ulasan->avg('RATING') ?? 0; 
    $bintangPenuh = floor($rataRataRating);
    $setengahBintang = ($rataRataRating - $bintangPenuh) >= 0.5;
@endphp

<div class="prod-rating-row">
    <span class="prod-stars" style="color: var(--accent);">
        @for($i = 1; $i <= 5; $i++)
            @if($i <= $bintangPenuh)
                ★
            @elseif($i == $bintangPenuh + 1 && $setengahBintang)
                ½ @else
                ☆
            @endif
        @endfor
    </span>
    <span class="prod-rating-val">{{ number_format($rataRataRating, 1) }}</span>
    <span class="prod-rating-cnt">· ({{ $produk->ulasan->count() }} Ulasan) · Sasirangan Asli</span>
</div>

            @if(isset($produk->DISKON_PERSEN) && $produk->DISKON_PERSEN > 0)
            <div class="prod-price-orig">Rp {{ number_format($produk->HARGA, 0, ',', '.') }}</div>
            <div class="prod-price disc">Rp {{ number_format($produk->harga_akhir, 0, ',', '.') }}</div>
            @else
            <div class="prod-price">Rp {{ number_format($produk->HARGA, 0, ',', '.') }}</div>
            <div class="stock-badge">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Stok Tersedia
            </div>
            @endif

            <div class="prod-divider"></div>

            <p class="prod-desc-text">{{ $produk->DESKRIPSI }}</p>
            <p class="prod-desc-text" style="margin-bottom:1.25rem;">
                Produk sasirangan khas Kalimantan Selatan dengan kualitas terbaik, cocok sebagai bahan pakaian, souvenir, maupun koleksi budaya.
            </p>

            <form action="{{ route('keranjang.add', $produk->ID_PRODUK) }}" method="POST">
                @csrf
                <label class="qty-label">Panjang Kain (Meter)</label>
                <div class="qty-row">
                    <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
                    <input type="text" id="qty" name="jumlah" value="1" class="qty-input" readonly>
                    <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
                    <span class="qty-unit">Meter</span>
                </div>
                <small class="qty-note">*Kain dikirim utuh sesuai total meter yang dipesan, tanpa dipotong.</small>
                <button type="submit" class="btn-add-cart">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    Masukkan Keranjang
                </button>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div>
            <div class="sidebar-card">
                <div class="sidebar-title">Keunggulan Produk</div>
                <ul class="benefit-list">
                    <li>
                        <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        Sasirangan Asli
                    </li>
                    <li>
                        <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        Handmade Pengrajin Lokal
                    </li>
                    <li>
                        <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        Kualitas Premium
                    </li>
                    <li>
                        <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        Produk Lokal Kalimantan
                    </li>
                    <li>
                        <span class="check"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        Garansi Keaslian
                    </li>
                </ul>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">Kategori Lainnya</div>
                <ul class="cat-list">
                    @foreach($kategori_sidebar as $kat)
                    <li>
                        <a href="{{ route('katalog.index', ['kategori' => $kat->ID_KATEGORI]) }}">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                <line x1="7" y1="7" x2="7.01" y2="7"/>
                            </svg>
                            {{ $kat->NAMA_KATEGORI }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">Produk Unggulan</div>
                @foreach($produk_terkait->take(3) as $unggulan)
                <div class="featured-item">
                    <img src="{{ asset('storage/'.$unggulan->FOTO_PRODUK) }}" class="featured-img" alt="{{ $unggulan->NAMA_PRODUK }}">
                    <div style="min-width:0;">
                        <a href="{{ route('katalog.show', $unggulan->ID_PRODUK) }}" class="featured-name">{{ $unggulan->NAMA_PRODUK }}</a>
                        <div class="featured-price">Rp {{ number_format($unggulan->HARGA, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- PRODUK TERKAIT --}}
    @if($produk_terkait->count())
    <div class="section-heading">Produk Terkait</div>
    <div class="row g-3">
        @foreach($produk_terkait as $pt)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="prod-card">
                <div class="prod-img-wrap">
                    <img src="{{ asset('storage/'.$pt->FOTO_PRODUK) }}" alt="{{ $pt->NAMA_PRODUK }}">
                    <span class="prod-rel-cat-tag">{{ $pt->kategori->NAMA_KATEGORI ?? 'Produk' }}</span>
                    @if(isset($pt->DISKON_PERSEN) && $pt->DISKON_PERSEN > 0)
                    <span class="prod-rel-disc-tag">−{{ $pt->DISKON_PERSEN }}%</span>
                    @endif
                </div>
                <div class="rel-body">
                    <a href="{{ route('katalog.show', $pt->ID_PRODUK) }}" class="rel-name">{{ $pt->NAMA_PRODUK }}</a>
                    @if(isset($pt->DISKON_PERSEN) && $pt->DISKON_PERSEN > 0)
                    <div class="rel-price-orig">Rp {{ number_format($pt->HARGA, 0, ',', '.') }}</div>
                    <div class="rel-price disc">Rp {{ number_format($pt->harga_akhir, 0, ',', '.') }}</div>
                    @else
                    <div class="rel-price">Rp {{ number_format($pt->HARGA, 0, ',', '.') }}</div>
                    @endif
                    <form action="{{ route('keranjang.add', $pt->ID_PRODUK) }}" method="POST">
                        @csrf
                        <input type="hidden" name="jumlah" value="1">
                        <button type="submit" class="btn-rel-buy">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                <line x1="3" y1="6" x2="21" y2="6"/>
                                <path d="M16 10a4 4 0 0 1-8 0"/>
                            </svg>
                            Beli Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

<script>
function increaseQty() {
    let qty = document.getElementById('qty');
    qty.value = parseInt(qty.value) + 1;
}
function decreaseQty() {
    let qty = document.getElementById('qty');
    if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
}
</script>

@endsection