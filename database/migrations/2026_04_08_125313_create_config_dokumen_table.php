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
        Schema::create('config_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodi_id')->nullable()->constrained('prodi');
            $table->string('nama');
            $table->string('ttd')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nidn')->nullable();
            $table->string('nrp')->nullable();
            $table->string('nip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_dokumen');
    }
};
