@extends('layouts.front')

@section('title', 'Katalog Produk')

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
        padding: 3.5rem 0 2.5rem;
        text-align: center;
    }
    .page-header-custom h1 {
        color: #fff;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.3px;
    }
    .breadcrumb-custom {
        display: flex; justify-content: center; align-items: center;
        gap: 8px; list-style: none; padding: 0; margin: 0;
        font-size: 0.83rem;
    }
    .breadcrumb-custom li { color: rgba(255,255,255,0.55); }
    .breadcrumb-custom li a { color: rgba(255,255,255,0.75); text-decoration: none; transition: color 0.15s; }
    .breadcrumb-custom li a:hover { color: #fff; }
    .breadcrumb-custom li.active { color: #fbbf24; font-weight: 600; }
    .breadcrumb-sep { color: rgba(255,255,255,0.3); }

    /* LAYOUT */
    .catalog-wrap { max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem; }
    .catalog-grid { display: grid; grid-template-columns: 250px 1fr; gap: 2rem; align-items: start; }

    /* SIDEBAR */
    .sidebar-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: var(--radius); padding: 1.4rem;
        margin-bottom: 1.1rem;
    }
    .sidebar-title {
        font-size: 0.72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.2px;
        color: var(--text-soft); margin-bottom: 1rem;
        padding-bottom: 0.6rem; border-bottom: 1px solid var(--border);
    }

    /* Search */
    .sb-search {
        display: flex; align-items: center;
        background: var(--bg-soft); border: 1.5px solid var(--border);
        border-radius: 99px; padding: 5px 5px 5px 12px; gap: 6px;
        transition: border-color 0.18s, box-shadow 0.18s;
    }
    .sb-search:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.1); background: #fff;
    }
    .sb-search svg { color: #9ca3af; flex-shrink: 0; }
    .sb-search input {
        flex: 1; border: none; outline: none;
        font-size: 0.86rem; color: var(--dark);
        background: transparent; min-width: 0;
    }
    .sb-search input::placeholder { color: #9ca3af; }
    .sb-search button {
        background: var(--primary); color: #fff; border: none;
        border-radius: 99px; padding: 6px 12px;
        font-size: 0.78rem; font-weight: 700;
        cursor: pointer; transition: background 0.15s; flex-shrink: 0;
    }
    .sb-search button:hover { background: var(--primary-d); }

    /* Category list */
    .cat-list { list-style: none; padding: 0; margin: 0; }
    .cat-list li { margin-bottom: 2px; }
    .cat-list a {
        display: flex; align-items: center; gap: 8px;
        padding: 7px 9px; border-radius: var(--radius-sm);
        font-size: 0.85rem; color: var(--text);
        text-decoration: none; font-weight: 500;
        transition: background 0.13s, color 0.13s;
    }
    .cat-list a:hover, .cat-list a.active {
        background: var(--primary-l); color: var(--primary); text-decoration: none;
    }
    .cat-list a svg { flex-shrink: 0; opacity: 0.5; }
    .cat-list a.active svg { opacity: 1; }

    /* Featured */
    .featured-item {
        display: flex; align-items: center; gap: 11px;
        padding: 9px 0; border-bottom: 1px solid var(--border);
    }
    .featured-item:last-child { border-bottom: none; padding-bottom: 0; }
    .featured-img {
        width: 52px; height: 52px; border-radius: var(--radius-sm);
        object-fit: cover; flex-shrink: 0; border: 1px solid var(--border);
    }
    .featured-name {
        font-size: 0.81rem; font-weight: 600; color: var(--dark);
        text-decoration: none; display: -webkit-box;
        -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; line-height: 1.35; margin-bottom: 3px;
        transition: color 0.13s;
    }
    .featured-name:hover { color: var(--primary); }
    .featured-price { font-size: 0.78rem; font-weight: 700; color: var(--primary); }

    /* PRODUCT GRID */
    .products-meta {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.25rem; flex-wrap: wrap; gap: 8px;
    }
    .products-count { font-size: 0.82rem; color: var(--text-soft); }
    .products-count strong { color: var(--dark); }

    /* Product card */
    .prod-card {
        background: #fff; border-radius: var(--radius);
        border: 1px solid var(--border); overflow: hidden;
        display: flex; flex-direction: column; height: 100%;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .prod-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
    .prod-img-wrap { position: relative; overflow: hidden; background: var(--bg-soft); }
    .prod-img-wrap img {
        width: 100%; height: 210px; object-fit: cover;
        transition: transform 0.35s; display: block;
    }
    .prod-card:hover .prod-img-wrap img { transform: scale(1.05); }
    .prod-cat-tag {
        position: absolute; top: 10px; right: 10px;
        background: var(--dark); color: #fff;
        font-size: 0.69rem; font-weight: 700;
        padding: 3px 9px; border-radius: 99px;
    }
    .prod-disc-tag {
        position: absolute; top: 10px; left: 10px;
        background: #ef4444; color: #fff;
        font-size: 0.69rem; font-weight: 700;
        padding: 3px 9px; border-radius: 99px;
    }
    .prod-body {
        padding: 1rem 1.1rem 1.1rem;
        display: flex; flex-direction: column; flex: 1;
    }
    .prod-name {
        font-size: 0.92rem; font-weight: 700; color: var(--dark);
        text-decoration: none; display: -webkit-box;
        -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; line-height: 1.35; margin-bottom: 0.3rem;
        transition: color 0.13s;
    }
    .prod-name:hover { color: var(--primary); }
    .prod-stars { font-size: 0.77rem; color: #f59e0b; margin-bottom: 0.35rem; letter-spacing: 1px; }
    .prod-stars span { color: var(--text-soft); margin-left: 3px; letter-spacing: 0; }
    .prod-desc {
        font-size: 0.79rem; color: var(--text-soft); line-height: 1.55;
        flex: 1; margin-bottom: 0.75rem;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .prod-price-orig { font-size: 0.75rem; color: #9ca3af; text-decoration: line-through; margin-bottom: 1px; }
    .prod-price { font-size: 1rem; font-weight: 800; color: var(--dark); margin-bottom: 0.8rem; }
    .prod-price.disc { color: #ef4444; }
    .btn-detail {
        display: inline-flex; align-items: center; justify-content: center;
        gap: 7px; background: var(--primary); color: #fff; border: none;
        border-radius: var(--radius-sm); padding: 9px 14px;
        font-size: 0.83rem; font-weight: 700;
        text-decoration: none; width: 100%;
        transition: background 0.15s, transform 0.12s;
    }
    .btn-detail:hover {
        background: var(--primary-d); color: #fff;
        transform: translateY(-1px); text-decoration: none;
    }

    /* Search banner */
    .search-banner {
        display: flex; align-items: center; gap: 9px;
        background: var(--primary-l); border: 1px solid #c4b5fd;
        border-radius: var(--radius-sm); padding: 9px 13px;
        margin-bottom: 1.1rem; font-size: 0.84rem; color: var(--primary);
    }
    .search-banner a {
        margin-left: auto; color: var(--primary); font-weight: 700;
        text-decoration: none; font-size: 0.79rem; white-space: nowrap;
        opacity: 0.75; transition: opacity 0.13s;
    }
    .search-banner a:hover { opacity: 1; }

    /* Empty state */
    .empty-wrap {
        text-align: center; padding: 5rem 1rem; background: #fff;
        border: 1px solid var(--border); border-radius: var(--radius);
    }
    .empty-icon {
        width: 68px; height: 68px; background: var(--primary-l);
        border-radius: 50%; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 1.1rem;
    }
    .empty-wrap h5 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 0.4rem; }
    .empty-wrap p { font-size: 0.86rem; color: var(--text-soft); margin-bottom: 1.25rem; }
    .btn-back {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--primary); color: #fff; border-radius: 99px;
        padding: 9px 22px; font-size: 0.84rem; font-weight: 700;
        text-decoration: none; transition: background 0.15s;
    }
    .btn-back:hover { background: var(--primary-d); color: #fff; text-decoration: none; }

    /* Pagination */
    .pagination { gap: 4px; }
    .page-link {
        border-radius: var(--radius-sm) !important;
        border: 1.5px solid var(--border) !important;
        color: var(--text) !important; font-size: 0.84rem;
        font-weight: 600; padding: 6px 12px; transition: all 0.15s;
    }
    .page-link:hover { background: var(--primary-l) !important; border-color: var(--primary) !important; color: var(--primary) !important; }
    .page-item.active .page-link { background: var(--primary) !important; border-color: var(--primary) !important; color: #fff !important; }

    @media (max-width: 900px) {
        .catalog-grid { grid-template-columns: 1fr; }
    }
</style>

{{-- PAGE HEADER --}}
<div class="page-header-custom">
    <h1>Katalog Produk</h1>
    <ol class="breadcrumb-custom">
        <li><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-sep">›</li>
        <li class="active">Katalog</li>
    </ol>
</div>

<div class="catalog-wrap">
    <div class="catalog-grid">

        {{-- SIDEBAR --}}
        <aside>
            <div class="sidebar-card">
                <div class="sidebar-title">Cari Produk</div>
                <form action="{{ route('katalog.index') }}" method="GET">
                    <div class="sb-search">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" placeholder="Nama produk..." value="{{ request('search') }}">
                        <button type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">Kategori</div>
                <ul class="cat-list">
                    <li>
                        <a href="{{ route('katalog.index') }}" class="{{ !request('kategori') ? 'active' : '' }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Semua Produk
                        </a>
                    </li>
                    @foreach($kategori as $kat)
                    <li>
                        <a href="{{ route('katalog.index', ['kategori' => $kat->ID_KATEGORI]) }}"
                           class="{{ request('kategori') == $kat->ID_KATEGORI ? 'active' : '' }}">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
                @foreach($featured as $f)
                <div class="featured-item">
                    <img src="{{ asset('storage/'.$f->FOTO_PRODUK) }}" class="featured-img" alt="{{ $f->NAMA_PRODUK }}">
                    <div style="min-width:0;">
                        <a href="{{ route('katalog.show', $f->ID_PRODUK) }}" class="featured-name">{{ $f->NAMA_PRODUK }}</a>
                        <div class="featured-price">Rp {{ number_format($f->HARGA, 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </aside>

        {{-- PRODUCT AREA --}}
        <div>
            @if(request('search'))
            <div class="search-banner">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Hasil untuk <strong style="margin:0 3px;">"{{ request('search') }}"</strong> — {{ $produk->total() }} produk
                <a href="{{ route('katalog.index') }}">× Hapus filter</a>
            </div>
            @endif

            <div class="products-meta">
                <div class="products-count">
                    Menampilkan <strong>{{ $produk->firstItem() }}–{{ $produk->lastItem() }}</strong>
                    dari <strong>{{ $produk->total() }}</strong> produk
                </div>
            </div>

            <div class="row g-3">
                @forelse($produk as $p)
                <div class="col-sm-6 col-xl-4">
                    <div class="prod-card">
                        <div class="prod-img-wrap">
                            <img src="{{ asset('storage/' . ($p->FOTO_PRODUK ?? $p->GAMBAR_UTAMA)) }}" alt="{{ $p->NAMA_PRODUK }}">
                            <span class="prod-cat-tag">{{ $p->kategori->NAMA_KATEGORI ?? 'Umum' }}</span>
                            @if($p->DISKON_PERSEN > 0)
                            <span class="prod-disc-tag">−{{ $p->DISKON_PERSEN }}%</span>
                            @endif
                        </div>
                        <div class="prod-body">
                            <a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="prod-name">{{ $p->NAMA_PRODUK }}</a>
                            @php
                                $rating = $p->rata_rata_rating ?? 0;
                                $full   = floor($rating);
                                $half   = ($rating - $full) >= 0.5;
                            @endphp
                            <div class="prod-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $full)★@elseif($i == $full + 1 && $half)⯨@else<span>★</span>@endif
                                @endfor
                                <span>({{ number_format($rating, 1) }})</span>
                            </div>
                            <p class="prod-desc">{{ Str::limit($p->DESKRIPSI, 80) }}</p>
                            <div>
                                @if($p->DISKON_PERSEN > 0)
                                <div class="prod-price-orig">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</div>
                                <div class="prod-price disc">Rp {{ number_format($p->harga_setelah_diskon, 0, ',', '.') }}</div>
                                @else
                                <div class="prod-price">Rp {{ number_format($p->HARGA, 0, ',', '.') }}</div>
                                @endif
                            </div>
                            <a href="{{ route('katalog.show', $p->ID_PRODUK) }}" class="btn-detail">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-wrap">
                        <div class="empty-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                        </div>
                        <h5>Produk tidak ditemukan</h5>
                        <p>Coba kata kunci lain atau lihat semua koleksi kami.</p>
                        <a href="{{ route('katalog.index') }}" class="btn-back">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                            </svg>
                            Lihat Semua Produk
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            @if($produk->hasPages())
            <div style="margin-top:2rem;display:flex;justify-content:center;">
                {{ $produk->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>

    </div>
</div>

@endsection