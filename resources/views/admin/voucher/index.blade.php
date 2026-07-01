@extends('layouts.admin')

@section('title', 'Kelola Voucher Diskon')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Manajemen Voucher Diskon</h4>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus"></i> Tambah Voucher
        </button>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Voucher</th>
                        <th>Potongan Harga</th>
                        <th>Status Kupon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vouchers as $index => $v)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="font-weight-bold text-uppercase text-primary">{{ $v->KODE_VOUCHER }}</td>
                        <td class="text-success font-weight-bold">Rp {{ number_format($v->POTONGAN_HARGA, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $v->STATUS_AKTIF == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ $v->STATUS_AKTIF }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit{{ $v->ID_VOUCHER }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.voucher.destroy', $v->ID_VOUCHER) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus voucher ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data kupon voucher tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($vouchers as $v)
<div class="modal fade" id="modalEdit{{ $v->ID_VOUCHER }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.voucher.update', $v->ID_VOUCHER) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Voucher</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kode Kupon</label>
                        <input type="text" class="form-control text-uppercase" name="KODE_VOUCHER" value="{{ $v->KODE_VOUCHER }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nominal Potongan (Rp)</label>
                        <input type="number" class="form-control" name="POTONGAN_HARGA" value="{{ $v->POTONGAN_HARGA }}" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="STATUS_AKTIF" class="form-control" required>
                            <option value="Aktif" {{ $v->STATUS_AKTIF == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ $v->STATUS_AKTIF == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.voucher.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Buat Voucher Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Kode Voucher</label>
                        <input type="text" class="form-control text-uppercase" name="KODE_VOUCHER" placeholder="Contoh: DISKONBESAR" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nominal Potongan Harga (Rp)</label>
                        <input type="number" class="form-control" name="POTONGAN_HARGA" placeholder="Contoh: 50000" required>
                    </div>
                    <div class="form-group">
                        <label>Status Aktivasi</label>
                        <select name="STATUS_AKTIF" class="form-control" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection