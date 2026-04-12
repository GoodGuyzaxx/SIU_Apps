<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('prodi')->insert([
            'id' => 1,
            'nama_prodi' => 'Ilmu Hukum',
            'jenjang' => 'S1'
        ]);

        DB::table('prodi')->insert([
            'id' => 2,
            'nama_prodi' => 'Magister Hukum',
            'jenjang' => 'S2'
        ]);

        DB::table('prodi')->insert([
            'id' => 3,
            'nama_prodi' => 'Kenotaritan',
            'jenjang' => 'S3'
        ]);
    }
}
