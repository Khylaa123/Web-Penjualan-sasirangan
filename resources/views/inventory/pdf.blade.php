<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <style>
        body { font-family: Arial; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        h2 { text-align: center; }
    </style>
</head>
<body>

<h2>LAPORAN INVENTORY BARANG</h2>

<p><b>Total Produk:</b> {{ $total_produk }}</p>
<p><b>Total Stok:</b> {{ $total_stok }}</p>
<p><b>Nilai Inventory:</b> Rp {{ number_format($nilai_inventory, 0, ',', '.') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
    </thead>

    <tbody>
        @foreach($produk as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->NAMA_PRODUK }}</td>
            <td>{{ $item->kategori->NAMA_KATEGORI ?? '-' }}</td>
            <td>Rp {{ number_format($item->HARGA, 0, ',', '.') }}</td>
            <td>{{ $item->STOK }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>