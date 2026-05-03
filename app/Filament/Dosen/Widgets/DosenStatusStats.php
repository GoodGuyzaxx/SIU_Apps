<?php

namespace App\Filament\Dosen\Widgets;

use App\Models\Judul;
use App\Models\Undangan;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DosenStatusStats extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected int | string | array $columnSpan = 'full';

    protected function getHeading(): ?string
    {
        $user  = auth()->user();
        $dosen = $user?->dosen;

        $nama = $dosen?->nama ?? $user?->name ?? 'Dosen';

        $jam  = now()->hour;
        $sapa = match (true) {
            $jam >= 5  && $jam < 12 => 'Selamat Pagi',
            $jam >= 12 && $jam < 15 => 'Selamat Siang',
            $jam >= 15 && $jam < 18 => 'Selamat Sore',
            default                 => 'Selamat Malam',
        };

        return "{$sapa}, {$nama} 👋";
    }

    protected function getDescription(): ?string
    {
        return 'Berikut ringkasan peran Anda sebagai dosen dalam sistem sidang TA.';
    }

    protected function getStats(): array
    {
        $user    = auth()->user();
        $dosen   = $user?->dosen;
        $dosenId = $dosen?->id;

        // ── Pembimbing ─────────────────────────────────────────────────────────
        $pembimbing1 = Judul::where('pembimbing_satu', $dosenId)->count();
        $pembimbing2 = Judul::where('pembimbing_dua', $dosenId)->count();
        $totalPembimbing = $pembimbing1 + $pembimbing2;

        // ── Penguji ────────────────────────────────────────────────────────────
        $penguji1 = Judul::where('penguji_satu', $dosenId)->count();
        $penguji2 = Judul::where('penguji_dua', $dosenId)->count();
        $totalPenguji = $penguji1 + $penguji2;

        // ── Undangan Sidang ────────────────────────────────────────────────────
        $totalUndangan = Undangan::whereHas('judul', function ($q) use ($dosenId) {
            $q->where(function ($sub) use ($dosenId) {
                $sub->where('pembimbing_satu', $dosenId)
                    ->orWhere('pembimbing_dua', $dosenId)
                    ->orWhere('penguji_satu', $dosenId)
                    ->orWhere('penguji_dua', $dosenId);
            });
        })->count();

        $undanganBelumDilaksanakan = Undangan::whereHas('judul', function ($q) use ($dosenId) {
            $q->where(function ($sub) use ($dosenId) {
                $sub->where('pembimbing_satu', $dosenId)
                    ->orWhere('pembimbing_dua', $dosenId)
                    ->orWhere('penguji_satu', $dosenId)
                    ->orWhere('penguji_dua', $dosenId);
            });
        })->where('status_ujian', '!=', 'Selesai')->count();

        return [
            // ── Stat 1: Pembimbing ─────────────────────────────────────────────
            Stat::make('Sebagai Pembimbing', $totalPembimbing . ' Mahasiswa')
                ->description("Pembimbing 1: {$pembimbing1} · Pembimbing 2: {$pembimbing2}")
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->chart([
                    max(0, $totalPembimbing - 4),
                    max(0, $totalPembimbing - 2),
                    max(0, $totalPembimbing - 1),
                    $totalPembimbing,
                ]),

            // ── Stat 2: Penguji ────────────────────────────────────────────────
            Stat::make('Sebagai Penguji', $totalPenguji . ' Mahasiswa')
                ->description("Penguji 1: {$penguji1} · Penguji 2: {$penguji2}")
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning')
                ->chart([
                    max(0, $totalPenguji - 3),
                    max(0, $totalPenguji - 2),
                    max(0, $totalPenguji - 1),
                    $totalPenguji,
                ]),

            // ── Stat 3: Undangan Sidang ────────────────────────────────────────
            Stat::make('Undangan Sidang', $totalUndangan . ' Undangan')
                ->description($undanganBelumDilaksanakan > 0
                    ? "{$undanganBelumDilaksanakan} sidang belum selesai"
                    : 'Semua sidang telah selesai ✅')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->color($undanganBelumDilaksanakan > 0 ? 'danger' : 'success')
                ->chart([
                    max(0, $totalUndangan - 3),
                    max(0, $totalUndangan - 1),
                    $totalUndangan,
                    $totalUndangan,
                ]),
        ];
    }
}
