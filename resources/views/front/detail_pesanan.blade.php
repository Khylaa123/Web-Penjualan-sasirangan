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
                                    @foreach($pesanan->detail as $d)
                                    <tr>
                                        <td>
                                            <span class="fw-bold text-dark">{{ $d->produk->NAMA_PRODUK ?? 'Produk Dihapus' }}</span>
                                        </td>
                                        <td>Rp {{ number_format($d->HARGA_SAAT_BELI, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $d->JUMLAH_BELI }} Meter</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($d->SUBTOTAL, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold">Ringkasan Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <span class="text-muted">Status:</span>
                            <span class="fw-bold text-primary">{{ $pesanan->STATUS_PESANAN }}</span>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
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
                            <a href="{{ route('riwayat.pesanan') }}" class="btn btn-outline-secondary rounded-pill w-100">Kembali ke Riwayat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection