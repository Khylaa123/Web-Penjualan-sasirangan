<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan #{{ $pesanan->ID_PESANAN }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background-color: #f8f9fa; }
        .total-row { font-weight: bold; background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h1>TOKO KAIN SASIRANGAN MELLISARI</h1>
        <p>Jl. Contoh Alamat No. 123, Banjarmasin, Kalimantan Selatan</p>
        <p>Telepon: 0812-3456-7890</p>
    </div>

    <table style="border: none; margin-bottom: 30px;">
        <tr style="border: none;">
            <td style="border: none; width: 50%; vertical-align: top;">
                <strong>Informasi Pembeli / Penerima:</strong><br>
                Nama: {{ $pesanan->user->name ?? '-' }}<br>
                Telepon: {{ $pesanan->user->no_whatsapp ?? '-' }}<br>
                Alamat: {{ $pesanan->user->alamat_lengkap ?? '-' }}
            </td>
            <td style="border: none; width: 50%; vertical-align: top; text-align: right;">
                <strong>Detail Pesanan:</strong><br>
                No. Pesanan: <strong>#{{ $pesanan->ID_PESANAN }}</strong><br>
                Tanggal: {{ \Carbon\Carbon::parse($pesanan->TANGGAL_PESAN)->format('d F Y') }}<br>
                Status: <strong>{{ strtoupper($pesanan->STATUS_PESANAN) }}</strong>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 8%;">No</th>
                <th>Nama Produk</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detail as $index => $det)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $det->produk->NAMA_PRODUK ?? 'Produk Tidak Diketahui' }}</td>
                <td class="text-right">Rp {{ number_format($det->HARGA_SAAT_BELI, 0, ',', '.') }}</td>
                <td class="text-center">{{ $det->JUMLAH_BELI }}</td>
                <td class="text-right">Rp {{ number_format($det->SUBTOTAL, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Subtotal Produk:</td>
                <td class="text-right">Rp {{ number_format($pesanan->SUBTOTAL_PRODUK, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right">Biaya Pengiriman:</td>
                <td class="text-right">Rp {{ number_format($pesanan->BIAYA_PENGIRIMAN, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PEMBAYARAN:</td>
                <td class="text-right" style="color: #2c3e50;">Rp {{ number_format($pesanan->TOTAL_AKHIR, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Terima kasih telah berbelanja di Toko Kain Sasirangan Mellisari.</p>
        <p>Invoice ini adalah bukti pembayaran yang sah.</p>
    </div>

</body>
</html>