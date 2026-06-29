@extends('layouts.admin') @section('title', 'Kategori Produk') @section('content')
<div class="card">
    <div class="card-header">
        <h4>Daftar Kategori</h4>
        <div class="card-header-action">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Icon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->NAMA_KATEGORI }}</td>
                        <td><i class="fas {{ $item->ICON }}"></i> {{ $item->ICON }}</td>
                        <td>
                            <a href="{{ route('kategori.edit', $item->ID_KATEGORI) }}" class="btn btn-warning btn-sm">Edit</a>

                            @if(auth()->user()->role == 'Admin')
                                <form action="{{ route('kategori.destroy', $item->ID_KATEGORI) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini? Data produk di dalamnya mungkin ikut terpengaruh lho!')">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection