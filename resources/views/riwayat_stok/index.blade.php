@extends('layouts.admin')

@section('title', 'Kelola Stok')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Riwayat Barang Masuk & Keluar</h4>
        <div class="card-header-action">
            <a href="{{ route('riwayat-stok.create') }}" class="btn btn-primary">Catat Pergerakan Stok</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode & Nama Produk</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Diinput Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                    <tr>
                        <td>{{ date('d M Y, H:i', strtotime($item->TANGGAL)) }}</td>
                        <td>
                            <b>{{ $item->produk ? $item->produk->KODE_PRODUK : 'Dihapus' }}</b><br>
                            {{ $item->produk ? $item->produk->NAMA_PRODUK : '-' }}
                        </td>
                        <td>
                            @if($item->TIPE_PERGERAKAN == 'masuk')
                                <span class="badge badge-success"><i class="fas fa-arrow-down"></i> Masuk</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-arrow-up"></i> Keluar</span>
                            @endif
                        </td>
                        <td class="font-weight-bold {{ $item->TIPE_PERGERAKAN == 'masuk' ? 'text-success' : 'text-danger' }}">
                            {{ $item->TIPE_PERGERAKAN == 'masuk' ? '+' : '-' }}{{ $item->JUMLAH }}
                        </td>
                        <td>{{ $item->KETERANGAN ?? '-' }}</td>
                        <td>{{ $item->user ? $item->user->name : 'Sistem' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection