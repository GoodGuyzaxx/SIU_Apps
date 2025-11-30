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
        Schema::create('status_undangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_undangan')->constrained('undangan')->cascadeOnDelete();
            $table->foreignId('id_dosen')->constrained('users');
            $table->string('role');
            $table->string('status_konfirmasi')->default('belum dikonfirmasi');
            $table->string('alasan_penolakan')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_undangan');
    }
};
