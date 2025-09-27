<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Daftar gelar akademik
        $gelarDepan = ['Dr.', 'Prof.', 'Prof. Dr.', ''];
        $gelarBelakang = ['S.Kom., M.Kom.', 'S.T., M.T.', 'S.E., M.M.', 'S.H., M.H.', 'S.Pd., M.Pd.',
            'S.Si., M.Si.', 'S.Sos., M.A.', 'S.Psi., M.Psi.', 'S.Ked., M.Kes.', 'S.Farm., M.Farm.',
            'S.Kom., M.T.', 'S.T., M.Kom.', 'S.E., M.Si.', 'S.Si., M.T.', 'S.Pd., M.A.',
            'Ph.D.', 'M.Sc.', 'M.A.', 'M.Phil.', 'M.Eng.'];

        // Daftar nama depan dosen
        $namaDepan = [
            'Ahmad', 'Bambang', 'Catur', 'Dedi', 'Eko', 'Farid', 'Gunawan', 'Hadi', 'Imam', 'Joko',
            'Karim', 'Luthfi', 'Muhammad', 'Nur', 'Omar', 'Putu', 'Qasim', 'Rahmat', 'Sugeng', 'Teguh',
            'Usman', 'Vino', 'Wahyu', 'Yoga', 'Zainul', 'Agus', 'Benny', 'Chandra', 'Darmawan', 'Eddy',
            'Firman', 'Galih', 'Hendra', 'Indra', 'Jefri', 'Kevin', 'Lucky', 'Marvin', 'Nanda', 'Oscar',
            'Pras', 'Qori', 'Ridwan', 'Syahrul', 'Taufik', 'Ucok', 'Victor', 'Wawan', 'Yosef', 'Zulfikar'
        ];

        // Daftar nama belakang dosen
        $namaBelakang = [
            'Pratama', 'Wijaya', 'Santoso', 'Nugraha', 'Setiawan', 'Firmansyah', 'Budiman', 'Suryana',
            'Hermawan', 'Gunawan', 'Ramadhan', 'Hakim', 'Rahman', 'Irawan', 'Adiputra', 'Maulana',
            'Hidayat', 'Syahputra', 'Purwanto', 'Mahendra', 'Suryadi', 'Ardiansyah', 'Kurniawan',
            'Handoko', 'Suharto', 'Prasetyo', 'Wibowo', 'Sutrisno', 'Hartono', 'Sumardi', 'Rustam',
            'Syamsudin', 'Baharuddin', 'Hasanuddin', 'Syaifuddin', 'Jamaluddin', 'Khairuddin', 'Nasruddin',
            'Salahuddin', 'Kamaruddin', 'Fachruddin', 'Nuruddin', 'Alauddin', 'Syamsuddin', 'Ainuddin',
            'Akbar', 'Anwar', 'Ismail', 'Yusuf', 'Ibrahim'
        ];

        $data = [];
        $usedNIDN = [];
        $usedNRP = [];

        // Generate 200 data dosen
        for ($i = 1; $i <= 200; $i++) {
            // Generate NIDN (Nomor Induk Dosen Nasional) - 10 digit
            // Format: DDMMYYYY00 (tanggal lahir + nomor urut)
            do {
                $tanggal = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
                $bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
                $tahun = rand(1960, 1985); // Tahun lahir dosen
                $urut = str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);
                $nidn = $tanggal . $bulan . $tahun . $urut;
            } while (in_array($nidn, $usedNIDN));
            $usedNIDN[] = $nidn;

            // Generate NRP (Nomor Registrasi Pegawai) - 18 digit
            // Format: YYYYMMDD + 10 digit unik
            do {
                $tahunMasuk = rand(1995, 2020);
                $bulanMasuk = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
                $tanggalMasuk = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
                $nomorUnik = str_pad(rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);
                $nrp = $tahunMasuk . $bulanMasuk . $tanggalMasuk . $nomorUnik;
            } while (in_array($nrp, $usedNRP));
            $usedNRP[] = $nrp;

            // Generate nama dengan gelar
            $gelarDpn = $gelarDepan[array_rand($gelarDepan)];
            $namaLengkap = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
            $gelarBlkg = $gelarBelakang[array_rand($gelarBelakang)];

            // Gabungkan nama dengan gelar
            $namaFinal = '';
            if (!empty($gelarDpn)) {
                $namaFinal = $gelarDpn . ' ';
            }
            $namaFinal .= $namaLengkap . ', ' . $gelarBlkg;

            $data[] = [
                'nama' => $namaFinal,
                'nidn' => $nidn,
                'nrp' => $nrp,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data setiap 50 records untuk menghindari memory limit
            if ($i % 50 == 0) {
                DB::table('dosen')->insert($data);
                $data = []; // Reset array
            }
        }

        // Insert sisa data jika ada
        if (!empty($data)) {
            DB::table('dosen')->insert($data);
        }
    }
}
