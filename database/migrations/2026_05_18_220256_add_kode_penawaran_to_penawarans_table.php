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
        Schema::table('penawarans', function (Blueprint $table) {
            // Menambahkan kolom kode_penawaran setelah whatsapp_pelanggan
            $table->string('kode_penawaran')->nullable()->after('whatsapp_pelanggan');
        });
    }

    public function down(): void
    {
        Schema::table('penawarans', function (Blueprint $table) {
            // Menghapus kolom jika rollback
            $table->dropColumn('kode_penawaran');
        });
    }
};
