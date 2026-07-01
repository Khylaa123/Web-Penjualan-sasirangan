@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Edit Produk</h4>
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

        <form action="{{ route('produk.update', $produk->ID_PRODUK) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-4">
                <label>Kode Produk</label>
                <input type="text" class="form-control" value="{{ $produk->KODE_PRODUK }}" readonly style="background-color: #e9ecef; font-weight: bold;">
                <small class="text-muted">Kode produk dibuat otomatis oleh sistem dan tidak dapat diubah.</small>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="NAMA_PRODUK" class="form-control" required value="{{ $produk->NAMA_PRODUK }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="ID_KATEGORI" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->ID_KATEGORI }}" {{ $produk->ID_KATEGORI == $kat->ID_KATEGORI ? 'selected' : '' }}>
                                    {{ $kat->NAMA_KATEGORI }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea name="DESKRIPSI" class="form-control" style="height: 100px;" required>{{ $produk->DESKRIPSI }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Berat (Gram)</label>
                        <input type="number" name="BERAT_GRAM" class="form-control" required value="{{ $produk->BERAT_GRAM }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="HARGA" class="form-control" required value="{{ number_format($produk->HARGA, 0, '', '') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Diskon (%)</label>
                        <input type="number" name="DISKON_PERSEN" class="form-control" min="0" max="100" value="{{ $produk->DISKON_PERSEN ?? 0 }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Stok Tersedia</label>
                        <input type="number" name="STOK" class="form-control" required value="{{ $produk->STOK }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="STATUS_AKTIF" class="form-control" required>
                            <option value="1" {{ $produk->STATUS_AKTIF == 1 ? 'selected' : '' }}>Aktif (Dijual)</option>
                            <option value="0" {{ $produk->STATUS_AKTIF == 0 ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ganti Gambar (Opsional)</label>
                        <input type="file" name="GAMBAR_UTAMA" class="form-control" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Produk</button>
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection