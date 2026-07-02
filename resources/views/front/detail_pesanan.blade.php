@extends('layouts.front')

@section('title', 'Detail Pesanan #' . $pesanan->ID_PESANAN)

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Detail Pesanan</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('riwayat.pesanan') }}">Pesanan Saya</a></li>
        <li class="breadcrumb-item active text-white">#{{ $pesanan->ID_PESANAN }}</li>
    </ol>
</div>

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold">Item yang Dipesan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Harga Satuan</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pesanan->detail as $det)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . ($det->produk->GAMBAR_UTAMA ?? 'default.jpg')) }}" 
                                                     class="img-fluid rounded me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;" 
                                                     alt="{{ $det->produk->NAMA_PRODUK ?? 'Produk' }}">
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $det->produk->NAMA_PRODUK ?? 'Produk Tidak Diketahui' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($det->HARGA_SAAT_BELI, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $det->JUMLAH_BELI }}</td>
                                        <td class="text-end fw-bold text-dark">Rp {{ number_format($det->SUBTOTAL, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold">Informasi Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="text-muted d-block small">Nama Penerima</span>
                                <span class="fw-bold text-dark">{{ $pesanan->user->name ?? '-' }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="text-muted d-block small">No. WhatsApp</span>
                                <span class="fw-bold text-dark">{{ $pesanan->user->no_whatsapp ?? '-' }}</span>
                            </div>
                            <div class="col-12">
                                <span class="text-muted d-block small">Alamat Lengkap</span>
                                <span class="text-dark">{{ $pesanan->user->alamat_lengkap ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 position-sticky" style="top: 20px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold">Ringkasan Total</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Status Pesanan:</span>
                            <span class="badge bg-info text-white">{{ $pesanan->STATUS_PESANAN }}</span>
                        </div>
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">No. Resi Pengiriman:</span>
                            <span class="fw-bold text-dark">{{ $pesanan->RESI_PENGIRIMAN ?? '-' }}</span>
                        </div>
                        <hr>
                        <div class="mb-2 d-flex justify-content-between">
                            <span class="text-muted">Subtotal Produk:</span>
                            <span>Rp {{ number_format($pesanan->SUBTOTAL_PRODUK, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Biaya Pengiriman:</span>
                            <span>Rp {{ number_format($pesanan->BIAYA_PENGIRIMAN, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-dark">Total Akhir:</h5>
                            <h4 class="mb-0 fw-bold text-primary">Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</h4>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('pesanan.invoice', $pesanan->ID_PESANAN) }}" target="_blank" class="btn btn-primary text-white rounded-pill w-100 mb-2">
                                <i class="fa fa-print me-2"></i> Cetak Invoice (PDF)
                            </a>
                            <a href="{{ route('riwayat.pesanan') }}" class="btn btn-outline-secondary rounded-pill w-100">Kembali ke Riwayat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection