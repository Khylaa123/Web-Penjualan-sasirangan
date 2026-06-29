@extends('layouts.front')
@section('title', 'Profil Saya')
@section('content')

<div class="container py-5 profile-page">
       <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 profile-card">
            <div class="profile-header">
                <div class="profile-overlay">
                    <img src="{{ asset('front/img/logo-mellisari.png') }}"
                    class="profile-logo"
                    alt="Mellisari">
                    <h2 class="mt-3 fw-bold text-white">
                        {{ Auth::user()->name }}
                    </h2>
                    <p class="text-white">
                        {{ Auth::user()->email }}
                    </p>
                    </div>
                    </div>
                    <div class="card-body p-5">
                       <div class="row text-center py-4 justify-content-center g-4"> 
                    <div class="col-md-5">
                        <div class="profile-stat-card">
                            <h2 class="fw-bold">0</h2>
                            <p class="text-muted mb-0">Pesanan</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="profile-stat-card">
                            <h2 class="fw-bold">0</h2>
                            <p class="text-muted mb-0">Keranjang</p>
                        </div>
                    </div>
                    </div>
                    <hr>
                    <div class="row text-center mt-4">
                    <div class="row text-center mt-4 justify-content-center g-4">
                    <div class="col-md-5">
                        <h6>Status Akun</h6>
                        <span class="badge bg-success">Aktif</span>
                    </div>
                    <div class="col-md-5">
                        <h6>Member Sejak</h6>
                        <p>{{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>
                    </div>
                    <div class="profile-action text-center mt-5">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>
                            Edit Profil
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-box me-2"></i>
                            Pesanan Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="text-center mt-2">
   ...
</div>

<div class="text-center mt-3">
    <form method="POST" action="{{ route('logout') }}">  
        <button type="submit"
                class="btn btn-danger rounded-pill px-5">
            <i class="fas fa-sign-out-alt me-2"></i>
            Logout
        </button>
    </form>
</div>

@endsection