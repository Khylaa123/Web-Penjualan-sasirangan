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
            <div class="card-icon bg-danger">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Nilai Inventory</h4>
                </div>
                <div class="card-body" style="font-size: 1.1rem;">
                    Rp {{ number_format($nilai_inventory, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h4 class="text-primary"><i class="fas fa-warehouse mr-2"></i> Data Inventory</h4>
        <div>
            <a href="{{ route('inventory.pdf') }}" target="_blank" class="btn btn-danger mr-2">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
            
            <button type="button" class="btn btn-primary" id="btnBukaModalStok">
                <i class="fas fa-plus"></i> Tambah Stok Barang
            </button>
        </div>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('inventory.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-2">
                    <select name="kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori_list as $kat)
                            <option value="{{ $kat->ID_KATEGORI }}" {{ request('kategori') == $kat->ID_KATEGORI ? 'selected' : '' }}>
                                {{ $kat->NAMA_KATEGORI }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="stok" class="form-control">
                        <option value="">Semua Status Stok</option>
                        <option value="aman" {{ request('stok') == 'aman' ? 'selected' : '' }}>Aman (> 10)</option>
                        <option value="menipis" {{ request('stok') == 'menipis' ? 'selected' : '' }}>Menipis (<= 10)</option>
                        <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-info w-100"><i class="fas fa-search"></i> Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                        
                        <td class="text-center align-middle">
                            @if($item->GAMBAR_UTAMA)
                                <img src="{{ asset('storage/' . $item->GAMBAR_UTAMA) }}" 
                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/60?text=No+Image';" 
                                     alt="Gambar Produk" width="60" class="rounded shadow-sm" style="object-fit: cover; height: 60px;">
                            @else
                                <img src="https://via.placeholder.com/60?text=No+Image" alt="No Image" width="60" class="rounded shadow-sm">
                            @endif
                        </td>

                        <td class="font-weight-bold align-middle">{{ $item->NAMA_PRODUK }}</td>
                        <td class="align-middle">{{ $item->kategori->NAMA_KATEGORI ?? '-' }}</td>
                        <td class="align-middle">Rp {{ number_format($item->HARGA, 0, ',', '.') }}</td>

                        <td class="text-center align-middle">
                            @if($item->STOK > 10)
                                <span class="badge badge-success px-3">{{ $item->STOK }}</span>
                            @elseif($item->STOK > 0)
                                <span class="badge badge-warning px-3">{{ $item->STOK }}</span>
                            @else
                                <span class="badge badge-danger px-3">{{ $item->STOK }}</span>
                            @endif
                        </td>

                        <td class="text-center align-middle">
                            @if($item->STATUS_AKTIF == 1)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>

                        <td class="text-center align-middle">
                            <form action="{{ route('inventory.destroy', $item->ID_PRODUK) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Tidak ada data inventory ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="tambahStokModal" tabindex="-1" role="dialog" aria-labelledby="tambahStokModalLabel" aria-hidden="true" style="z-index: 99999; background: rgba(0,0,0,0.6);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('riwayat-stok.update') }}" method="POST" style="width: 100%;">
            @csrf
            <input type="hidden" name="TIPE_PERGERAKAN" value="Masuk">
            
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahStokModalLabel"><i class="fas fa-plus-circle"></i> Tambah Stok Barang</h5>
                    <button type="button" class="close text-white tutup-modal-stok" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Pilih Produk <span class="text-danger">*</span></label>
                        <select name="ID_PRODUK" class="form-control" required>
                            <option value="">-- Cari / Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->ID_PRODUK }}">{{ $p->NAMA_PRODUK }} (Sisa Stok: {{ $p->STOK }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Jumlah Ditambahkan <span class="text-danger">*</span></label>
                        <input type="number" name="JUMLAH" class="form-control" min="1" required placeholder="Contoh: 10">
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan (Opsional)</label>
                        <textarea name="KETERANGAN" class="form-control" rows="3" placeholder="Contoh: Barang datang dari supplier baru...">Penambahan stok (Masuk)</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary tutup-modal-stok">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Stok</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ketika tombol tambah stok diklik
        document.getElementById('btnBukaModalStok').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('tambahStokModal').style.display = 'block';
        });

        // Ketika tombol close/batal diklik
        let closeButtons = document.querySelectorAll('.tutup-modal-stok');
        closeButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('tambahStokModal').style.display = 'none';
            });
        });
    });
</script>

@endsection