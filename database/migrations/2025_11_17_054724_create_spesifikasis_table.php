<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spesifikasis', function (Blueprint $table) {
            $table->id('spesifikasi_id');
            $table->foreignId('produk_id')
                  ->constrained('produks', 'produk_id')
                  ->onDelete('cascade');
            $table->string('nama_spesifikasi', 100);
            $table->text('nilai');
            $table->timestamps();
            
            // Index untuk query performance
            $table->index('produk_id');
            $table->index('nama_spesifikasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spesifikasis');
    }
};
