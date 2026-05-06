@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Daftar Pesanan Masuk</h4>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Nama Pembeli</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>No. Resi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $item)
                    <tr>
                        <td class="font-weight-bold">{{ $item->ID_PESANAN }}</td>
                        <td>{{ date('d M Y, H:i', strtotime($item->TANGGAL_PESAN)) }}</td>
                        <td>{{ $item->user ? $item->user->name : 'User Dihapus' }}</td>
                        <td class="text-success font-weight-bold">Rp {{ number_format($item->TOTAL_AKHIR, 0, ',', '.') }}</td>
                        <td>
                            @if($item->STATUS_PESANAN == 'Menunggu Pembayaran')
                                <span class="badge badge-warning">Menunggu Bayar</span>
                            @elseif($item->STATUS_PESANAN == 'Diproses')
                                <span class="badge badge-primary">Diproses</span>
                            @elseif($item->STATUS_PESANAN == 'Dikirim')
                                <span class="badge badge-info">Dikirim</span>
                            @elseif($item->STATUS_PESANAN == 'Selesai')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->RESI_PENGIRIMAN ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('pesanan.show', $item->ID_PESANAN) }}" class="btn btn-sm btn-info">Cek Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection