<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            DosenSeeder::class,
        ]);

        DB::table('papan_informasi')->insert([
            'yt_url' => null,
            'running_text' => null,
            'jadwal_proposal' => json_encode([]),
            'jadwal_skripsi' => json_encode([]),
            'pengajuan_judul' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
