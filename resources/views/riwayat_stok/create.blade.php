@extends('layouts.admin')

@section('title', 'Catat Stok')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Catat Barang Masuk / Keluar</h4>
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

        <form action="{{ route('riwayat-stok.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Pilih Produk</label>
                <select name="ID_PRODUK" class="form-control select2" required>
                    <option value="">-- Cari Produk --</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->ID_PRODUK }}">{{ $p->KODE_PRODUK }} - {{ $p->NAMA_PRODUK }} (Stok Saat Ini: {{ $p->STOK }})</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe Pergerakan</label>
                        <select name="TIPE_PERGERAKAN" class="form-control" required>
                            <option value="masuk">Barang Masuk (Tambah Stok)</option>
                            <option value="keluar">Barang Keluar / Rusak (Kurangi Stok)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jumlah Barang</label>
                        <input type="number" name="JUMLAH" class="form-control" min="1" required placeholder="Misal: 10">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <textarea name="KETERANGAN" class="form-control" style="height: 100px;" placeholder="Misal: Tambahan stok dari supplier bulan April, atau Barang reject 2 pcs"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan & Update Stok</button>
            <a href="{{ route('riwayat-stok.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection