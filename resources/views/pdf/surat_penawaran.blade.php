<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Penawaran - {{ $penawaranData->kode_penawaran }}</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            color: #222; 
            font-size: 13px; 
            line-height: 1.5;
            margin: 10px 20px;
        }
        
        /* --- KOP SURAT STYLING --- */
        .kop-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .kop-logo {
            width: 90px;
            vertical-align: middle;
            padding-bottom: 10px;
        }
        .kop-logo img {
            width: 85px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
            padding-left: 10px;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #B1252E; /* Warna merah identitas Medlab */
            letter-spacing: 1px;
            margin: 0;
            padding: 0;
        }
        .company-address {
            font-size: 11px;
            color: #444;
            margin: 4px 0 2px 0;
            line-height: 1.3;
        }
        .company-brands {
            font-size: 9px;
            font-weight: bold;
            color: #666;
            font-style: italic;
            margin: 3px 0 0 0;
        }
        .kop-line {
            border-top: 2px solid #000;
            border-bottom: 0.5px solid #000;
            height: 3px;
            margin-bottom: 25px;
        }

        /* --- CONTENT STYLING --- */
        .title-area {
            text-align: center;
            margin-bottom: 25px;
        }
        .title-area h2 {
            font-size: 16px;
            text-decoration: underline;
            margin: 0 0 4px 0;
            color: #000;
            letter-spacing: 0.5px;
        }
        .title-area p {
            font-size: 12px;
            margin: 0;
            font-family: monospace;
            color: #333;
        }

        /* --- TABLES STYLING --- */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .item-table th {
            background-color: #B1252E;
            color: white;
            padding: 10px 8px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            border: 1px solid #B1252E;
        }
        .item-table td {
            padding: 10px 8px;
            border: 1px solid #e5e7eb;
        }
        .item-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        /* --- FOOTER/TANDA TANGAN --- */
        .footer-sign {
            width: 100%;
            margin-top: 50px;
        }
        .sign-space {
            height: 70px;
        }
    </style>
</head>
<body>

    <table class="kop-container">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('images/logo2.png') }}" alt="Logo">
            </td>
            <td class="kop-text">
                <div class="company-name">PT. MEDLAB NUSANTARA</div> 
                <div class="company-address">
                    Jl. Merapi Raya No. 31 A Kelurahan Panorama, Bengkulu <br>
                    Telp/Fax: (0736) 28416 | Kode Pos: 38226 | Email: medlab_nusantara@yahoo.com 
                </div>
                <div class="company-brands">
                    {{-- Daftar Keagenan Resmi Alkes --}}
                    BIOSYSTEMS - SWELAB - TRIDEMA - NEW LAB LABORATORIES - DIAMOND - ALIFAX – AXIOM 
                </div>
            </td>
        </tr>
    </table>
    
    <div class="kop-line"></div>

    <div class="title-area">
        <h2>SURAT PERMINTAAN PENAWARAN HARGA</h2>
        <p>Nomor Berkas: {{ $penawaranData->kode_penawaran }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="130"><strong>Nama Instansi</strong></td>
            <td width="15">:</td>
            <td>{{ $penawaranData->nama_pelanggan }}</td>
        </tr>
        <tr>
            <td><strong>No. WhatsApp</strong></td>
            <td>:</td>
            <td>+{{ $penawaranData->whatsapp_pelanggan }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Pengajuan</strong></td>
            <td>:</td>
            <td>{{ $penawaranData->created_at->translatedFormat('d F Y - H:i') }} WIB</td>
        </tr>
    </table>

    <p style="font-weight: bold; margin-bottom: 10px;">Daftar Produk/Alat Kesehatan Yang Diminta:</p>
    <table class="item-table">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="75%">Nama Unit / Spesifikasi Produk</th>
                <th width="20%" style="text-align: center;">Kuantitas (Qty)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penawaranData->items as $index => $item)
            <tr>
                <td style="text-align: center; color: #666;">{{ $index + 1 }}</td>
                <td>
                    <span style="font-size: 10px; font-weight: bold; color: #B1252E; display: block; text-transform: uppercase;">
                        {{ $item->produk->pabrikan->nama_pabrikan ?? 'Pabrikan' }}
                    </span>
                    <strong style="font-size: 13px; color: #111;">
                        {{ $item->produk->nama_produk ?? 'Produk Tidak Diketahui' }}
                    </strong>
                </td>
                <td style="text-align: center; font-weight: bold; color: #111;">
                    {{ $item->jumlah }} Unit
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="footer-sign">
        <tr>
            <td width="60%">
                <p style="font-size: 11px; color: #666; font-style: italic;">
                    *Dokumen ini diterbitkan secara otomatis oleh sistem e-catalog PT. Medlab Nusantara.<br>
                    Tindak lanjut negosiasi harga resmi akan dikirimkan oleh Admin melalui kontak WhatsApp yang tertera.
                </p>
            </td>
            <td width="40%" style="text-align: center;">
                <p>Bengkulu, {{ carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p style="font-weight: bold; margin-top: 5px;">PT. Medlab Nusantara</p> 
                <div class="sign-space"></div>
                <p style="text-decoration: underline; font-weight: bold;">( .................................... )</p>
                <p style="font-size: 11px; color: #555; margin-top: -10px;">Rosihan Syahlan Syahputra</p>
            </td>
        </tr>
    </table>

</body>
</html>