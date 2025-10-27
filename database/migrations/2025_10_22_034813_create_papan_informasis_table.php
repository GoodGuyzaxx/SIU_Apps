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
        Schema::create('papan_informasi', function (Blueprint $table) {
            $table->id();
            $table->string('yt_url')->nullable();
            $table->text('running_text')->nullable();
            $table->json('jadwal_proposal')->nullable();
            $table->json('jadwal_skripsi')->nullable();
            $table->json('pengajuan_judul')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('papan_informasis');
    }
};
