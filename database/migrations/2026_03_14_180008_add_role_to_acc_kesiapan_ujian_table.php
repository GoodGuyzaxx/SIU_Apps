<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('acc_kesiapan_ujian', function (Blueprint $table) {
            $table->string('role')->after('id_dosen')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('acc_kesiapan_ujian', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
