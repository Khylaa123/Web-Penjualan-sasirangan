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
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                                <td class="fw-bold text-primary">#{{ $item->ID_PESANAN }}</td>
                                <td><span class="text-muted">{{ \Carbon\Carbon::parse($item->TANGGAL_PESANAN)->translatedFormat('d F Y H:i') }}</span></td>
                                <td class="fw-bold text-dark">Rp {{ number_format($item->TOTAL_AKHIR, 0, ',', '.') }}</td>
                                <td>
                                    @if($item->STATUS_PESANAN == 'Belum Bayar')
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Belum Bayar</span>
                                    @elseif($item->STATUS_PESANAN == 'Diproses')
                                        <span class="badge bg-info text-white px-3 py-2 rounded-pill">Diproses</span>
                                    @elseif($item->STATUS_PESANAN == 'Dikirim')
                                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill">Dikirim</span>
                                    @elseif($item->STATUS_PESANAN == 'Selesai')
                                        <span class="badge bg-success text-white px-3 py-2 rounded-pill">Selesai</span>
                                    @else
                                        <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Dibatalkan</span>
                                    @endif
                                </td>
                                <td><span class="text-muted">{{ $item->RESI_PENGIRIMAN ?? '-' }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('riwayat.detail', $item->ID_PESANAN) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                            <i class="fa fa-eye me-1"></i> Detail
                                        </a>
                                        @if($item->STATUS_PESANAN == 'Selesai')
                                            <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 btn-ulasan" data-bs-toggle="modal" data-bs-target="#modalUlasan" data-id="{{ $item->ID_PESANAN }}">
                                                <i class="fa fa-star me-1"></i> Ulas
                                            </button>
                                        @endif
                                    </div>
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

<div class="modal fade" id="modalUlasan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalUlasanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalUlasanLabel"><i class="fa fa-star text-warning me-2"></i>Berikan Ulasan Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetUlasanForm()"></button>
            </div>
            <form action="{{ route('ulasan.store') }}" method="POST" id="form-ulasan-produk">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ID_PESANAN" id="modal-id-pesanan">

                    <div class="text-center mb-4">
                        <label class="form-label d-block text-muted mb-2">Ketuk bintang untuk memberi penilaian</label>
                        <div class="rating-stars fs-2">
                            <i class="far fa-star text-muted star-icon" data-value="1" style="cursor: pointer;"></i>
                            <i class="far fa-star text-muted star-icon" data-value="2" style="cursor: pointer;"></i>
                            <i class="far fa-star text-muted star-icon" data-value="3" style="cursor: pointer;"></i>
                            <i class="far fa-star text-muted star-icon" data-value="4" style="cursor: pointer;"></i>
                            <i class="far fa-star text-muted star-icon" data-value="5" style="cursor: pointer;"></i>
                        </div>
                        <input type="hidden" name="RATING" id="input-rating" value="0">
                        <small class="text-danger d-none" id="error-star">Anda wajib memberikan rating bintang!</small>
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label text-dark fw-bold">Komentar / Ulasan Anda</label>
                        <textarea class="form-control" name="KOMBAR" id="komentar" rows="4" placeholder="Ceritakan pengalaman Anda mengenai produk ini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal" onclick="resetUlasanForm()">Batal</button>
                    <button type="submit" id="btn-submit-ulasan" class="btn btn-primary rounded-pill px-4 text-white">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnUlasan = document.querySelectorAll('.btn-ulasan');
    const modalIdPesanan = document.getElementById('modal-id-pesanan');
    const bintang = document.querySelectorAll('.star-icon');
    const inputRating = document.getElementById('input-rating');

    // 1. Logika memasukkan ID_PESANAN ke modal saat tombol ulas di klik
    btnUlasan.forEach(button => {
        button.addEventListener('click', function() {
            const idPesanan = this.getAttribute('data-id');
            modalIdPesanan.value = idPesanan;
        });
    });

    // 2. Logika Interaktivitas Bintang (Hover dan Klik)
    bintang.forEach(star => {
        // Event Hover Masuk
        star.addEventListener('mouseover', function() {
            const currentVal = this.getAttribute('data-value');
            highlightStars(currentVal);
        });

        // Event Hover Keluar
        star.addEventListener('mouseout', function() {
            const selectedVal = parseInt(inputRating.value);
            highlightStars(selectedVal);
        });

        // Event Klik Bintang
        star.addEventListener('click', function() {
            const clickedVal = this.getAttribute('data-value');
            inputRating.value = clickedVal;
            document.getElementById('error-star').classList.add('d-none');
            highlightStars(clickedVal);
        });
    });

    // Fungsi Pembantu Mewarnai Bintang Emas (fas) atau Kosong (far)
    function highlightStars(val) {
        bintang.forEach(star => {
            const starVal = parseInt(star.getAttribute('data-value'));
            if (starVal <= val) {
                star.classList.remove('far', 'text-muted');
                star.classList.add('fas', 'text-warning');
            } else {
                star.classList.remove('fas', 'text-warning');
                star.classList.add('far', 'text-muted');
            }
        });
    }

    // Fungsi Reset Form Ulasan
    window.resetUlasanForm = function() {
        inputRating.value = "0";
        highlightStars(0);
        document.getElementById('error-star').classList.add('d-none');
        document.getElementById('komentar').value = "";
    }

    // 3. Validasi Form Sebelum Dikirim (Wajib Isi Bintang)
    document.getElementById('btn-submit-ulasan').addEventListener('click', function(e) {
        if(inputRating.value === "0" || inputRating.value === "") {
            e.preventDefault();
            document.getElementById('error-star').classList.remove('d-none');
        }
    });
});
</script>
@endsection