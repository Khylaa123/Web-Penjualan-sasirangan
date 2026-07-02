@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Tambah Produk</h4>
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

        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="NAMA_PRODUK" class="form-control" required placeholder="Misal: Kain Sasirangan Bayam">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="ID_KATEGORI" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->ID_KATEGORI }}">{{ $kat->NAMA_KATEGORI }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea name="DESKRIPSI" class="form-control" style="height: 100px;" required placeholder="Jelaskan detail kain di sini..."></textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Berat (Gram)</label>
                        <input type="number" name="BERAT_GRAM" class="form-control" required placeholder="Misal: 500">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="HARGA" class="form-control" required placeholder="Misal: 150000">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Diskon (%)</label>
                        <input type="number" name="DISKON_PERSEN" class="form-control" min="0" max="100" value="0" placeholder="Misal: 10">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Stok Awal</label>
                        <input type="number" name="STOK" class="form-control" required placeholder="Misal: 50">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="STATUS_AKTIF" class="form-control" required>
                            <option value="1">Aktif (Dijual)</option>
                            <option value="0">Draft (Disembunyikan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gambar Utama</label>
                        <input type="file" name="GAMBAR_UTAMA" class="form-control" accept="image/*" required>
                    </div>
                </div>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> <b>Catatan:</b> Kode Produk (SKU) akan dibuat secara otomatis oleh sistem setelah Anda menyimpan data ini.
            </div>

            <button type="submit" class="btn btn-primary">Simpan Produk</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection