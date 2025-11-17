<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('produk_id');
            $table->string('nama_produk', 255);
            $table->string('model_produk', 100);
            $table->text('deskripsi_singkat')->nullable();
            $table->string('gambar_utama', 255)->nullable();
            $table->enum('kategori', ['reagen', 'alat'])->default('reagen');
            $table->foreignId('pabrikan_id')
                  ->constrained('pabrikans', 'pabrikan_id')
                  ->onDelete('cascade');
            $table->timestamps(); 
            
            $table->index('nama_produk');
            $table->index('model_produk');
            $table->index('kategori');
            $table->index(['kategori', 'pabrikan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
