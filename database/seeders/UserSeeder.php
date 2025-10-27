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
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'kaprodi',
            'email' => 'kaprodi@email.com',
            'role' => 'kaprodi',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'dekan',
            'email' => 'dekan@email.com',
            'role' => 'dekan',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
           'name' => 'akademik',
           'email' => 'akademik@email.com',
           'role' => 'akademik',
           'password' => bcrypt('password'),
        ]);
    }
}
