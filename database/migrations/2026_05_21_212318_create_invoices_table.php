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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice')->unique();
            $table->foreignId('penawaran_id')->nullable()->constrained('penawarans')->onDelete('set null');
            $table->string('nama_pelanggan');
            $table->string('whatsapp_pelanggan');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('pajak_ppn', 15, 2)->default(0); 
            $table->decimal('total_harga', 15, 2)->default(0); 
            $table->enum('status_pembayaran', ['pending', 'lunas', 'batal'])->default('pending');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            
            // 🛠️ FIX: Tambahkan parameter kedua 'produk_id' sebagai primary key tujuan
            $table->foreignId('produk_id')->constrained('produks', 'produk_id')->onDelete('restrict'); 
            
            $table->integer('jumlah'); 
            $table->decimal('harga_satuan', 15, 2); 
            $table->decimal('total_item_harga', 15, 2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};