<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        DB::table('papan_informasi')->insert([
            'yt_url' => '',
            'jadwal_proposal' => json_encode([]),
            'jadwal_skripsi' => json_encode([]),
            'pengajuan_judul' => json_encode([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
