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
        Schema::create('stok_mutasi', function (Blueprint $table) {
            $table->id('stok_id');
           $table->foreignId('produk_id')
              ->constrained('produks', 'produk_id') // 'id_produk' adalah nama PK di tabel produks
              ->onDelete('cascade');
            $table->integer('jumlah');
            $table->enum('tipe', ['masuk', 'keluar', 'penyesuaian']);
            $table->string('keterangan')->nullable();

            // Ini akan menghasilkan kolom role_id dan role_type
            $table->morphs('role');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_mutasi');
    }
};
