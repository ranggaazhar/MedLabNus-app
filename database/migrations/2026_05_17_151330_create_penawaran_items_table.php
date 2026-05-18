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
        Schema::create('penawaran_items', function (Blueprint $table) {
            $table->id();

            // Menghubungkan ke tabel penawarans utama
            $table->foreignId('penawaran_id')->constrained('penawarans')->onDelete('cascade');

            // Menghubungkan ke tabel produk kamu (pastikan nama tabel produkmu sinkron, misal 'produks' atau 'products')
            $table->foreignId('produk_id')->constrained('produks', 'produk_id')->onDelete('cascade');

            $table->integer('jumlah'); // Kuantitas barang yang diminta
            $table->decimal('harga_saat_ini', 15, 2); // Mengunci harga pas penawaran dibuat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_items');
    }
};
