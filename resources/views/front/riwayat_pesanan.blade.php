@extends('layouts.front')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Riwayat Pesanan</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item active text-white">Pesanan Saya</li>
    </ol>
</div>

<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="card shadow-sm border-0 rounded">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="mb-0 text-dark fw-bold">Daftar Transaksi Anda</h4>
            </div>
            <div class="card-body p-4">
                
                @if($pesanan->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tanggal Pesan</th>
                                <th>Total Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th>No. Resi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $item)
                            <tr>
                                <td class="fw-bold text-dark">#{{ $item->ID_PESANAN }}</td>
                                <td>{{ date('d M Y, H:i', strtotime($item->TANGGAL_PESAN)) }}</td>
                                <td class="fw-bold text-primary">Rp {{ number_format($item->TOTAL_AKHIR, 0, ',', '.') }}</td>
                                <td>
                                    @if($item->STATUS_PESANAN == 'Menunggu Pembayaran')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Pembayaran</span>
                                    @elseif($item->STATUS_PESANAN == 'Diproses')
                                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill">Diproses</span>
                                    @elseif($item->STATUS_PESANAN == 'Dikirim')
                                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Dikirim</span>
                                    @elseif($item->STATUS_PESANAN == 'Selesai')
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">Selesai</span>
                                    @else
                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Dibatalkan</span>
                                    @endif
                                </td>
                                <td><span class="text-muted">{{ $item->RESI_PENGIRIMAN ?? '-' }}</span></td>
                                <td>
                                    <a href="{{ route('riwayat.detail', $item->ID_PESANAN) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="fa fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fa fa-box-open text-muted mb-3" style="font-size: 60px; opacity: 0.5;"></i>
                    <h5 class="text-muted">Anda belum memiliki riwayat pesanan.</h5>
                    <a href="{{ route('katalog.index') }}" class="btn btn-primary rounded-pill px-4 py-2 mt-3 text-white">Belanja Sekarang</a>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection