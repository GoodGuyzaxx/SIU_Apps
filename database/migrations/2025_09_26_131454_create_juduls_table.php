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
        Schema::create('judul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mahasiswa')->constrained('mahasiswa');
            $table->string('minat');
            $table->text('judul');
            $table->foreignId('pembimbing_satu')->nullable()->constrained('dosen');
            $table->foreignId('pembimbing_dua')->nullable()->constrained('dosen');
            $table->foreignId('penguji_satu')->nullable()->constrained('dosen');
            $table->foreignId('penguji_dua')->nullable()->constrained('dosen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('judul');
    }
};
