@extends('layouts.admin')

@section('title', 'Inventory Barang')

@section('content')

<div class="row">

    {{-- TOTAL BARANG --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Barang</h4>
                </div>
                <div class="card-body">
                    {{ $total_produk }}
                </div>
            </div>
        </div>
    </div>

    {{-- TOTAL STOK --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-cubes"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Stok</h4>
                </div>
                <div class="card-body">
                    {{ $total_stok }}
                </div>
            </div>
        </div>
    </div>

    {{-- STOK MENIPIS --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Stok Menipis</h4>
                </div>
                <div class="card-body">
                    {{ $stok_menipis }}
                </div>
            </div>
        </div>
    </div>

    {{-- NILAI INVENTORY --}}
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-info">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Nilai Inventory</h4>
                </div>
                <div class="card-body">
                    Rp {{ number_format($nilai_inventory, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

</div>

{{-- HEADER --}}
<div class="card mt-4">
    <div class="card-header">
        <h4>Daftar Inventory Barang</h4>

       <div class="card-header-action">

        <!-- Tombol Export PDF -->
        <a href="{{ route('inventory.pdf') }}" class="btn btn-success mb-2">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>

        <!-- Tombol Input Barang -->
        <a href="{{ route('produk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Input Barang Baru
        </a>

    </div>
    </div>

    <div class="card-body">

        {{-- INFO --}}
        <div class="alert alert-info">
            <b>Catatan:</b> Inventory hanya untuk monitoring & hapus barang. Tidak ada fitur edit sesuai aturan dosen.
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($produk as $item)
                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        {{-- FOTO --}}
                        <td>
                            @if($item->GAMBAR_UTAMA)
                                <img src="{{ asset('uploads/produk/' . $item->GAMBAR_UTAMA) }}"
                                    width="50" height="50"
                                    style="object-fit:cover;border-radius:8px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- KODE --}}
                        <td>
                            <span class="badge badge-light">
                                {{ $item->KODE_PRODUK }}
                            </span>
                        </td>

                        {{-- NAMA --}}
                        <td>
                            <b>{{ $item->NAMA_PRODUK }}</b>
                        </td>

                        {{-- KATEGORI --}}
                        <td>
                            {{ $item->kategori->NAMA_KATEGORI ?? '-' }}
                        </td>

                        {{-- HARGA --}}
                        <td class="text-success">
                            Rp {{ number_format($item->HARGA, 0, ',', '.') }}
                        </td>

                        {{-- STOK (WARNA OTOMATIS) --}}
                        <td>
                            @php $stok = $item->STOK; @endphp

                            @if($stok <= 0)
                                <span class="badge badge-danger">0 pcs</span>
                            @elseif($stok <= 10)
                                <span class="badge badge-warning text-dark">{{ $stok }} pcs</span>
                            @else
                                <span class="badge badge-success">{{ $stok }} pcs</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if($item->STATUS_AKTIF == 1)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>

                        {{-- ACTION (ONLY DELETE - NO EDIT) --}}
                        <td>
                            <form action="{{ route('inventory.destroy', $item->ID_PRODUK) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus barang ini?')">

                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>
                        </td>

                    </tr>
                    @empty

                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Tidak ada data inventory
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection