<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan #{{ $pesanan->ID_PESANAN }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #2c3e50; }
        .info-toko { margin-bottom: 20px; }
        .info-pembeli { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background-color: #f8f9fa; }
        .total-row { font-weight: bold; background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>TOKO KAIN SASIRANGAN MELLISARI</h1>
        <p>Jl. Contoh Alamat No. 123, Banjarmasin, Kalimantan Selatan</p>
    </div>

    <table style="border: none; margin-bottom: 30px;">
        <tr style="border: none;">
            <td style="border: none; width: 50%;">
                <strong>Ditagihkan Kepada:</strong><br>
                Nama: {{ $pesanan->user->name }}<br>
                Email: {{ $pesanan->user->email }}<br>
            </td>
            <td style="border: none; width: 50%; text-align: right;">
                <strong>Detail Pesanan:</strong><br>
                Nomor Invoice: <strong>#{{ $pesanan->ID_PESANAN }}</strong><br>
                Tanggal: {{ \Carbon\Carbon::parse($pesanan->TANGGAL_PESANAN)->format('d F Y') }}<br>
                Status: <strong>{{ strtoupper($pesanan->STATUS_PESANAN) }}</strong>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detail as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->produk->NAMA_PRODUK ?? 'Produk Dihapus' }}</td>
                <td>Rp {{ number_format($item->HARGA_SATUAN, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $item->JUMLAH }}</td>
                <td class="text-right">Rp {{ number_format($item->SUBTOTAL, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PEMBAYARAN</td>
                <td class="text-right">Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja motif Sasirangan di toko kami!</p>
        <p>Dokumen ini adalah bukti pembayaran yang sah dan dicetak secara otomatis oleh sistem.</p>
    </div>

</body>
</html>