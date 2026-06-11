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
        Schema::table('admins', function (Blueprint $table) {
            // Menambahkan kolom role setelah kolom email
            // Default diatur ke 'gudang' atau 'admin' sesuai kebutuhan rbac kamu
            $table->string('role')->default('gudang')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Menghapus kolom role jika rollback dilakukan
            $table->dropColumn('role');
        });
    }
};