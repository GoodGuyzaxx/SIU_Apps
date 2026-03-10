<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acc_kesiapan_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_undangan')->constrained('undangan')->cascadeOnDelete();
            $table->foreignId('id_dosen')->constrained('dosen')->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending, disetujui, ditolak
            $table->text('alasan_penolakan')->nullable();
            $table->string('token', 64)->unique();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_kesiapan_ujian');
    }
};