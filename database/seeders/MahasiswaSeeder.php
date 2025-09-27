<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaDepan = [
            'Ahmad', 'Budi', 'Citra', 'Dina', 'Eko', 'Fitri', 'Gilang', 'Hani', 'Indra', 'Joko',
            'Kartika', 'Lina', 'Maman', 'Nina', 'Omar', 'Putri', 'Qori', 'Rina', 'Sari', 'Toni',
            'Udin', 'Vina', 'Wati', 'Xavi', 'Yuni', 'Zaki', 'Adi', 'Bela', 'Candra', 'Dewi',
            'Erin', 'Fajar', 'Gita', 'Hendra', 'Ika', 'Jaya', 'Kiki', 'Lisa', 'Maya', 'Nanda',
            'Oki', 'Pandu', 'Queen', 'Rudi', 'Sinta', 'Tara', 'Ulfa', 'Vera', 'Winda', 'Yoga'
        ];

        // Daftar nama belakang
        $namaBelakang = [
            'Pratama', 'Sari', 'Wijaya', 'Utama', 'Santoso', 'Permata', 'Kusuma', 'Maharani', 'Putra', 'Dewi',
            'Handoko', 'Rahayu', 'Nugraha', 'Lestari', 'Saputra', 'Wulandari', 'Setiawan', 'Anggraini', 'Firmansyah', 'Safitri',
            'Budiman', 'Oktaviani', 'Suryana', 'Puspita', 'Hermawan', 'Cahyani', 'Gunawan', 'Indrawati', 'Kurniawan', 'Damayanti',
            'Ramadhan', 'Sulistiani', 'Hakim', 'Kartini', 'Rahman', 'Melati', 'Irawan', 'Fitriani', 'Adiputra', 'Salsabila',
            'Maulana', 'Azzahra', 'Hidayat', 'Nabila', 'Syahputra', 'Amelia', 'Purwanto', 'Zahra', 'Mahendra', 'Aulia'
        ];

        // Daftar fakultas
        $fakultas = [
            'Fakultas Teknik',
            'Fakultas Ekonomi dan Bisnis',
            'Fakultas Ilmu Komputer',
            'Fakultas Kedokteran',
            'Fakultas Hukum',
            'Fakultas Ilmu Sosial dan Politik',
            'Fakultas Pendidikan',
            'Fakultas Sastra',
            'Fakultas Matematika dan IPA',
            'Fakultas Pertanian'
        ];

        // Daftar program studi berdasarkan fakultas
        $programStudi = [
            'Fakultas Teknik' => ['Teknik Informatika', 'Teknik Sipil', 'Teknik Mesin', 'Teknik Elektro', 'Arsitektur'],
            'Fakultas Ekonomi dan Bisnis' => ['Manajemen', 'Akuntansi', 'Ekonomi Pembangunan', 'Bisnis Digital'],
            'Fakultas Ilmu Komputer' => ['Ilmu Komputer', 'Sistem Informasi', 'Teknologi Informasi'],
            'Fakultas Kedokteran' => ['Pendidikan Dokter', 'Kedokteran Gigi', 'Farmasi', 'Keperawatan'],
            'Fakultas Hukum' => ['Ilmu Hukum', 'Hukum Bisnis'],
            'Fakultas Ilmu Sosial dan Politik' => ['Ilmu Komunikasi', 'Hubungan Internasional', 'Administrasi Publik'],
            'Fakultas Pendidikan' => ['PGSD', 'Pendidikan Bahasa Indonesia', 'Pendidikan Matematika', 'Pendidikan Fisika'],
            'Fakultas Sastra' => ['Sastra Indonesia', 'Sastra Inggris', 'Bahasa dan Budaya Jepang'],
            'Fakultas Matematika dan IPA' => ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Statistika'],
            'Fakultas Pertanian' => ['Agroteknologi', 'Agribisnis', 'Kehutanan']
        ];

        $data = [];

        // Generate 1000 data mahasiswa
        for ($i = 1; $i <= 100000; $i++) {
            // Generate NPM dengan format: tahun + fakultas kode + nomor urut
            $tahunMasuk = rand(2020, 2024);
            $kodeUrut = str_pad($i, 4, '0', STR_PAD_LEFT);
            $npm = $tahunMasuk . rand(1, 9) . $kodeUrut;

            // Random nama
            $namaLengkap = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];

            // Random fakultas
            $selectedFakultas = $fakultas[array_rand($fakultas)];

            // Random program studi sesuai fakultas
            $selectedProdi = $programStudi[$selectedFakultas][array_rand($programStudi[$selectedFakultas])];

            $data[] = [
                'nama' => $namaLengkap,
                'npm' => $npm,
                'fakultas' => $selectedFakultas,
                'program_studi' => $selectedProdi,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data setiap 100 records untuk menghindari memory limit
            if ($i % 100 == 0) {
                DB::table('mahasiswa')->insert($data);
                $data = []; // Reset array
            }
        }

        // Insert sisa data jika ada
        if (!empty($data)) {
            DB::table('mahasiswas')->insert($data);
        }
    }
}
