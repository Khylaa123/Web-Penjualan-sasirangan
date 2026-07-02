@extends('layouts.front')

@section('title', 'Beranda')

@section('content')

<style>
    /* ─── RESET & BASE ─────────────────────────────────── */
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,500&family=Karla:wght@400;500;600;700&display=swap');

    :root {
        --primary:      #A97524;
        --primary-d:    #8C5D1B;
        --primary-l:    #F5E8CC;
        --accent:       #D9A441;
        --accent-d:     #A97524;
        --accent-bright:#E6C077;
        --dark:         #2B2118;
        --text:         #4A3B2C;
        --text-soft:    #8A7860;
        --border:       #EADCC0;
        --bg-soft:      #FBF3E3;
        --radius:    14px;
        --radius-sm: 8px;
        --shadow:    0 2px 16px rgba(43,33,24,0.07);
        --shadow-md: 0 4px 32px rgba(43,33,24,0.10);
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Karla', 'Inter', system-ui, sans-serif;
        color: var(--text);
        background: #fff;
    }

    .hero-title, .section-heading, .promo-banner h2 {
        font-family: 'Fraunces', serif;
    }

    img { display: block; }

    /* ─── HERO ──────────────────────────────────────────── */
    .hero-section {
        background: linear-gradient(135deg, #2B2118 0%, #4A3323 55%, #7A5220 100%);
        padding: 5rem 0 4rem;
        overflow: hidden;
        position: relative;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='74' viewBox='0 0 64 74'%3E%3Cpath d='M32 0 L64 18.5 L64 55.5 L32 74 L0 55.5 L0 18.5 Z' fill='none' stroke='%23ffffff' stroke-opacity='0.045' stroke-width='1'/%3E%3C/svg%3E");
        background-size: 64px 74px;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(217,164,65,0.2);
        color: var(--accent-bright);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 99px;
        margin-bottom: 1.25rem;
        border: 1px solid rgba(217,164,65,0.35);
    }

    .hero-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        color: #fff !important;
        line-height: 1.18;
        margin-bottom: 1.5rem;
        letter-spacing: -0.3px;
    }

    .hero-title span {
        color: #fff !important;
    }

    .hero-search {
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 99px;
        padding: 6px 6px 6px 20px;
        max-width: 480px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        gap: 8px;
    }

    .hero-search input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 0.95rem;
        color: var(--dark);
        background: transparent;
        min-width: 0;
    }

    .hero-search input::placeholder { color: #9ca3af; }

    .hero-search button {
        background: var(--primary);
        color: #fff;
        border: none;
        padding: 10px 22px;
        border-radius: 99px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.18s, transform 0.12s;
        flex-shrink: 0;
    }

    .hero-search button:hover {
        background: var(--primary-d);
        transform: translateY(-1px);
    }

    .hero-badges {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .hero-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        color: rgba(255,255,255,0.75);
        font-size: 0.82rem;
    }

    .hero-badge svg { color: var(--accent-bright); flex-shrink: 0; }

    /* Carousel */
    .hero-carousel-wrap {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(0,0,0,0.35);
    }

    .carousel-img {
        height: 360px;
        object-fit: cover;
        width: 100%;
    }

    /* ─── FEATURE STRIP ─────────────────────────────────── */
    .feature-strip {
        background: #fff;
        border-bottom: 1px solid var(--border);
        padding: 0;
    }

    .feature-strip-inner {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        divide: var(--border);
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 1.5rem 2rem;
        border-right: 1px solid var(--border);
        transition: background 0.15s;
    }

    .feature-item:last-child { border-right: none; }
    .feature-item:hover { background: var(--primary-l); }

    .feature-icon {
        width: 44px;
        height: 44px;
        background: var(--primary-l);
        color: var(--primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.1rem;
        transition: background 0.15s, color 0.15s;
    }

    .feature-item:hover .feature-icon {
        background: var(--primary);
        color: #fff;
    }

    .feature-text h6 {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 2px;
    }

    .feature-text p {
        font-size: 0.78rem;
        color: var(--text-soft);
        margin: 0;
    }

    /* ─── SECTION HEADER ────────────────────────────────── */
    .section-eyebrow {
        display: inline-block;
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .section-heading {
        font-size: clamp(1.4rem, 2.5vw, 1.9rem);
        font-weight: 800;
        color: var(--dark);
        letter-spacing: -0.3px;
        margin-bottom: 0.5rem;
    }

    .section-sub {
        font-size: 0.93rem;
        color: var(--text-soft);
        max-width: 480px;
    }

    /* ─── CATEGORY PILLS ─────────────────────────────────── */
    .cat-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 2rem;
    }

    .cat-pill {
        display: inline-flex;
        padding: 7px 18px;
        border-radius: 99px;
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: 1.5px solid var(--border);
        color: var(--text-soft);
        background: #fff;
        transition: all 0.15s;
    }

    .cat-pill:hover,
    .cat-pill.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
        text-decoration: none;
    }

    /* ─── PRODUCT CARD ───────────────────────────────────── */
    .prod-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .prod-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }

    .prod-img-wrap {
        position: relative;
        overflow: hidden;
        background: var(--bg-soft);
    }

    .prod-img-wrap img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.35s;
    }

    .prod-card:hover .prod-img-wrap img {
        transform: scale(1.05);
    }

    .prod-category-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--dark);
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 99px;
        letter-spacing: 0.3px;
    }

    .prod-discount-tag {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #B3452C;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 99px;
    }

    .prod-body {
        padding: 1rem 1.1rem 1.1rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .prod-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.35rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prod-desc {
        font-size: 0.8rem;
        color: var(--text-soft);
        margin-bottom: 0.75rem;
        flex: 1;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .prod-price-original {
        font-size: 0.78rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-bottom: 1px;
    }

    .prod-price {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 0.9rem;
    }

    .prod-price.discounted { color: #B3452C; }

    .prod-actions {
        display: flex;
        gap: 8px;
    }

    .btn-cart {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        padding: 9px 12px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, transform 0.12s;
    }

    .btn-cart:hover {
        background: var(--primary-d);
        color: #fff;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 13px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        color: var(--text);
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: var(--bg-soft);
        border-color: var(--text);
        color: var(--dark);
        text-decoration: none;
    }

    /* ─── PROMO BANNER ───────────────────────────────────── */
    .promo-banner {
        background: linear-gradient(135deg, #2B2118 0%, #6B4A22 100%);
        border-radius: 20px;
        padding: 3.5rem;
        position: relative;
        overflow: hidden;
    }

    .promo-banner::after {
        content: '';
        position: absolute;
        right: -60px; top: -60px;
        width: 300px; height: 300px;
        background: rgba(217,164,65,0.22);
        border-radius: 50%;
    }

    .promo-banner::before {
        content: '';
        position: absolute;
        right: 80px; bottom: -80px;
        width: 200px; height: 200px;
        background: rgba(217,164,65,0.15);
        border-radius: 50%;
    }

    .promo-banner h2 {
        color: #fff !important;
        font-size: clamp(1.5rem, 2.5vw, 2.2rem);
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
        position: relative; z-index: 1;
    }

    .promo-banner p {
        color: rgba(255,255,255,0.75);
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        position: relative; z-index: 1;
    }

    .btn-promo {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--accent);
        color: var(--dark);
        font-weight: 800;
        font-size: 0.9rem;
        padding: 12px 26px;
        border-radius: 99px;
        text-decoration: none;
        transition: background 0.18s, transform 0.12s;
        position: relative; z-index: 1;
    }

    .btn-promo:hover {
        background: var(--accent-bright);
        transform: translateY(-2px);
        color: var(--dark);
        text-decoration: none;
    }

    .promo-img {
        max-height: 260px;
        width: auto;
        margin: 0 auto;
        object-fit: contain;
        position: relative; z-index: 1;
        filter: drop-shadow(0 16px 32px rgba(0,0,0,0.3));
    }

    /* ─── STATS ──────────────────────────────────────────── */
    .stats-section {
        background: var(--bg-soft);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        padding: 3rem 0;
    }

    .stat-item {
        text-align: center;
        padding: 0.5rem 1rem;
        border-right: 1px solid var(--border);
    }

    .stat-item:last-child { border-right: none; }

    .stat-number {
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 900;
        color: var(--primary);
        letter-spacing: -1px;
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 0.83rem;
        color: var(--text-soft);
        font-weight: 500;
    }

    /* ─── TESTIMONIALS ───────────────────────────────────── */
    .testi-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.75rem;
        position: relative;
        transition: box-shadow 0.2s;
    }

    .testi-card:hover { box-shadow: var(--shadow-md); }

    .testi-quote {
        color: var(--primary);
        font-size: 1.6rem;
        line-height: 1;
        margin-bottom: 0.75rem;
        opacity: 0.4;
    }

    .testi-text {
        font-size: 0.92rem;
        color: var(--text);
        line-height: 1.65;
        margin-bottom: 1rem;
        font-style: italic;
    }

    .testi-stars {
        color: var(--accent);
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
        letter-spacing: 2px;
    }

    .testi-author {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .testi-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-l);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .testi-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .testi-location {
        font-size: 0.75rem;
        color: var(--text-soft);
    }

    /* ─── CULTURE ────────────────────────────────────────── */
    .culture-section { background: #fff; }

    .culture-img-wrap {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .culture-img-wrap img {
        width: 100%;
        height: 380px;
        object-fit: cover;
    }

    .culture-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--accent);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
    }

    .culture-lead {
        font-size: 0.95rem;
        color: var(--text);
        line-height: 1.75;
        margin-bottom: 1.1rem;
    }

    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 12px 26px;
        border-radius: 99px;
        text-decoration: none;
        transition: background 0.18s, transform 0.12s;
    }

    .btn-cta:hover {
        background: var(--primary-d);
        color: #fff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    /* ─── UTILITIES ──────────────────────────────────────── */
    .py-section { padding: 5rem 0; }
    .py-section-sm { padding: 3.5rem 0; }

    @media (max-width: 768px) {
        .feature-strip-inner { grid-template-columns: 1fr 1fr; }
        .feature-item { border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .feature-item:nth-child(2n) { border-right: none; }
        .promo-banner { padding: 2rem 1.5rem; }
        .stat-item { border-right: none; border-bottom: 1px solid var(--border); padding: 1rem; }
        .stat-item:last-child { border-bottom: none; }
        .hero-section { padding: 3.5rem 0 3rem; }
        .carousel-img { height: 240px; }
    }
</style>

{{-- ══════════════ HERO ══════════════ --}}
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-eyebrow">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor">
                        <circle cx="5" cy="5" r="5"/>
                    </svg>
                    100% Produk Lokal Kalimantan
                </div>
                <h1 class="hero-title">
                    Keindahan <span>Sasirangan</span><br>Khas Banua
                </h1>
                <p style="color:rgba(255,255,255,0.7);font-size:0.97rem;margin-bottom:1.75rem;line-height:1.7;">
                    Temukan koleksi kain, baju, dan tas sasirangan asli<br>dengan motif eksklusif dari pengrajin terpilih.
                </p>
                <form action="{{ route('katalog.index') }}" method="GET" class="hero-search">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input name="search" type="text" placeholder="Cari motif sasirangan...">
                    <button type="submit">Cari Sekarang</button>
                </form>
                <div class="hero-badges">
                    <div class="hero-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Gratis Ongkir
                    </div>
                    <div class="hero-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Pembayaran Aman
                    </div>
                    <div class="hero-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Garansi Asli
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-carousel-wrap">
                    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('front/img/Model-Sasirangan.png') }}" class="carousel-img" alt="Model Sasirangan">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('front/img/Tas.png') }}" class="carousel-img" alt="Tas Sasirangan">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('front/img/Sasirangan1.png') }}" class="carousel-img" alt="Kain Sasirangan">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ FEATURE STRIP ══════════════ --}}
<section class="feature-strip">
    <div class="container">
        <div class="feature-strip-inner">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-tags"></i></div>
                <div class="feature-text">
                    <h6>Motif Eksklusif</h6>
                    <p>Khas Kalimantan Selatan</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-shield-alt"></i></div>
                <div class="feature-text">
                    <h6>Pembayaran Aman</h6>
                    <p>Transaksi 100% Terjamin</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-award"></i></div>
                <div class="feature-text">
                    <h6>Kualitas Premium</h6>
                    <p>Sasirangan Asli Pilihan</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-store"></i></div>
                <div class="feature-text">
                    <h6>Produk Lokal</h6>
                    <p>UMKM Banua Terpercaya</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ PRODUK ══════════════ --}}
<section class="py-section">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-lg-6">
                <span class="section-eyebrow">Koleksi Pilihan</span>
                <h2 class="section-heading">Koleksi Sasirangan Terbaru</h2>
                <p class="section-sub">Berbagai motif sasirangan khas Kalimantan Selatan dengan kualitas terbaik dan harga terjangkau.</p>
            </div>
            <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('katalog.index') }}" style="font-size:0.88rem;font-weight:700;color:var(--primary);text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    Lihat Semua Produk
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Category Pills --}}
        <div class="cat-pills">
            <a class="cat-pill active" data-bs-toggle="pill" href="#tab-all">Semua Produk</a>
            @foreach($kategori as $k)
            <a class="cat-pill" data-bs-toggle="pill" href="#tab-{{ $k->ID_KATEGORI }}">{{ $k->NAMA_KATEGORI }}</a>
            @endforeach
        </div>

        {{-- Tab Content --}}
        <div class="tab-content">
            <div id="tab-all" class="tab-pane fade show active">
                <div class="row g-4">
                    @foreach($produk as $p)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="prod-card">
                            <div class="prod-img-wrap">
                                <img src="{{ $p->FOTO_PRODUK ? asset('storage/'.$p->FOTO_PRODUK) : asset('front/img/fruite-item-5.png') }}"
                                     alt="{{ $p->NAMA_PRODUK }}">
                                <span class="prod-category-tag">{{ $p->kategori->NAMA_KATEGORI }}</span>
                                @if(isset($p->DISKON_PERSEN) && $p->DISKON_PERSEN > 0)
                                <span class="prod-discount-tag">−{{ $p->DISKON_PERSEN }}%</span>
                                @endif
                            </div>
                            <div class="prod-body">
                                <div class="prod-name">{{ $p->NAMA_PRODUK }}</div>
                                <div class="prod-desc">{{ Str::limit($p->DESKRIPSI, 60) }}</div>
                                <div class="mb-2">
                                    @if(isset($p->DISKON_PERSEN) && $p->DISKON_PERSEN > 0)
                                    <div class="prod-price-original">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</div>
                                    <div class="prod-price discounted">Rp {{ number_format($p->harga_setelah_diskon, 0, ',', '.') }}</div>
                                    @else
                                    <div class="prod-price">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</div>
                                    @endif
                                </div>
                                <div class="prod-actions">
                                    <form action="{{ route('keranjang.add', $p->ID_PRODUK) }}" method="POST" style="flex:1;">
                                        @csrf
                                        <button type="submit" class="btn-cart w-100">
                                            <i class="fa fa-shopping-bag"></i> Beli
                                        </button>
                                    </form>
                                    <a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="btn-detail">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ PROMO BANNER ══════════════ --}}
<section class="py-section-sm">
    <div class="container">
        <div class="promo-banner">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span style="color:#E6C077;font-size:0.75rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;display:block;margin-bottom:0.5rem;position:relative;z-index:1;">Penawaran Spesial</span>
                    <h2>Koleksi Sasirangan<br>Premium Hadir!</h2>
                    <p>Dapatkan motif eksklusif khas Kalimantan Selatan dengan desain modern yang elegan untuk berbagai kesempatan.</p>
                    <a href="{{ route('katalog.index') }}" class="btn-promo">
                        Belanja Sekarang
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('front/img/Sasirangan1.png') }}" class="promo-img" alt="Sasirangan Premium">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ STATS ══════════════ --}}
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Pelanggan Puas</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">150+</div>
                    <div class="stat-label">Motif Produk</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Tingkat Kepuasan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Tahun Pengalaman</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ TESTIMONI ══════════════ --}}
<section class="py-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-eyebrow">Ulasan Pelanggan</span>
            <h2 class="section-heading">Apa Kata Mereka?</h2>
            <p class="section-sub mx-auto">Ribuan pelanggan sudah merasakan kualitas dan keindahan sasirangan asli kami.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testi-card">
                    <div class="testi-quote">❝</div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">Produknya sangat bagus dan motifnya khas sekali. Benar-benar mencerminkan budaya Kalimantan yang kaya.</p>
                    <div class="testi-author">
                        <div class="testi-avatar">SA</div>
                        <div>
                            <p class="testi-name">Siti Aminah</p>
                            <span class="testi-location">Banjarmasin</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testi-card">
                    <div class="testi-quote">❝</div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">Pengiriman cepat dan kualitas kain luar biasa. Sudah pesan berkali-kali dan selalu puas dengan hasilnya.</p>
                    <div class="testi-author">
                        <div class="testi-avatar">AF</div>
                        <div>
                            <p class="testi-name">Ahmad Fauzi</p>
                            <span class="testi-location">Martapura</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testi-card">
                    <div class="testi-quote">❝</div>
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">Sangat cocok untuk hadiah dan acara resmi. Tamu selalu kagum dengan keindahan motifnya yang unik.</p>
                    <div class="testi-author">
                        <div class="testi-avatar">NH</div>
                        <div>
                            <p class="testi-name">Nurhaliza</p>
                            <span class="testi-location">Banjarbaru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════ CULTURE ══════════════ --}}
<section class="py-section culture-section" style="background:var(--bg-soft);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="culture-img-wrap">
                    <img src="{{ asset('front/img/Sasirangan1.png') }}" alt="Warisan Budaya Sasirangan">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="culture-eyebrow">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Warisan Leluhur
                </div>
                <h2 class="section-heading">Warisan Budaya<br>Kalimantan Selatan</h2>
                <p class="culture-lead">
                    Sasirangan adalah kain tradisional khas Kalimantan Selatan yang dibuat dengan teknik ikat celup turun-temurun. Setiap motif menyimpan makna dan filosofi mendalam dari leluhur Banjar.
                </p>
                <p class="culture-lead" style="margin-bottom:1.75rem;">
                    Mellisari hadir untuk melestarikan dan memperkenalkan keindahan sasirangan kepada dunia, dengan tetap menjaga keaslian teknik dan kualitas bahan terbaik.
                </p>
                <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                    <a href="#" class="btn-cta">
                        Pelajari Lebih Lanjut
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                    <a href="{{ route('katalog.index') }}" style="font-size:0.88rem;font-weight:700;color:var(--text-soft);text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                        Lihat Koleksi
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection