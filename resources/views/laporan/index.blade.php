@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Filter Laporan Penjualan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="row align-items-end mb-4">
            <div class="col-md-4">
                <label>Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" class="form-control" value="{{ $tgl_mulai }}" required>
            </div>
            <div class="col-md-4">
                <label>Tanggal Sampai</label>
                <input type="date" name="tgl_sampai" class="form-control" value="{{ $tgl_sampai }}" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Tampilkan</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-warning"><i class="fas fa-sync"></i> Reset</a>
                
                @if(count($pesanan) > 0)
                <a href="{{ route('laporan.cetak', ['tgl_mulai' => $tgl_mulai, 'tgl_sampai' => $tgl_sampai]) }}" target="_blank" class="btn btn-danger"><i class="fas fa-print"></i> Cetak</a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pesan</th>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Status</th>
                        <th class="text-right">Total Pemasukan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d M Y', strtotime($item->TANGGAL_PESAN)) }}</td>
                        <td>{{ $item->ID_PESANAN }}</td>
                        <td>{{ $item->user->name ?? 'User Dihapus' }}</td>
                        <td><span class="badge badge-success">{{ $item->STATUS_PESANAN }}</span></td>
                        <td class="text-right">Rp {{ number_format($item->TOTAL_AKHIR, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger">Tidak ada data penjualan pada rentang tanggal tersebut.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right text-primary">TOTAL PENDAPATAN :</th>
                        <th class="text-right text-primary"><h4>Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h4></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection