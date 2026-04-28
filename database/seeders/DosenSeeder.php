<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Memulai proses seeding untuk Dosen dan Akun User...');

        $dosens = [
            [
                'nama' => 'Assoc. Prof. Dr. H. M.H. Ingratubun, SE.,SH.,MM.,MH.,Mediator',
                'nidn' => '12.161264.01',
                'nrp_nip' => '04 05 014',
                'inisial_dosen' => 'MHI',
                'ttl' => 'Ohowait, 16 Desember 1966',
                'nomor_hp' => null,
                'email' => 'husni1964@ymail.com',
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Hj. Hernati, SH.,MM.,MH',
                'nidn' => '12.190368.02',
                'nrp_nip' => '03 08 010',
                'inisial_dosen' => 'Hi',
                'ttl' => 'Enrekang, 19 Maret 1968',
                'nomor_hp' => '081344406666',
                'email' => 'hernati_cenne@yahoo.co.id',
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Sri Iin Hastuti, SH.,MH',
                'nidn' => '12.200374.01',
                'nrp_nip' => '03 06 009',
                'inisial_dosen' => 'SIH',
                'ttl' => 'Jakarta, 20 Maret 1974',
                'nomor_hp' => '081643226662',
                'email' => 'sri.iinhartini@yahoo.co.id',
            ],
            [
                'nama' => 'Dr. Salesius Jemaru, SH.,M.Hum',
                'nidn' => '12.020474.02',
                'nrp_nip' => '09 08 085',
                'inisial_dosen' => 'SJ',
                'ttl' => 'Todo, 2 April 1974',
                'nomor_hp' => '081388788584',
                'email' => 'salesiusjemaru8@gmail.com',
            ],
            [
                'nama' => 'Dr. Yohanis Sudiman Bakti, SH.,MH',
                'nidn' => '12.180973.01',
                'nrp_nip' => '05 04 030',
                'inisial_dosen' => 'YSB',
                'ttl' => 'Toraja, 18 September 1973',
                'nomor_hp' => '081335044951',
                'email' => 'yohanisbakti09@gmail.com',
            ],
            [
                'nama' => 'Dr. H. Kajagi Kalman, SH.,MH',
                'nidn' => '12.081068.01',
                'nrp_nip' => '07 11 056',
                'inisial_dosen' => 'KK',
                'ttl' => 'Bandung, 8 Oktober 1968',
                'nomor_hp' => '081148278',
                'email' => null,
            ],
            [
                'nama' => 'Dr. Yulianus Pabassing, SH.,MH',
                'nidn' => '12.111068.01',
                'nrp_nip' => '03 08 011',
                'inisial_dosen' => 'YP',
                'ttl' => 'Toraja, 11 Oktober 1968',
                'nomor_hp' => '081344271236',
                'email' => null,
            ],
            [
                'nama' => 'Dr. Wilhelmus Kenyaan, SH.,MH',
                'nidn' => '12.250673.01',
                'nrp_nip' => '03 01 005',
                'inisial_dosen' => 'WK',
                'ttl' => 'Ambon, 26 Juni 1973',
                'nomor_hp' => '085244781818',
                'email' => 'willyrenyaan25@gmail.com',
            ],
            [
                'nama' => 'Dr. Semy B.A. Launussa, SH.,MH',
                'nidn' => '12.060968.01',
                'nrp_nip' => '05 04 029',
                'inisial_dosen' => 'SL',
                'ttl' => 'Damer, 6 September 1968',
                'nomor_hp' => '085244050609',
                'email' => 'semylatu@gmail.com',
            ],
            [
                'nama' => 'Dr. Roida Hutabalian, SH.,MH',
                'nidn' => '12.121266.01',
                'nrp_nip' => '05 04 026',
                'inisial_dosen' => 'RH',
                'ttl' => 'Hutaginjang, 12 Desember 1966',
                'nomor_hp' => '081354076317',
                'email' => 'roidahutabalian55@gmail.com',
            ],
            [
                'nama' => 'Dr. Edy Purwito, S.Pd.,SH.,M.Hum',
                'nidn' => '12.120264.01',
                'nrp_nip' => '131807756',
                'inisial_dosen' => 'EP',
                'ttl' => 'Nguntoronadi, 12 Desember 1964',
                'nomor_hp' => '081247048038',
                'email' => 'purwitoedy64@gmail.com',
            ],
            [
                'nama' => 'Assoc. Prof. Dr. Hj. Fitriyah Ingratubun, SH.,MH',
                'nidn' => '12.140387.01',
                'nrp_nip' => '09 08 084',
                'inisial_dosen' => 'FI',
                'ttl' => 'Sorong, 14 Maret 1987',
                'nomor_hp' => '085299444467',
                'email' => 'ingratubun14_fitri@yahoo.com',
            ],
            [
                'nama' => 'Siska. S.D. Pongkorung, SH.,MH',
                'nidn' => '12.140971.02',
                'nrp_nip' => '06 05 001',
                'inisial_dosen' => 'SP',
                'ttl' => 'Minahasa, 14 September 1971',
                'nomor_hp' => '085244592699',
                'email' => 'siskasifinedevita@gmail.com',
            ],
            [
                'nama' => 'Arman Koedoeboen, SH.,MH',
                'nidn' => '12.170985.01',
                'nrp_nip' => '09 12 082',
                'inisial_dosen' => 'AK',
                'ttl' => 'Ohowait, 17 September 1985',
                'nomor_hp' => '081343414363',
                'email' => 'armankoedoeboen@yahoo.com',
            ],
            [
                'nama' => 'Dr. H. Baharudin S. Ingratubun, SE.,SH.,MM.,MH',
                'nidn' => '14.271088.01',
                'nrp_nip' => '14 11 127',
                'inisial_dosen' => 'BSI',
                'ttl' => 'Sorong, 27 Oktober 1988',
                'nomor_hp' => '085399030240',
                'email' => 'ingratubunbahar27@yahoo.co.id',
            ],
            [
                'nama' => 'Dr. Samsul Tamher, SH.,MH',
                'nidn' => '12.050581.01',
                'nrp_nip' => '06 05 046',
                'inisial_dosen' => 'ST',
                'ttl' => 'Ohowait, 5 Mei 1981',
                'nomor_hp' => '081344190345',
                'email' => 'samsultamhersamsul02046@gmail.com',
            ],
            [
                'nama' => 'Muhamad Hafiz Ingsaputro, SH., MH',
                'nidn' => null,
                'nrp_nip' => '15 09 141',
                'inisial_dosen' => 'MH',
                'ttl' => 'Sorong, 21 April 1990',
                'nomor_hp' => '085254432525',
                'email' => 'mhvsaputra@gmail.com',
            ],
            [
                'nama' => 'Jumriah, S.H., M.Kn',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'JH',
                'ttl' => null,
                'nomor_hp' => '081240176515',
                'email' => null,
            ],
            [
                'nama' => 'Tri Yanuaria, S.H., M.Hum.',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'TY',
                'ttl' => null,
                'nomor_hp' => '081248319714',
                'email' => null,
            ],
            [
                'nama' => 'Natasya Auliya Husain, SH.,MH',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'NAH',
                'ttl' => null,
                'nomor_hp' => '081248310629',
                'email' => null,
            ],
            [
                'nama' => 'Taufik Irpan Awalluddin, SH.,MH',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'TIA',
                'ttl' => null,
                'nomor_hp' => '081248511234',
                'email' => null,
            ],
            [
                'nama' => 'Muhammad Toha Ingratubun, SH., MH., M.Kn',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'MTI',
                'ttl' => null,
                'nomor_hp' => '081320999943',
                'email' => null,
            ],
            [
                'nama' => 'Fransiskus X. Watkat, S.H., M.Hum',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'FW',
                'ttl' => null,
                'nomor_hp' => '081344541777',
                'email' => null,
            ],
            [
                'nama' => 'Eren Arif Budiman, S.H.,M.H',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'EA',
                'ttl' => null,
                'nomor_hp' => null,
                'email' => null,
            ],
            [
                'nama' => 'Kompol (Purn) Jahja Rumra, S.H.,M.H',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'JR',
                'ttl' => null,
                'nomor_hp' => null,
                'email' => null,
            ],
            [
                'nama' => 'H-JA Dr. H. Tahtu Usman, SH.,MH',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'TU',
                'ttl' => null,
                'nomor_hp' => null,
                'email' => null,
            ],
            [
                'nama' => 'Natasya Auliya Husain, SH.,MH',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'NAH',
                'ttl' => null,
                'nomor_hp' => null,
                'email' => null,
            ],
            [
                'nama' => 'Arie Tri Hartantyo, SE.,MH',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'ATH',
                'ttl' => null,
                'nomor_hp' => '082199073789',
                'email' => 'arie.zidanne@gmail.com',
            ],
            [
                'nama' => 'William Halashon Sinaga, SH.,MH',
                'nidn' => null,
                'nrp_nip' => null,
                'inisial_dosen' => 'WHS',
                'ttl' => null,
                'nomor_hp' => '082166366060',
                'email' => null,
            ],
        ];

        foreach ($dosens as $dosenData) {
            // Tentukan email berdasarkan NIDN atau buat string acak jika kosong
            $emailIdentifier = $dosenData['nidn'] ?? Str::lower($dosenData['inisial_dosen']) . Str::random(5);

            $email = $dosenData['email'] ?? $emailIdentifier . '@siu.ac.id';

            // Cek apakah user dengan email ini sudah ada
            $userExists = User::where('email', $email)->exists();
            if ($userExists) {
                $this->command->warn("User dengan email {$email} sudah ada. Melewati pembuatan untuk dosen: {$dosenData['nama']}");
                continue;
            }

            // 1. Buat Akun User
            $user = User::create([
                'name' => $dosenData['nama'],
                'nrp/nidn/npm' => $emailIdentifier,
                'email' => $email,
                'password' => Hash::make('password'), // Default password
                'role' => 'dosen',
                'email_verified_at' => Carbon::now(),
            ]);

            $this->command->info("Akun user dibuat: {$user->name} ({$user->email})");

            // 2. Buat Data Dosen dan hubungkan dengan user
            Dosen::create([
                'id_user' => $user->id,
                'nama' => $dosenData['nama'],
                'nidn' => $dosenData['nidn'],
                'nrp_nip' => $dosenData['nrp_nip'],
                'inisial_dosen' => $dosenData['inisial_dosen'],
                'ttl' => $dosenData['ttl'],
                'nomor_hp' => $dosenData['nomor_hp'],
            ]);

            $this->command->info("Data dosen dibuat untuk: {$dosenData['nama']}");
        }

        $this->command->info('Seeding Dosen dan Akun User selesai.');
    }
}
