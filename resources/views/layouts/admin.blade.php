<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') &mdash; Mellisari Shop</title>

  <link rel="stylesheet" href="{{ asset('stisla/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/modules/fontawesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/css/components.css') }}">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('stisla/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Halo, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('profile.edit') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              <div class="dropdown-divider"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Logout
                </a>
              </form>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Mellisari Shop</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">MS</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>

            <li class="menu-header">Data Master</li>
            <li class="{{ Request::is('kategori*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('kategori.index') }}"><i class="fas fa-list"></i> <span>Kategori Produk</span></a>
            </li>
            <li class="{{ Request::is('produk*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('produk.index') }}"><i class="fas fa-tshirt"></i> <span>Produk Kain</span></a>
            </li>
            <li class="{{ Request::is('riwayat-stok*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('riwayat-stok.index') }}"><i class="fas fa-boxes"></i> <span>Kelola Stok</span></a>
            </li>
            <li class="{{ Request::is('pengguna*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('users.index') }}"><i class="fas fa-users"></i> <span>Manajemen Pengguna</span></a>
            </li>
<li class="{{ Request::is('admin/voucher*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('voucher.index') }}">
        <i class="fas fa-ticket-alt"></i> <span>Manajemen Voucher</span>
    </a>
</li>
            <li class="menu-header">Transaksi</li>
            <li class="{{ Request::is('pesanan*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('pesanan.index') }}"><i class="fas fa-shopping-cart"></i> <span>Data Pesanan</span></a>
            </li>

            <li class="menu-header">Laporan</li>
            <li class="{{ Request::is('laporan*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('laporan.index') }}"><i class="fas fa-print"></i> <span>Laporan Penjualan</span></a>
            </li>
          </ul>
        </aside>
      </div>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>@yield('title')</h1>
          </div>
          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2026 <div class="bullet"></div> Sistem E-Commerce Mellisari
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('stisla/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('stisla/modules/popper.js') }}"></script>
  <script src="{{ asset('stisla/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('stisla/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('stisla/js/stisla.js') }}"></script>
  <script src="{{ asset('stisla/js/scripts.js') }}"></script>
  
  @stack('scripts')
</body>
</html>