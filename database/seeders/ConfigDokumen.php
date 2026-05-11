<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigDokumen extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('config_dokumen')->insert([
            'nama' => 'Assoc. Prof. Dr. Hj. Fitriyah Ingratubun, SH.,MH',
            'jabatan' => 'dekan',
            'nrp' => '0908084',
            'nidn' => '1214038701'
        ]);

        DB::table('config_dokumen')->insert([
            'prodi_id' => 1,
            'nama' => 'Muhammad Toha Ingratubun, SH., MH., M.Kn',
            'jabatan' => 'kaprodi',
            'nrp' => '2010160',
            'nidn' => '1416079501'
        ]);

        DB::table('config_dokumen')->insert([
            'prodi_id' => 2,
            'nama' => 'Dr. Yulianus Pabassing S.H., M.H.',
            'jabatan' => 'kaprodi',
            'nrp' => '0308011',
            'nidn' => '1211106801'
        ]);

        DB::table('config_dokumen')->insert([
            'prodi_id' => 3,
            'nama' => 'Assoc. Prof. Dr. SRI IIN HARTINI S.H., M.H.',
            'jabatan' => 'kaprodi',
            'nrp' => '0306009',
            'nidn' => '1220037401'
        ]);
    }
}
