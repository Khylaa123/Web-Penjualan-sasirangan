@extends('layouts.admin')

@section('title', 'Dashboard Statistik')

@section('content')

<div class="admin-banner mb-4">
    <div class="banner-overlay">
        <h2>Mellisari Sasirangan</h2>
        <p>Sistem Manajemen Penjualan dan Inventori</p>
    </div>
</div>

<div class="dashboard-header mb-4">
    <h2>Dashboard Mellisari Sasirangan</h2>
    <p>Ringkasan penjualan dan aktivitas toko hari ini</p>
</div>

{{-- ===================== CARD ATAS ===================== --}}
<div class="row">

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 dashboard-card">
            <div class="card-icon bg-brown"><i class="fas fa-money-bill-wave"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Omset Penjualan</h4></div>
                <div class="card-body">Rp {{ number_format($total_omset, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 dashboard-card">
            <div class="card-icon bg-navy"><i class="fas fa-shopping-basket"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Pesanan Baru</h4></div>
                <div class="card-body">{{ $pesanan_baru }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 dashboard-card">
            <div class="card-icon bg-navy"><i class="fas fa-tshirt"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Produk</h4></div>
                <div class="card-body">{{ $total_produk }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 dashboard-card">
            <div class="card-icon bg-gold"><i class="fas fa-shopping-cart"></i></div>
            <div class="card-wrap">
                <div class="card-header"><h4>Total Pesanan</h4></div>
                <div class="card-body">{{ $total_pesanan }}</div>
            </div>
        </div>
    </div>

    {{-- ===================== 🔥 INVENTORY BARU ===================== --}}

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 dashboard-card">
            <div class="card-icon bg-success">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header"><h4>Nilai Inventory</h4></div>
                <div class="card-body">
                    Rp {{ number_format($total_inventory, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 dashboard-card">
            <div class="card-icon bg-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header"><h4>Stok Kritis</h4></div>
                <div class="card-body">
                    {{ $stok_menipis_inventory }}
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ===================== GRAFIK ===================== --}}
<div class="row">

    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Grafik Status Pesanan (Batang)</h4>
            </div>
            <div class="card-body">
                <canvas id="myChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Produk per Kategori (Bundaran)</h4>
            </div>
            <div class="card-body">
                <canvas id="myPieChart" height="260"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ===================== TABLE ===================== --}}
<div class="row">

    <div class="col-lg-7">
        <div class="card shadow border-0">

            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Stok Hampir Habis
                </h4>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">

                        <tr>
                            <th>Produk</th>
                            <th>Sisa Stok</th>
                            <th>Aksi</th>
                        </tr>

                        @forelse($stok_menipis as $stok)
                        <tr>
                            <td>{{ $stok->NAMA_PRODUK }}</td>
                            <td>
                                <span class="badge badge-danger">
                                    {{ $stok->STOK }} Pcs
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('riwayat-stok.create') }}" class="btn btn-sm btn-primary">
                                    Isi Stok
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-success">
                                <i class="fas fa-check-circle"></i> Stok aman semua!
                            </td>
                        </tr>
                        @endforelse

                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">

            <div class="card-header">
                <h4>Produk Terbaru</h4>
            </div>

            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">

                    @forelse($produk_terbaru as $baru)
                    <li class="media">
                        <img class="mr-3 rounded shadow-sm" width="50"
                             src="{{ asset('uploads/produk/' . $baru->GAMBAR_UTAMA) }}">
                        <div class="media-body">
                            <div class="float-right text-primary">Baru</div>
                            <div class="media-title">{{ $baru->NAMA_PRODUK }}</div>
                            <span class="text-small text-muted">
                                Rp {{ number_format($baru->HARGA, 0, ',', '.') }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="media">
                        <div class="media-body text-center">Belum ada produk.</div>
                    </li>
                    @endforelse

                </ul>
            </div>

        </div>
    </div>

</div>

{{-- ===================== CHART ===================== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
var ctx = document.getElementById("myChart").getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Menunggu Bayar", "Diproses", "Dikirim", "Selesai", "Dibatalkan"],
        datasets: [{
            label: 'Jumlah Pesanan',
            data: <?php echo json_encode($data_grafik_pesanan); ?>,
            backgroundColor: ['#ffa426','#6777ef','#3abaf4','#47c363','#fc544b']
        }]
    }
});

var ctxPie = document.getElementById("myPieChart").getContext('2d');
new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($label_kategori); ?>,
        datasets: [{
            data: <?php echo json_encode($data_kategori); ?>,
            backgroundColor: ['#6777ef','#fc544b','#47c363','#ffa426','#3abaf4']
        }]
    }
});
</script>

@endsection