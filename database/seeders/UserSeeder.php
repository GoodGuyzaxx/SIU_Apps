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
            'name' => 'Admin',
            'nrp/nidn/npm' => '001',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'kaprodi',
            'nrp/nidn/npm' => '002',
            'email' => 'kaprodi@email.com',
            'role' => 'kaprodi',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'dekan',
            'nrp/nidn/npm' => '003',
            'email' => 'dekan@email.com',
            'role' => 'dekan',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
           'name' => 'akademik',
            'nrp/nidn/npm' => '004',
           'email' => 'akademik@email.com',
           'role' => 'akademik',
           'password' => bcrypt('password'),
        ]);
    }
}
