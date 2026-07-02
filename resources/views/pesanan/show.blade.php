@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $pesanan->ID_PESANAN)

@section('content')
<div class="row">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Produk yang Dipesan</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan->detail as $d)
                            <tr>
                                <td>{{ $d->produk->NAMA_PRODUK }}</td>
                                <td>Rp {{ number_format($d->HARGA_SAAT_BELI, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $d->JUMLAH_BELI }}</td>
                                <td class="text-right">Rp {{ number_format($d->SUBTOTAL, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Alamat Pengiriman:</h6>
                        <p>{{ $pesanan->user->name }}<br>Alamat: (Data dari tabel pengiriman)</p>
                        
                        <h6 class="mt-3">Metode Pengiriman:</h6>
                        <p>
                            <span class="badge badge-info text-uppercase" style="font-size: 0.9rem; padding: 6px 12px;">
                                <i class="fas fa-truck"></i> {{ $pesanan->pengiriman->NAMA_KURIR ?? 'Ambil Sendiri' }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><b>Subtotal Produk:</b> Rp {{ number_format($pesanan->SUBTOTAL_PRODUK, 0, ',', '.') }}</p>
                        <p><b>Ongkos Kirim:</b> Rp {{ number_format($pesanan->BIAYA_PENGIRIMAN, 0, ',', '.') }}</p>
                        <h4 class="text-primary">Total: Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card my-4">
            <div class="card-header bg-dark">
                <h4 class="text-white">Pembayaran Kain Sasirangan (Midtrans)</h4>
            </div>
            <div class="card-body text-center">
                <p class="mb-3">Total Akhir yang Harus Dibayar: <strong class="text-primary" style="font-size: 1.2rem;">Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</strong></p>
                
                @if(Auth::check() && Auth::user()->role === 'Pembeli' && $pesanan->STATUS_PESANAN == 'Menunggu Pembayaran')
                    <div class="alert alert-warning mt-4">
                        <h5>Pembayaran Kain Sasirangan (Midtrans)</h5>
                        <p>Total Akhir yang Harus Dibayar: <strong>Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</strong></p>
                        <button id="pay-button" class="btn btn-success btn-lg">Bayar Sekarang</button>
                    </div>
                @elseif($pesanan->STATUS_PESANAN != 'Menunggu Pembayaran')
                    <div class="alert alert-info mb-0">
                        Status Pesanan saat ini: <strong>{{ $pesanan->STATUS_PESANAN }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Proses Pesanan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.update', $pesanan->ID_PESANAN) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Ubah Status Pesanan</label>
                        <select class="form-control" name="status">
                            <option value="Menunggu Pembayaran" {{ $pesanan->STATUS_PESANAN == 'Menunggu Pembayaran' ? 'selected' : '' }}>Menunggu Bayar</option>
                            <option value="Diproses" {{ $pesanan->STATUS_PESANAN == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Dikirim" {{ $pesanan->STATUS_PESANAN == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="Selesai" {{ $pesanan->STATUS_PESANAN == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $pesanan->STATUS_PESANAN == 'Dibatalkan' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    @php
                        $namaKurir = strtoupper($pesanan->pengiriman->NAMA_KURIR ?? '');
                        // Logika pengecekan apakah metode termasuk kurir ekspedisi
                        $isEkspedisi = ($pesanan->ID_PENGIRIMAN == 3) || in_array($namaKurir, ['JNE', 'J&T', 'KURIR / JNE', 'EKSPEDISI']);
                    @endphp

                    <div class="form-group">
                        <label>Input No. Resi</label>
                        {{-- Jika ekspedisi, admin wajib input resi. Jika instan/ambil sendiri, otomatis diisi TANPA-RESI dan di-lock (readonly) --}}
                        <input type="text" 
                               class="form-control" 
                               name="resi" 
                               value="{{ $isEkspedisi ? $pesanan->RESI_PENGIRIMAN : 'TANPA-RESI' }}" 
                               {{ $isEkspedisi ? '' : 'readonly' }}
                               placeholder="{{ $isEkspedisi ? 'Contoh: JNE12345678' : 'Otomatis Tanpa Resi untuk Kurir Instan' }}">
                        @if(!$isEkspedisi)
                            <small class="text-muted d-block mt-1">*Metode non-ekspedisi tidak memerlukan input resi.</small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">Update Pesanan</button>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary btn-block mt-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        const payButton = document.getElementById('pay-button');
        const snapTokenFromSession = "{{ session('snapToken') }}";
        const snapTokenFromDatabase = "{{ $snapToken ?? ($pesanan->pembayaran->SNAP_TOKEN ?? '') }}";
        
        function triggerMidtransSnap(token) {
            if (!token) return;

            window.snap.pay(token, {
                onSuccess: function(result) {
                    alert("Pembayaran Berhasil! Pesanan segera diproses.");
                    window.location.href = "{{ route('pesanan.index') }}"; 
                },
                onPending: function(result) {
                    alert("Menunggu Pembayaran. Harap segera selesaikan transaksi.");
                    window.location.reload(); 
                },
                onError: function(result) {
                    alert("Pembayaran Gagal! Silakan coba lagi.");
                },
                onClose: function() {
                    alert('Halaman pembayaran ditutup sebelum transaksi diselesaikan.');
                }
            });
        }

        if (snapTokenFromSession) {
            triggerMidtransSnap(snapTokenFromSession);
        }

        if (payButton) {
            payButton.addEventListener('click', function (e) {
                e.preventDefault();
                const tokenAktif = snapTokenFromDatabase || snapTokenFromSession;
                
                if (tokenAktif) {
                    triggerMidtransSnap(tokenAktif);
                } else {
                    alert('Token pembayaran tidak ditemukan. Silakan pastikan data checkout valid.');
                }
            });
        }
    });
</script>
@endsection