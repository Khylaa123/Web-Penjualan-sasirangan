<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { width: 100%; margin-top: 50px; text-align: right; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>MELLISARI SASIRANGAN</h2>
        <p>Laporan Penjualan Produk Kain</p>
        <p>
            @if($tgl_mulai && $tgl_sampai)
                Periode: {{ date('d M Y', strtotime($tgl_mulai)) }} s/d {{ date('d M Y', strtotime($tgl_sampai)) }}
            @else
                Periode: Semua Data Penjualan
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tanggal</th>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ date('d-m-Y', strtotime($item->TANGGAL_PESAN)) }}</td>
                <td>{{ $item->ID_PESANAN }}</td>
                <td>{{ $item->user->name ?? 'User Dihapus' }}</td>
                <td class="text-right">Rp {{ number_format($item->TOTAL_AKHIR, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">TOTAL PENDAPATAN</th>
                <th class="text-right">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Banjarmasin, {{ date('d M Y') }}</p>
        <br><br><br>
        <p><b>Pimpinan/Admin</b></p>
    </div>

</body>
</html>