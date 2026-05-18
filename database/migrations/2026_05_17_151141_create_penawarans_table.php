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
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke user/pelanggan yang meminta penawaran (jika wajib login)
            // Menggunakan nullable() jika pelanggan anonim juga bisa minta penawaran
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informasi Pelanggan (untuk backup & mempermudah tracking)
            $table->string('nama_pelanggan');
            $table->string('whatsapp_pelanggan'); // Format nomor: 628xxx
            
            // Dokumen PDF Penawaran yang di-generate otomatis
            $table->string('file_pdf')->nullable(); // Menyimpan path/nama file PDF
            
            // Total Nominal Penawaran (Opsional, tapi bagus untuk rekap dashboard admin)
            $table->decimal('total_harga', 15, 2)->default(0);
            
            // Status Penawaran (Ini yang nanti di-extend oleh admin untuk diubah)
            // Nilai default adalah 'pending' saat user pertama kali membuat
            $table->enum('status', ['pending', 'disetujui', 'dibatalkan'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawarans');
    }
};