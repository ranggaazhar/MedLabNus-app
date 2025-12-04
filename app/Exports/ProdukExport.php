<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProdukExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $kategori;
    protected $search;

    public function __construct($kategori = null, $search = null)
    {
        $this->kategori = $kategori;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Produk::with(['pabrikan', 'spesifikasis']);

        // Filter kategori
        if ($this->kategori && $this->kategori !== 'semua') {
            $query->where('kategori', $this->kategori);
        }

        // Filter search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_produk', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('nama_produk', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Kategori',
            'Pabrikan',
            'Deskripsi',
            'Spesifikasi',
            'Tanggal Dibuat',
        ];
    }

    public function map($produk): array
    {
        static $no = 0;
        $no++;

        // Format spesifikasi
        $spesifikasi = '';
        if ($produk->spesifikasis && $produk->spesifikasis->count() > 0) {
            $specs = $produk->spesifikasis->map(function($spec) {
                return $spec->nama_spesifikasi . ': ' . $spec->nilai;
            })->toArray();
            $spesifikasi = implode('; ', $specs);
        }

        return [
            $no,
            $produk->nama_produk,
            ucfirst($produk->kategori),
            $produk->pabrikan->nama_pabrikan ?? '-',
            $produk->deskripsi_singkat ?? '-',
            $spesifikasi ?: '-',
            $produk->created_at->format('d-m-Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}