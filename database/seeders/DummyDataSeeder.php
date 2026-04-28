<?php

namespace Database\Seeders;

use App\Models\AccKesiapanUjian;
use App\Models\Dosen;
use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\TahunAkademik;
use App\Models\Undangan;
use App\Models\User;
use App\Models\UsulanJudul;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    // ── Konfigurasi jumlah data ───────────────────────────────────
    const TOTAL_MAHASISWA = 100;

    // ── Pool nama Indonesia ───────────────────────────────────────
    private array $namaDepan = [
        'Ahmad', 'Budi', 'Citra', 'Dina', 'Eko', 'Fitri', 'Gilang', 'Hani', 'Indra', 'Joko',
        'Kartika', 'Lina', 'Maman', 'Nina', 'Omar', 'Putri', 'Rina', 'Sari', 'Toni', 'Yuni',
        'Adi', 'Bela', 'Candra', 'Dewi', 'Erin', 'Fajar', 'Gita', 'Hendra', 'Ika', 'Jaya',
        'Kiki', 'Lisa', 'Maya', 'Nanda', 'Pandu', 'Rudi', 'Sinta', 'Tara', 'Ulfa', 'Vera',
        'Winda', 'Yoga', 'Zaki', 'Angga', 'Bella', 'Dani', 'Eka', 'Fuad', 'Galih', 'Hana',
    ];

    private array $namaBelakang = [
        'Pratama', 'Sari', 'Wijaya', 'Utama', 'Santoso', 'Permata', 'Kusuma', 'Maharani', 'Putra', 'Dewi',
        'Handoko', 'Rahayu', 'Nugraha', 'Lestari', 'Saputra', 'Wulandari', 'Setiawan', 'Anggraini', 'Firmansyah', 'Safitri',
        'Budiman', 'Oktaviani', 'Suryana', 'Puspita', 'Hermawan', 'Cahyani', 'Gunawan', 'Kurniawan', 'Damayanti', 'Ramadhan',
        'Hakim', 'Kartini', 'Rahman', 'Melati', 'Irawan', 'Fitriani', 'Maulana', 'Azzahra', 'Hidayat', 'Nabila',
        'Syahputra', 'Amelia', 'Purwanto', 'Zahra', 'Mahendra', 'Aulia', 'Nurani', 'Sasmita', 'Wibowo', 'Hastuti',
    ];

    private array $judulTopikHukum = [
        'Analisis Hukum Terhadap Perlindungan Konsumen dalam Transaksi Elektronik',
        'Tinjauan Yuridis Pelaksanaan Perjanjian Kredit Perbankan',
        'Kajian Hukum Pidana Terhadap Tindak Pidana Korupsi di Sektor Publik',
        'Perlindungan Hukum Bagi Pekerja Kontrak dalam Perspektif Hukum Ketenagakerjaan',
        'Analisis Hukum Pertanahan Terhadap Sengketa Tanah Adat',
        'Tinjauan Hukum Internasional Tentang Perlindungan Pengungsi',
        'Implementasi Asas Keadilan dalam Putusan Mahkamah Agung',
        'Efektivitas Penegakan Hukum Lingkungan Hidup di Era Otonomi Daerah',
        'Perlindungan Hukum Terhadap Anak Korban Kejahatan Siber',
        'Kajian Hukum Waris Adat dan Implikasinya dalam Hukum Positif',
        'Analisis Yuridis Terhadap Pelanggaran Hak Kekayaan Intelektual',
        'Tinjauan Hukum Terhadap Praktik Monopoli dan Persaingan Usaha Tidak Sehat',
        'Perlindungan Hukum bagi Korban Tindak Pidana Perdagangan Orang',
        'Implementasi Hak Asasi Manusia dalam Sistem Pemasyarakatan Indonesia',
        'Kajian Hukum Acara Perdata Tentang Pembuktian dalam Sengketa Bisnis',
        'Analisis Hukum Terhadap Kontrak Bagi Hasil Pertambangan',
        'Efektivitas Mediasi Sebagai Alternatif Penyelesaian Sengketa',
        'Tinjauan Yuridis Hukum Pajak Daerah dan Retribusi Daerah',
        'Perlindungan Hukum Investor Asing dalam Kerangka Penanaman Modal',
        'Kajian Hukum Tentang Tanggung Jawab Notaris dalam Pembuatan Akta',
    ];

    private array $minat = ['Hukum Perdata', 'Hukum Pidana', 'Hukum Tata Negara', 'Hukum Internasional', 'Hukum Administrasi Negara'];

    private array $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];

    private array $kelas = ['pagi', 'sore'];

    private array $jenjang = ['sarjana', 'sarjana', 'sarjana', 'magister']; // lebih banyak sarjana

    public function run(): void
    {
        $this->command->info('🚀 Memulai seeding data dummy...');

        // ── Bersihkan data dummy sebelumnya ───────────────────────
        $this->command->info('🧹 Membersihkan data mahasiswa dummy sebelumnya...');
        $oldUsers = User::where('role', 'mahasiswa')
            ->where('email', 'like', 'mhs.%@siu.ac.id')
            ->pluck('id');

        if ($oldUsers->isNotEmpty()) {
            // Hapus relasi berantai
            $mahasiswaIds = Mahasiswa::whereIn('id_user', $oldUsers)->pluck('id');
            $judulIds     = Judul::whereIn('id_mahasiswa', $mahasiswaIds)->pluck('id');

            AccKesiapanUjian::whereIn('id_undangan',
                Undangan::whereIn('id_judul', $judulIds)->pluck('id')
            )->forceDelete();

            Undangan::whereIn('id_judul', $judulIds)->forceDelete();
            UsulanJudul::whereIn('id_mahasiswa', $mahasiswaIds)->forceDelete();
            Judul::whereIn('id', $judulIds)->forceDelete();
            Mahasiswa::whereIn('id', $mahasiswaIds)->forceDelete();
            User::whereIn('id', $oldUsers)->forceDelete();

            $this->command->info("   ✅ {$oldUsers->count()} user mahasiswa dummy dihapus.");
        }

        // ── Pastikan ada TahunAkademik aktif ─────────────────────
        $tahunAkademik = $this->ensureTahunAkademik();

        // ── Ambil semua Prodi & Dosen ─────────────────────────────
        $prodis = Prodi::all();
        $dosens = Dosen::all();

        if ($prodis->isEmpty()) {
            $this->command->error('❌ Tidak ada data Prodi! Jalankan ProdiSeeder terlebih dahulu.');
            return;
        }

        if ($dosens->count() < 4) {
            $this->command->error('❌ Minimal 4 Dosen dibutuhkan! Jalankan DosenSeeder terlebih dahulu.');
            return;
        }

        $this->command->info("✅ TahunAkademik: {$tahunAkademik->takad} ({$tahunAkademik->priode})");
        $this->command->info("✅ Prodi tersedia: {$prodis->count()}");
        $this->command->info("✅ Dosen tersedia: {$dosens->count()}");

        $bar = $this->command->getOutput()->createProgressBar(self::TOTAL_MAHASISWA);
        $bar->start();

        for ($i = 1; $i <= self::TOTAL_MAHASISWA; $i++) {
            $nama       = $this->randomNama();
            $tahunMasuk = rand(2020, 2024);
            $npm        = $tahunMasuk . str_pad($i, 5, '0', STR_PAD_LEFT);
            $email      = 'mhs.' . strtolower(Str::slug($nama)) . '.' . $npm . '@siu.ac.id';
            $prodi      = $prodis->random();
            $jenjang    = $this->jenjang[array_rand($this->jenjang)];

            // Pastikan email unik
            if (User::where('email', $email)->exists()) {
                $email = 'mhs.' . $npm . '@siu.ac.id';
            }

            // ── 1. Buat User ──────────────────────────────────────
            $user = User::create([
                'prodi_id'         => $prodi->id,
                'name'             => $nama,
                'nrp/nidn/npm'     => $npm,
                'email'            => $email,
                'role'             => 'mahasiswa',
                'password'         => Hash::make('password'),
                'email_verified_at'=> Carbon::now(),
            ]);

            // ── 2. Buat Mahasiswa ─────────────────────────────────
            $mahasiswa = Mahasiswa::create([
                'id_user'  => $user->id,
                'prodi_id' => $prodi->id,
                'nama'     => $nama,
                'npm'      => $npm,
                'kelas'    => $this->kelas[array_rand($this->kelas)],
                'jenjang'  => $jenjang,
                'agama'    => $this->agama[array_rand($this->agama)],
                'nomor_hp' => '08' . rand(100000000, 999999999),
                'angkatan' => (string) $tahunMasuk,
            ]);

            // ── 3. Tentukan tahap berdasarkan segmen (distribusi realistis) ──
            // Segmentasi:
            // 1-20  : hanya UsulanJudul (Pengajuan/Ditolak)
            // 21-40 : UsulanJudul Diproses/Diterima + Judul "pengajuan"
            // 41-60 : Judul "proposal" + Nilai proposal
            // 61-80 : Judul "hasil" + Nilai proposal & hasil
            // 81-100: Undangan ujian + ACC Kesiapan

            $this->seedAlurMahasiswa($i, $mahasiswa, $tahunAkademik, $dosens);

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine(2);
        $this->command->info('✅ Seeding data dummy selesai!');
        $this->printSummary();
    }

    // ──────────────────────────────────────────────────────────────
    // ALUR SEEDING PER MAHASISWA
    // ──────────────────────────────────────────────────────────────
    private function seedAlurMahasiswa(int $index, Mahasiswa $mahasiswa, TahunAkademik $takad, $dosens): void
    {
        // Segmen 1 (1-20): UsulanJudul pending/ditolak — belum ada Judul
        if ($index <= 20) {
            $status = $index <= 10 ? 'Pengajuan' : 'Ditolak';
            UsulanJudul::create([
                'id_mahasiswa'    => $mahasiswa->id,
                'minat_kekuhusan' => $this->minat[array_rand($this->minat)],
                'judul_satu'      => $this->randomJudul(),
                'judul_dua'       => $this->randomJudul(),
                'judul_tiga'      => $this->randomJudul(),
                'status'          => $status,
                'catatan'         => $status === 'Ditolak' ? 'Judul tidak sesuai dengan bidang kajian.' : null,
            ]);
            return;
        }

        // Segmen 2 (21-40): UsulanJudul Diproses → Judul tahap "pengajuan"
        if ($index <= 40) {
            UsulanJudul::create([
                'id_mahasiswa'    => $mahasiswa->id,
                'minat_kekuhusan' => $this->minat[array_rand($this->minat)],
                'judul_satu'      => $this->randomJudul(),
                'judul_dua'       => $this->randomJudul(),
                'judul_tiga'      => $this->randomJudul(),
                'status'          => 'Diproses',
                'catatan'         => null,
            ]);

            $judul = $this->buatJudul($mahasiswa, $takad, $dosens, 'pengajuan');
            return;
        }

        // Segmen 3 (41-60): Judul "proposal" + nilai proposal terisi
        if ($index <= 60) {
            UsulanJudul::create([
                'id_mahasiswa'    => $mahasiswa->id,
                'minat_kekuhusan' => $this->minat[array_rand($this->minat)],
                'judul_satu'      => $this->randomJudul(),
                'judul_dua'       => $this->randomJudul(),
                'judul_tiga'      => $this->randomJudul(),
                'status'          => 'Diterima',
                'catatan'         => null,
            ]);

            $judul = $this->buatJudul($mahasiswa, $takad, $dosens, 'proposal');

            // Update nilai proposal
            $tglProposal = Carbon::now()->subMonths(rand(1, 6))->subDays(rand(0, 20));
            $judul->nilai()->update([
                'nilai_proposal'        => rand(60, 100),
                'tanggal_ujian_proposal'=> $tglProposal->toDateString(),
            ]);
            return;
        }

        // Segmen 4 (61-80): Judul "hasil" + nilai proposal & hasil terisi
        if ($index <= 80) {
            UsulanJudul::create([
                'id_mahasiswa'    => $mahasiswa->id,
                'minat_kekuhusan' => $this->minat[array_rand($this->minat)],
                'judul_satu'      => $this->randomJudul(),
                'judul_dua'       => $this->randomJudul(),
                'judul_tiga'      => $this->randomJudul(),
                'status'          => 'Diterima',
                'catatan'         => null,
            ]);

            $judul = $this->buatJudul($mahasiswa, $takad, $dosens, 'hasil');

            $tglProposal = Carbon::now()->subMonths(rand(4, 10));
            $tglHasil    = $tglProposal->copy()->addMonths(rand(2, 5));
            $judul->nilai()->update([
                'nilai_proposal'        => rand(60, 100),
                'tanggal_ujian_proposal'=> $tglProposal->toDateString(),
                'nilai_hasil'           => rand(65, 100),
                'tanggal_ujian_hasil'   => $tglHasil->toDateString(),
            ]);
            return;
        }

        // Segmen 5 (81-100): Undangan ujian + ACC Kesiapan Ujian
        UsulanJudul::create([
            'id_mahasiswa'    => $mahasiswa->id,
            'minat_kekuhusan' => $this->minat[array_rand($this->minat)],
            'judul_satu'      => $this->randomJudul(),
            'judul_dua'       => $this->randomJudul(),
            'judul_tiga'      => $this->randomJudul(),
            'status'          => 'Diterima',
            'catatan'         => null,
        ]);

        // Alternasi antara undangan proposal dan skripsi
        $isProposal   = $index <= 90;
        $statusJudul  = $isProposal ? 'proposal' : 'hasil';
        $perihal      = $isProposal ? 'Undangan Ujian Proposal' : 'Undangan Ujian Skripsi';
        $statusUjian  = $isProposal ? 'proposal' : 'skripsi';

        $judul = $this->buatJudul($mahasiswa, $takad, $dosens, $statusJudul);

        // Update nilai sesuai status
        $tglProposal = Carbon::now()->subMonths(rand(2, 8));
        $nilaiUpdate = ['nilai_proposal' => rand(60, 100), 'tanggal_ujian_proposal' => $tglProposal->toDateString()];
        if (!$isProposal) {
            $nilaiUpdate['nilai_hasil']           = rand(65, 100);
            $nilaiUpdate['tanggal_ujian_hasil']   = $tglProposal->copy()->addMonths(rand(2, 4))->toDateString();
        }
        $judul->nilai()->update($nilaiUpdate);

        // Buat Undangan
        $nomorUrut  = str_pad($index - 80, 3, '0', STR_PAD_LEFT);
        $tanggalUjian = Carbon::now()->addDays(rand(1, 30));
        $undangan = Undangan::create([
            'id_judul'    => $judul->id,
            'nomor'       => "{$nomorUrut}/SK/UNINGRAT/{$tanggalUjian->format('Y')}",
            'perihal'     => $perihal,
            'tanggal_hari'=> $tanggalUjian->toDateString(),
            'waktu'       => sprintf('%02d:%02d', rand(8, 15), [0, 30][rand(0, 1)]),
            'tempat'      => collect(['Ruang Sidang A', 'Ruang Sidang B', 'Aula Utama', 'Ruang Dosen'])->random(),
            'meeting_id'  => null,
            'passcode'    => null,
            'signed'      => rand(0, 1),
            'status_ujian'=> $statusUjian,
        ]);

        // Buat ACC Kesiapan Ujian untuk semua dosen penguji & pembimbing
        $dosenRoles = [
            ['id_dosen' => $judul->pembimbing_satu, 'role' => 'pembimbing_satu'],
            ['id_dosen' => $judul->pembimbing_dua,  'role' => 'pembimbing_dua'],
            ['id_dosen' => $judul->penguji_satu,    'role' => 'penguji_satu'],
            ['id_dosen' => $judul->penguji_dua,     'role' => 'penguji_dua'],
        ];

        $statusAcc = ['pending', 'pending', 'disetujui', 'disetujui', 'disetujui', 'ditolak'];

        foreach ($dosenRoles as $dr) {
            if (!$dr['id_dosen']) continue;

            $accStatus = $statusAcc[array_rand($statusAcc)];
            AccKesiapanUjian::create([
                'id_undangan'       => $undangan->id,
                'id_dosen'          => $dr['id_dosen'],
                'role'              => $dr['role'],
                'status'            => $accStatus,
                'alasan_penolakan'  => $accStatus === 'ditolak' ? 'Jadwal bentrok dengan kegiatan lain.' : null,
                'responded_at'      => $accStatus !== 'pending' ? Carbon::now()->subHours(rand(1, 48)) : null,
            ]);
        }
    }

    // ──────────────────────────────────────────────────────────────
    // HELPERS
    // ──────────────────────────────────────────────────────────────
    private function buatJudul(Mahasiswa $mahasiswa, TahunAkademik $takad, $dosens, string $status): Judul
    {
        $shuffled = $dosens->shuffle();

        return Judul::create([
            'id_mahasiswa'    => $mahasiswa->id,
            'tahun_akademik_id'=> $takad->id,
            'minat'           => $this->minat[array_rand($this->minat)],
            'judul'           => $this->randomJudul(),
            'pembimbing_satu' => $shuffled->get(0)?->id,
            'pembimbing_dua'  => $shuffled->get(1)?->id,
            'penguji_satu'    => $shuffled->get(2)?->id,
            'penguji_dua'     => $shuffled->get(3)?->id,
            'status'          => $status,
        ]);
        // Catatan: Judul::booted() otomatis membuat Nilai & SuratKeputusan terkait
    }

    private function ensureTahunAkademik(): TahunAkademik
    {
        $existing = TahunAkademik::where('status', 'Y')->first();
        if ($existing) return $existing;

        return TahunAkademik::create([
            'takad'   => '2024/2025',
            'priode'  => 'Genap',
            'tahun'   => '2025',
            'status'  => 'Y',
        ]);
    }

    private function randomNama(): string
    {
        return $this->namaDepan[array_rand($this->namaDepan)]
             . ' '
             . $this->namaBelakang[array_rand($this->namaBelakang)];
    }

    private function randomJudul(): string
    {
        $base  = $this->judulTopikHukum[array_rand($this->judulTopikHukum)];
        $tahun = rand(2020, 2024);
        return $base . " (Studi Kasus Tahun {$tahun})";
    }

    private function printSummary(): void
    {
        $this->command->table(
            ['Model', 'Jumlah Data'],
            [
                ['User (mahasiswa)', User::where('role', 'mahasiswa')->count()],
                ['Mahasiswa',        Mahasiswa::count()],
                ['UsulanJudul',      UsulanJudul::count()],
                ['Judul',            Judul::count()],
                ['Undangan',         Undangan::count()],
                ['AccKesiapanUjian', AccKesiapanUjian::count()],
            ]
        );
    }
}
