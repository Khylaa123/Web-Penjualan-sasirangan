<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - Mellisari Sasirangan</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('front/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('front/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #8C8C8C !important; /* Silver */
            --bs-secondary: #333333 !important; /* Dark Elegant */
        }
        .text-primary, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { color: #333333 !important; }
        .text-secondary { color: #8C8C8C !important; }
        .bg-primary { background-color: #8C8C8C !important; }
        .bg-secondary { background-color: #333333 !important; }
        .navbar .navbar-nav .nav-link:hover, .navbar .navbar-nav .nav-link.active { color: #8C8C8C !important; }
        .btn-primary { background-color: #8C8C8C !important; border-color: #8C8C8C !important; color: white !important;}
        .btn-primary:hover { background-color: #595959 !important; border-color: #595959 !important; }
        .btn-outline-primary { border-color: #8C8C8C !important; color: #8C8C8C !important; }
        .btn-outline-primary:hover { background-color: #8C8C8C !important; color: white !important; }
        .footer { background-color: #2b2b2b !important; }
    </style>
</head>

<body>

    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-secondary" role="status"></div>
    </div>
    <div class="container-fluid fixed-top">
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="{{ url('/') }}" class="navbar-brand"><h1 class="text-primary display-6">Mellisari</h1></a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ url('/') }}" class="nav-item nav-link active">Beranda</a>
                        <a href="#" class="nav-item nav-link">Katalog</a>
                        <a href="#" class="nav-item nav-link">Tentang Kami</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <a href="{{ route('keranjang.index') }}"
                           class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white px-1"
                                style="top:-5px;left:15px;height:20px;min-width:20px;">
                               {{ session('cart') ? collect(session('cart'))->sum('jumlah') : 0 }}
                            </span>
                        </a>
                       @auth
                        <a href="{{ route('pelanggan.profile') }}" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                        @endauth
                        @guest
                        <a href="{{ route('login') }}" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                        @endguest 
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div style="min-height: 70vh; margin-top: 20px;">
        @yield('content')
    </div>

    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Mellisari Sasirangan</h4>
                        <p class="mb-4">Menyediakan berbagai motif kain Sasirangan khas Kalimantan Selatan dengan kualitas terbaik dan harga terjangkau.</p>
                        <a href="" class="btn btn-primary py-2 px-4 rounded-pill text-white">Hubungi Kami</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 text-md-end">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Kontak Info</h4>
                        <p>Alamat: Jl. Banjarmasin No. 123, Kalsel</p>
                        <p>Email: info@mellisari.com</p>
                        <p>Telepon: +62 812 3456 7890</p>
                        <div class="d-flex justify-content-md-end pt-2">
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Mellisari E-Commerce</a>, All right reserved.</span>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   
<script src="{{ asset('front/js/main.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    if(nextBtn){
        nextBtn.addEventListener('mouseenter', function () {
            this.click();
        });
    }

    if(prevBtn){
        prevBtn.addEventListener('mouseenter', function () {
            this.click();
        });
    }

});
</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('front/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('front/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('front/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('front/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>