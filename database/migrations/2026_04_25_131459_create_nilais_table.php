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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('judul_id')->constrained('judul')->cascadeOnDelete();
            $table->string('nilai_proposal')->nullable();
            $table->string('nilai_proposal_angka')->nullable();
            $table->string('tanggal_ujian_proposal')->nullable();
            $table->string('nilai_hasil')->nullable();
            $table->string('nilai_hasil_angka')->nullable();
            $table->string('tanggal_ujian_hasil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
