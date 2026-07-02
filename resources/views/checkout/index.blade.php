@extends('layouts.front')

@section('content')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Checkout</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('keranjang.index') }}">Keranjang</a></li>
        <li class="breadcrumb-item active text-white">Checkout</li>
    </ol>
</div>

<div class="container py-5">
    <form id="checkout-form" action="{{ route('checkout.proses') }}" method="POST">
        @csrf
        <div class="row g-5">
            
            <div class="col-lg-7">
                <div class="checkout-card">
                    <h3 class="mb-4">Detail Pengiriman</h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Depan</label>
                            <input type="text" name="nama_depan" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Belakang</label>
                            <input type="text" name="nama_belakang" class="form-control">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Metode Pengiriman</label>
                        <select name="id_pengiriman" id="id_pengiriman" class="form-control" required>
                            <option value="" data-biaya="0">-- Pilih Metode Pengiriman --</option>
                            <option value="1" data-biaya="0">Ambil Sendiri - Ambil Langsung di Toko (Rp 0)</option>
                            <option value="2" data-biaya="10000">COD - Bayar di Tempat (Rp 10.000)</option>
                            <option value="3" data-biaya="15000">Kurir / JNE - Paket Regular Flat Rate (Rp 15.000)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Catatan Pesanan</label>
                        <textarea name="catatan_pesanan" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-card">
                    <h3 class="mb-4">Ringkasan Pesanan</h3>
                    
                    @php
                        $total = 0;
                        $ongkir = 0; // Default diubah awal ke 0 mengikuti keadaan awal sebelum pilih dropdown
                    @endphp
                    
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $item)
                            @php
                                $total += $item['harga'] * $item['jumlah'];
                            @endphp
                            <div class="checkout-item mb-3">
                                <img src="{{ asset('storage/' . $item['gambar']) }}"
                                     width="70" height="70"
                                     style="object-fit:cover; border-radius:10px;">
                                <div>
                                    <h6 class="mb-1">{{ $item['nama_produk'] }}</h6>
                                    <small>
                                        {{ $item['jumlah'] }} x Rp {{ number_format($item['harga'],0,',','.') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Rp <span id="display_subtotal">{{ number_format($total,0,',','.') }}</span></strong>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <strong>Rp <span id="display_ongkir">{{ number_format($ongkir,0,',','.') }}</span></strong>
                    </div>
                    <hr>
                    
                    <div class="d-flex justify-content-between fs-5">
                        <strong>Total Keseluruhan</strong>
                        <strong class="text-primary">
                            Rp <span id="display_total">{{ number_format($total + $ongkir, 0, ',', '.') }}</span>
                        </strong>
                    </div>
                    
                    <div class="mt-4">
                        <label>Kode Voucher</label>
                        <div class="input-group">
                            <input type="text" name="kode_voucher" class="form-control" placeholder="Masukkan Voucher">
                            <button type="button" class="btn btn-warning">Terapkan</button>
                        </div>
                    </div>
                    
                    <button type="submit" id="btn-bayar" class="btn btn-checkout w-100 mt-4">
                        Lanjut ke Pembayaran
                    </button>
                    
                </div>
            </div>
            
        </div>
    </form>
</div>

<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- PROSES 1: PERUBAHAN ANGKA ONGKIR DI LAYARSecara REALTIME ---
        const selectPengiriman = document.getElementById('id_pengiriman');
        const displayOngkir = document.getElementById('display_ongkir');
        const displayTotal = document.getElementById('display_total');
        const displaySubtotal = document.getElementById('display_subtotal');

        if (selectPengiriman) {
            selectPengiriman.addEventListener('change', function () {
                let selectedOption = this.options[this.selectedIndex];
                let biayaOngkir = parseInt(selectedOption.getAttribute('data-biaya')) || 0;

                let subtotalText = displaySubtotal.innerText;
                let subtotal = parseInt(subtotalText.replace(/\D/g, '')) || 0;

                let totalAkhir = subtotal + biayaOngkir;

                displayOngkir.innerText = biayaOngkir.toLocaleString('id-ID');
                displayTotal.innerText = totalAkhir.toLocaleString('id-ID');
            });
        }

        // --- PROSES 2: AJAX SUBMIT KE SERVER ---
        const formCheckout = document.getElementById('checkout-form');
        const btnBayar = document.getElementById('btn-bayar');
        if (formCheckout) {
            formCheckout.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                btnBayar.disabled = true;
                btnBayar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses Pembayaran...';
                
                const formData = new FormData(formCheckout);
                
                fetch('/checkout/proses', {
                    method: 'POST',
                    headers: {
<<<<<<< HEAD
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
=======
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    // Sekarang mengonversi seluruh input data form (termasuk id_pengiriman) menjadi JSON ke server
                    body: JSON.stringify(Object.fromEntries(formData)) 
>>>>>>> 8ea2df5af7b9939347e9f9b7c1211e01aa3913c3
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                window.location.href = data.redirect_url;
                            },
                            onPending: function(result) {
                                window.location.href = data.redirect_url;
                            },
                            onError: function(result) {
                                alert("Pembayaran Gagal");
                                btnBayar.disabled = false;
                                btnBayar.innerHTML = 'Lanjut ke Pembayaran';
                            }
                        });
                    } else {
                        alert(data.message);
                        btnBayar.disabled = false;
                        btnBayar.innerHTML = 'Lanjut ke Pembayaran';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses checkout.');
                    btnBayar.disabled = false;
                    btnBayar.innerHTML = 'Lanjut ke Pembayaran';
                });
            });
        }
    });
</script>
@endsection