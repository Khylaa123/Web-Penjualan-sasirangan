<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventory Barang</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; margin: 20px;}
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2c3e50; padding-bottom: 15px; }
        .header h2 { margin: 0; color: #2c3e50; font-size: 22px; text-transform: uppercase; font-weight: bold; }
        .header p { margin: 5px 0 0 0; color: #7f8c8d; font-size: 12px; }
        .summary-box { margin-bottom: 20px; background-color: #f8f9fa; padding: 10px; border-radius: 5px; border: 1px solid #ddd; }
        .summary-box table { width: 100%; border: none; }
        .summary-box td { border: none; font-weight: bold; font-size: 13px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 10px 8px; text-align: left; }
        table.data-table th { background-color: #2c3e50; color: #ffffff; text-align: center; text-transform: uppercase; font-size: 11px; }
        table.data-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 40px; text-align: right; font-style: italic; color: #7f8c8d; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
        .text-success { color: #27ae60; }
        .text-danger { color: #c0392b; }
        .text-primary { color: #2980b9; }
    </style>
</head>
<body>

<div class="header">
    <h2>TOKO KAIN SASIRANGAN MELLISARI</h2>
    <p>Laporan Data Inventory & Stok Barang <br> Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
</div>

<div class="summary-box">
    <table>
        <tr>
            <td>Total Jenis Produk: <span class="text-primary">{{ $total_produk }}</span></td>
            <td>Total Keseluruhan Stok: <span class="text-success">{{ $total_stok }}</span></td>
            <td class="text-right">Total Nilai Inventory: <span class="text-danger">Rp {{ number_format($nilai_inventory, 0, ',', '.') }}</span></td>
        </tr>
    </table>
</div>

<table class="data-table">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 35%;">Nama Produk</th>
            <th style="width: 20%;">Kategori</th>
            <th style="width: 20%;">Harga Satuan</th>
            <th style="width: 10%;">Stok</th>
            <th style="width: 10%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($produk as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->NAMA_PRODUK }}</td>
            <td class="text-center">{{ $item->kategori->NAMA_KATEGORI ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format($item->HARGA, 0, ',', '.') }}</td>
            <td class="text-center" style="font-weight: bold;">{{ $item->STOK }}</td>
            <td class="text-center">
                @if($item->STOK > 10)
                    Aman
                @elseif($item->STOK > 0)
                    Menipis
                @else
                    Habis
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data inventory</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Dokumen ini dicetak otomatis oleh Sistem E-Commerce Mellisari
</div>

</body>
</html>