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
        Schema::create('undangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_judul')->constrained('judul');
            $table->string('nomor');
            $table->string('perihal');
            $table->date('tanggal_hari');
            $table->time('waktu');
            $table->string('tempat');
            $table->string('signed')->nullable()->default('-');
            $table->string('softcopy_file_path')->nullable();
            $table->string('status_ujian')->default('dijadwalkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangan');
    }
};
