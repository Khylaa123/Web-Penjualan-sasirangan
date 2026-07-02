@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="text-primary"><i class="fas fa-edit mr-2"></i> Form Edit Kategori</h4>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('kategori.update', $kategori->ID_KATEGORI) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="NAMA_KATEGORI" class="form-control @error('NAMA_KATEGORI') is-invalid @enderror" value="{{ old('NAMA_KATEGORI', $kategori->NAMA_KATEGORI) }}" required placeholder="Misal: Pakaian Pria, Kain Lembaran, dll">
            </div>

            <div class="form-group">
                <label>Icon Kategori (Opsional)</label>
                <input type="text" name="ICON" class="form-control" value="{{ old('ICON', $kategori->ICON) }}" placeholder="Misal: fa-tshirt, fa-tag">
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Gunakan class dari <a href="https://fontawesome.com/v5/search?m=free" target="_blank">FontAwesome</a> (contoh: <code>fa-tshirt</code>, <code>fa-tags</code>). Kosongkan jika tidak perlu.
                </small>
            </div>

            <div class="text-right">
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection