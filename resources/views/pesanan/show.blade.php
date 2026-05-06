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
                                <td>Rp {{ number_format($d->HARGA_SATUAN, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $d->JUMLAH }}</td>
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
                    </div>
                    <div class="col-md-6 text-right">
                        <p><b>Subtotal Produk:</b> Rp {{ number_format($pesanan->SUBTOTAL_PRODUK, 0, ',', '.') }}</p>
                        <p><b>Ongkos Kirim:</b> Rp {{ number_format($pesanan->BIAYA_PENGIRIMAN, 0, ',', '.') }}</p>
                        <h4 class="text-primary">Total: Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</h4>
                    </div>
                </div>
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

                    <div class="form-group">
                        <label>Input No. Resi</label>
                        <input type="text" class="form-control" name="resi" value="{{ $pesanan->RESI_PENGIRIMAN }}" placeholder="Contoh: JNE12345678">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">Update Pesanan</button>
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary btn-block mt-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection