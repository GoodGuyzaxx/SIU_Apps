<?php

namespace App\Filament\User\Widgets;

use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\Undangan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MahasiswaStats extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected int | string | array $columnSpan = 'full';

    /* ──────────────────────────────────────────────────────────────────────
     |  Sapaan dinamis berdasarkan waktu
     └─────────────────────────────────────────────────────────────────────*/
    protected function getHeading(): ?string
    {
        $user = auth()->user();
        $nama = $user?->mahasiswa?->nama ?? $user?->name ?? 'Mahasiswa';

        $jam  = now()->hour;
        $sapa = match (true) {
            $jam >= 5  && $jam < 12 => 'Selamat Pagi',
            $jam >= 12 && $jam < 15 => 'Selamat Siang',
            $jam >= 15 && $jam < 18 => 'Selamat Sore',
            default                 => 'Selamat Malam',
        };

        return "{$sapa}, {$nama} 🎓";
    }

    protected function getDescription(): ?string
    {
        return 'Pantau progress Tugas Akhir Anda di sini.';
    }

    /* ──────────────────────────────────────────────────────────────────────
     |  Stats
     └─────────────────────────────────────────────────────────────────────*/
    protected function getStats(): array
    {
        $user        = auth()->user();
        $mahasiswa   = Mahasiswa::where('id_user', $user?->id)->first();

        // Jika data mahasiswa belum ada, kembalikan stat kosong
        if (! $mahasiswa) {
            return [
                Stat::make('Profil Belum Lengkap', '⚠️')
                    ->description('Silakan lengkapi data profil Anda terlebih dahulu')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('warning'),
            ];
        }

        // ── Data Judul ─────────────────────────────────────────────────────
        $judul = Judul::with('nilai')
            ->where('id_mahasiswa', $mahasiswa->id)
            ->first();

        // ── Status Judul ───────────────────────────────────────────────────
        $statusJudul  = $judul?->status ?? 'Belum Ada';
        $judulColor   = match (strtolower($statusJudul)) {
            'disetujui', 'acc' => 'success',
            'ditolak'          => 'danger',
            'menunggu'         => 'warning',
            default            => 'gray',
        };
        $judulIcon    = match (strtolower($statusJudul)) {
            'disetujui', 'acc' => 'heroicon-m-check-badge',
            'ditolak'          => 'heroicon-m-x-circle',
            default            => 'heroicon-m-clock',
        };

        // ── Pembimbing & Penguji sudah ditentukan? ─────────────────────────
        $hasPembimbing = $judul && ($judul->pembimbing_satu || $judul->pembimbing_dua);
        $hasPenguji    = $judul && ($judul->penguji_satu || $judul->penguji_dua);

        $timDesc = match (true) {
            $hasPembimbing && $hasPenguji => 'Pembimbing & Penguji sudah ditentukan ✅',
            $hasPembimbing                => 'Pembimbing sudah ditentukan, penguji belum',
            default                       => 'Tim dosen belum ditentukan',
        };

        // ── Undangan Sidang ────────────────────────────────────────────────
        $undangan = $judul
            ? Undangan::where('id_judul', $judul->id)->latest()->first()
            : null;

        $statusUjian = $undangan?->status_ujian ?? null;
        $undanganLabel = match ($statusUjian) {
            'dijadwalkan'              => 'Dijadwalkan',
            'draft_uploaded'           => 'Draft Diupload',
            'ready_to_exam'            => 'Siap Ujian 🟢',
            'selesai'                  => 'Ujian Selesai ✅',
            'gagal_menjadwalkan_ujian' => 'Gagal Dijadwalkan ❌',
            default                    => 'Belum Ada Undangan',
        };
        $undanganColor = match ($statusUjian) {
            'selesai'                  => 'success',
            'ready_to_exam'            => 'info',
            'gagal_menjadwalkan_ujian' => 'danger',
            'dijadwalkan',
            'draft_uploaded'           => 'warning',
            default                    => 'gray',
        };

        // ── Nilai ──────────────────────────────────────────────────────────
        $nilai         = $judul?->nilai;
        $nilaiProposal = $nilai?->nilai_proposal ?? null;
        $nilaiHasil    = $nilai?->nilai_hasil    ?? null;

        $nilaiDisplay = match (true) {
            $nilaiProposal && $nilaiHasil => "Proposal: {$nilaiProposal} · Hasil: {$nilaiHasil}",
            (bool) $nilaiProposal         => "Proposal: {$nilaiProposal} · Hasil: Belum dinilai",
            default                       => 'Nilai belum tersedia',
        };
        $nilaiAngka = $nilaiHasil ?? $nilaiProposal ?? null;
        $nilaiColor = match (true) {
            $nilaiAngka >= 80             => 'success',
            $nilaiAngka >= 60             => 'warning',
            $nilaiAngka !== null          => 'danger',
            default                       => 'gray',
        };

        return [
            // ── Stat 1: Status Judul ───────────────────────────────────────
            Stat::make('Status Judul TA', $judul ? $statusJudul : 'Belum Diajukan')
                ->description($judul
                    ? 'Judul: ' . \Illuminate\Support\Str::limit($judul->judul, 50)
                    : 'Anda belum memiliki judul yang disetujui')
                ->descriptionIcon($judulIcon)
                ->color($judulColor)
                ->chart([1, 1, 1, $judul ? 4 : 1]),

            // ── Stat 2: Tim Dosen ──────────────────────────────────────────
            Stat::make('Tim Dosen', $hasPembimbing ? ($hasPenguji ? 'Lengkap' : 'Sebagian') : 'Belum Ada')
                ->description($timDesc)
                ->descriptionIcon('heroicon-m-user-group')
                ->color($hasPembimbing && $hasPenguji ? 'success' : ($hasPembimbing ? 'warning' : 'gray'))
                ->chart([1, 1, $hasPembimbing ? 3 : 1, $hasPenguji ? 4 : 1]),

            // ── Stat 3: Undangan Sidang ────────────────────────────────────
            Stat::make('Undangan Sidang', $undanganLabel)
                ->description($undangan
                    ? 'Tanggal: ' . ($undangan->tanggal_hari
                        ? \Carbon\Carbon::parse($undangan->tanggal_hari)->translatedFormat('d M Y')
                        : '-')
                    : 'Belum ada undangan sidang')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($undanganColor)
                ->chart([1, 1, $undangan ? 3 : 1, $undangan ? 4 : 1]),

            // ── Stat 4: Nilai ──────────────────────────────────────────────
            Stat::make('Nilai Akhir', $nilaiAngka !== null ? (string) $nilaiAngka : 'Belum Ada')
                ->description($nilaiDisplay)
                ->descriptionIcon('heroicon-m-star')
                ->color($nilaiColor)
                ->chart([
                    max(0, ($nilaiAngka ?? 0) - 20),
                    max(0, ($nilaiAngka ?? 0) - 10),
                    max(0, ($nilaiAngka ?? 0) - 5),
                    $nilaiAngka ?? 0,
                ]),
        ];
    }
}
