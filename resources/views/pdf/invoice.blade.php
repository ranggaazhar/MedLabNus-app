<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice Faktur - {{ $invoice->kode_invoice }}</title>
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
            color: #B1252E;
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
            margin-bottom: 25px;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
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

        /* --- TOTAL CALCULATION --- */
        .total-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .total-container td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }

        .no-border-left {
            border-left: none !important;
            border-bottom: none !important;
            border-top: none !important;
        }

        /* --- FOOTER/TANDA TANGAN --- */
        .footer-sign {
            width: 100%;
            margin-top: 30px;
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
                    BIOSYSTEMS - SWELAB - TRIDEMA - NEW LAB LABORATORIES - DIAMOND - ALIFAX – AXIOM
                </div>
            </td>
        </tr>
    </table>

    <div class="kop-line"></div>

    <div class="title-area">
        <h2>FAKTUR INVOICE TAGIHAN</h2>
        <p>Nomor Invoice: {{ $invoice->kode_invoice }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="130"><strong>Nama Instansi</strong></td>
            <td width="15">:</td>
            <td>{{ $invoice->nama_pelanggan }}</td>
        </tr>
        @if ($invoice->whatsapp_pelanggan)
            <tr>
                <td><strong>No. WhatsApp</strong></td>
                <td>:</td>
                <td>+{{ $invoice->whatsapp_pelanggan }}</td>
            </tr>
        @endif
        <tr>
            <td><strong>Tanggal Terbit</strong></td>
            <td>:</td>
            <td>{{ $invoice->created_at->translatedFormat('d F Y - H:i') }} WIB</td>
        </tr>
        <tr>
            <td><strong>Status Pembayaran</strong></td>
            <td>:</td>
            <td
                style="font-weight: bold; text-transform: uppercase; color: {{ $invoice->status_pembayaran == 'lunas' ? '#10b981' : ($invoice->status_pembayaran == 'batal' ? '#ef4444' : '#f59e0b') }}">
                {{ $invoice->status_pembayaran }}
            </td>
        </tr>
    </table>

    <p style="font-weight: bold; margin-bottom: 10px;">Rincian Item Alat Kesehatan & Penjualan:</p>
    <table class="item-table">
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="45%">Produk</th>
                <th width="10%" style="text-align: center;">Qty</th>
                <th width="20%" style="text-align: right;">Harga Satuan</th>
                <th width="20%" style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            {{-- ✅ PERBAIKAN: Menggunakan relasi $invoice->invoiceItems --}}
            @if (isset($invoice) && $invoice->invoiceItems && $invoice->invoiceItems->count() > 0)
                @foreach ($invoice->invoiceItems as $index => $item)
                    <tr>
                        <td style="text-align: center; color: #666;">{{ $index + 1 }}</td>
                        <td>
                            <strong style="font-size: 13px; color: #111;">
                                {{ $item->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}
                            </strong>
                        </td>
                        {{-- ✅ PERBAIKAN: Menggunakan kolom 'jumlah' --}}
                        <td style="text-align: center; color: #111;">
                            {{ $item->jumlah }}
                        </td>
                        {{-- ✅ PERBAIKAN: Menggunakan kolom 'harga_satuan' --}}
                        <td style="text-align: right; color: #111;">
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                        {{-- ✅ PERBAIKAN: Menggunakan kolom 'total_item_harga' --}}
                        <td style="text-align: right; font-weight: bold; color: #111;">
                            Rp {{ number_format($item->total_item_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Tidak ada rincian item.</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Perhitungan Nilai Total Akumulasi Finansial --}}
    <table class="total-container">
        <tr>
            <td width="70%" class="no-border-left"></td>
            <td width="15%" style="text-align: right; font-weight: bold; background-color: #f9fafb;">Subtotal</td>
            <td width="15%" style="text-align: right; background-color: #f9fafb;">
                Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td width="70%" class="no-border-left"></td>
            <td width="15%" style="text-align: right; font-weight: bold; background-color: #f9fafb;">PPN (11%)</td>
            <td width="15%" style="text-align: right; background-color: #f9fafb;">
                Rp {{ number_format($invoice->pajak_ppn, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td width="70%" class="no-border-left"></td>
            <td width="15%" style="text-align: right; font-weight: bold; background-color: #B1252E; color: white;">
                TOTAL TAGIHAN</td>
            <td width="15%"
                style="text-align: right; font-weight: bold; background-color: #B1252E; color: white; font-size: 14px;">
                Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <table class="footer-sign">
        <tr>
            <td width="60%">
                <p style="font-size: 11px; color: #666; font-style: italic; padding-right: 20px;">
                    *Dokumen ini merupakan bukti tagihan piutang resmi yang diterbitkan oleh sistem manajemen internal
                    PT. Medlab Nusantara.<br>
                    Pembayaran sah dianggap lunas jika sudah ditransfer ke rekening resmi perusahaan dan divalidasi oleh
                    pihak keuangan.
                </p>
            </td>
            <td width="40%" style="text-align: center;">
                <p>Bengkulu, {{ \Carbon\Carbon::parse($invoice->created_at)->translatedFormat('d F Y') }}</p>
                <p style="font-weight: bold; margin-top: 5px;">PT. Medlab Nusantara</p>
                <div class="sign-space"></div>
                <p style="text-decoration: underline; font-weight: bold;">( .................................... )</p>
                <p style="font-size: 11px; color: #555; margin-top: -10px;">
                    {{ $invoice->adminCreator->name ?? 'Rosihan Syahlan Syahputra' }}</p>
            </td>
        </tr>
    </table>

</body>

</html>
