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
            'name' => 'Super Admin',
            'nrp/nidn/npm' => '01',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'Assoc. Prof. Dr. Hj. Fitriyah Ingratubun, SH.,MH',
            'nrp/nidn/npm' => '02',
            'email' => 'dekan@email.com',
            'role' => 'dekan',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 3,
           'name' => 'akademik',
            'nrp/nidn/npm' => '03',
           'email' => 'akademik@email.com',
           'role' => 'akademik',
           'password' => bcrypt('password'),
        ]);

        //Kapordi
        User::factory()->create([
            'id' => 4,
            'name' => 'Muhammad Toha Ingratubun, S.H., M.H.,M.Kn',
            'nrp/nidn/npm' => '0001',
            'email' => 'kaprodi1@mail.com',
            'role' => 'kaprodi',
            'prodi_id' => 1,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 5,
            'name' => 'Dr. Yulianus Pabassing, S.H.,MH',
            'nrp/nidn/npm' => '0002',
            'email' => 'kaprodi2@email.com',
            'role' => 'kaprodi',
            'prodi_id' => 2,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'id' => 6,
            'name' => 'Assoc. Prof. Dr. Sri Iin Hartini,SH.,MH',
            'nrp/nidn/npm' => '0003',
            'email' => 'kaprodi3@email.com',
            'role' => 'kaprodi',
            'prodi_id' => 3,
            'password' => bcrypt('password'),
        ]);
    }
}
