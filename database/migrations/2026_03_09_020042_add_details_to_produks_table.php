<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Kolom Satuan (Penting untuk keterangan di PDF Penawaran: Box, Set, Unit, dll)
            $table->string('satuan', 50)->default('Unit')->after('kategori');

            // Harga Acuan Internal (Hanya dilihat Admin untuk bahan 'Edit & Preview' Penawaran)
            // Menggunakan decimal agar presisi untuk perhitungan keuangan
            $table->decimal('harga_acuan', 15, 2)->default(0)->after('satuan');

            // Stok Minimal (Sebagai threshold/batas peringatan stok tipis di Dashboard Admin)
            $table->integer('stok_minimal')->default(0)->after('harga_acuan');
            
            // Kode Produk / SKU (Opsional, sangat berguna untuk pencarian cepat di gudang)
            $table->string('kode_produk')->nullable()->unique()->after('produk_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['satuan', 'harga_acuan', 'stok_minimal', 'kode_produk']);
        });
    }
};