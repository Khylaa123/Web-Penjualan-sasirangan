@extends('layouts.admin')

@section('title', 'Data Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Daftar Produk Kain</h4>
        <div class="card-header-action">
            <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
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
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->GAMBAR_UTAMA)
                                <img src="{{ asset('uploads/produk/' . $item->GAMBAR_UTAMA) }}" alt="Foto" width="50" style="border-radius: 5px;">
                            @else
                                <span class="text-danger">Kosong</span>
                            @endif
                        </td>
                        <td><span class="badge badge-light" style="font-family: monospace; font-size: 14px;">{{ $item->KODE_PRODUK }}</span></td>
                        <td>{{ $item->NAMA_PRODUK }}</td>
                        <td>{{ $item->kategori ? $item->kategori->NAMA_KATEGORI : 'Tidak ada' }}</td>
                        
                        <td class="text-success font-weight-bold">Rp {{ number_format($item->HARGA, 0, ',', '.') }}</td>
                        <td>{{ $item->STOK }}</td>
                        
                        <td>
                            @if($item->STATUS_AKTIF == 1)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('produk.edit', $item->ID_PRODUK) }}" class="btn btn-warning btn-sm">Edit</a>

                            @if(auth()->user()->role == 'Admin')
                                <form action="{{ route('produk.destroy', $item->ID_PRODUK) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini? Tindakan ini tidak bisa dibatalkan!')">
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