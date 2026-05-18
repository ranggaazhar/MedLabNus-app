<!DOCTYPE html>
<html>
<head>
    <title>Surat Penawaran</title>
    <style>
        body { font-family: sans-serif; color: #333; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info-table, .item-table { w-full; border-collapse: collapse; margin-bottom: 20px; width: 100%; }
        .item-table th { background-color: #B1252E; color: white; padding: 8px; text-align: left; }
        .item-table td { padding: 8px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SURAT PERMINTAAN PENAWARAN HARGA</h2>
        <p>Kode: {{ $penawaranData->kode_penawaran }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="150"><strong>Nama Instansi</strong></td>
            <td>: {{ $penawaranData->nama_pelanggan }}</td>
        </tr>
        <tr>
            <td><strong>No. WhatsApp</strong></td>
            <td>: {{ $penawaranData->whatsapp_pelanggan }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $penawaranData->created_at->format('d M Y H:i') }} WIB</td>
        </tr>
    </table>

    <h3>Daftar Produk Yang Diminta:</h3>
    <table class="item-table">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Produk</th>
                <th width="100" style="text-align: center;">Jumlah (Qty)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penawaranData->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->produk->nama_produk ?? 'Produk Tidak Diketahui' }}</td>
                <td style="text-align: center;">{{ $item->jumlah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>