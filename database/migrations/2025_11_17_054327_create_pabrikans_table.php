<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pabrikans', function (Blueprint $table) {
            $table->id('pabrikan_id');
            $table->string('nama_pabrikan', 100);
            $table->string('logo_pabrikan', 255)->nullable();
            $table->string('asal_negara', 50);
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index('nama_pabrikan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pabrikans');
    }
};