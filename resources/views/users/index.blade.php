@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Daftar Pengguna Sistem</h4>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
    <i class="fas fa-user-plus"></i> Tambah Pengguna
</button>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="font-weight-bold">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if(in_array(strtolower($u->role), ['admin', 'super admin', 'super_admin']))
                                <span class="badge badge-danger">Admin</span>
                            @elseif(strtolower($u->role) == 'pegawai')
                                <span class="badge badge-info">Pegawai</span>
                            @else
                                <span class="badge badge-success">Pembeli</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit{{ $u->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

                            <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini secara permanen?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($users as $u)
<div class="modal fade" id="modalEdit{{ $u->id }}" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.update', $u->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ $u->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $u->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Role / Jabatan</label>
                        <select name="role" class="form-control" required>
                            <option value="admin" {{ in_array(strtolower($u->role), ['admin', 'super admin', 'super_admin']) ? 'selected' : '' }}>Admin</option>
                            <option value="pegawai" {{ strtolower($u->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            <option value="pembeli" {{ strtolower($u->role) == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password Baru (Opsional)</label>
                        <input type="password" class="form-control" name="password" minlength="8" placeholder="Kosongkan jika tidak ingin ganti password">
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

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengguna Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" required placeholder="Nama lengkap...">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required placeholder="contoh@email.com">
                    </div>
                    <div class="form-group">
                        <label>Role / Jabatan</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
                            <option value="pembeli">Pembeli</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password Akun</label>
                        <input type="password" class="form-control" name="password" required minlength="8" placeholder="Minimal 8 karakter...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection