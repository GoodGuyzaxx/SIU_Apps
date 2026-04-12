<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'Admin',
            'nrp/nidn/npm' => '001',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'dekan',
            'nrp/nidn/npm' => '003',
            'email' => 'dekan@email.com',
            'role' => 'dekan',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 3,
           'name' => 'akademik',
            'nrp/nidn/npm' => '004',
           'email' => 'akademik@email.com',
           'role' => 'akademik',
           'password' => bcrypt('password'),
        ]);

        //Kapordi
        User::factory()->create([
            'id' => 4,
            'name' => 'kaprodi Ilmu Hukum',
            'nrp/nidn/npm' => '0001',
            'email' => 'kaprodi1@mail.com',
            'role' => 'kaprodi',
            'prodi_id' => 1,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 5,
            'name' => 'kaprodi Magister Hukum',
            'nrp/nidn/npm' => '0002',
            'email' => 'kaprodi2@email.com',
            'role' => 'kaprodi',
            'prodi_id' => 2,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 6,
            'name' => 'kaprodi Kenotariatan',
            'nrp/nidn/npm' => '0003',
            'email' => 'kaprodi3@email.com',
            'role' => 'kaprodi',
            'prodi_id' => 3,
            'password' => bcrypt('password'),
        ]);
    }
}
