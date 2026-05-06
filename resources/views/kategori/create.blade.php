@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Form Tambah Kategori</h4>
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

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="NAMA_KATEGORI" class="form-control" required placeholder="Misal: Pakaian Pria, Kain Lembaran, dll">
            </div>

            <button type="submit" class="btn btn-success">Simpan Kategori</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection