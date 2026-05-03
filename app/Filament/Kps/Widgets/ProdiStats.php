<?php

namespace App\Filament\Kps\Widgets;

use App\Models\Judul;
use App\Models\Mahasiswa;
use App\Models\Undangan;
use App\Models\UsulanJudul;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class ProdiStats extends StatsOverviewWidget
{
    protected static ?int $sort = -2;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $user    = auth()->user();
        $prodiId = $user?->prodi_id;

        // ── Mahasiswa di prodi ini ──────────────────────────────────────────
        $totalMahasiswa = Mahasiswa::where('prodi_id', $prodiId)->count();

        // ── Pengajuan Judul ─────────────────────────────────────────────────
        $pengajuanQuery = UsulanJudul::whereHas('mahasiswa', fn(Builder $q) =>
            $q->where('prodi_id', $prodiId)
        );

        $totalPengajuan  = (clone $pengajuanQuery)->count();
        $pengajuanMenunggu = (clone $pengajuanQuery)->where('status', 'Menunggu')->count();
        $pengajuanDisetujui = (clone $pengajuanQuery)->whereIn('status', ['Disetujui', 'ACC'])->count();
        $pengajuanDitolak = (clone $pengajuanQuery)->where('status', 'Ditolak')->count();

        // ── Judul Aktif ─────────────────────────────────────────────────────
        $totalJudul = Judul::whereHas('mahasiswa', fn(Builder $q) =>
            $q->where('prodi_id', $prodiId)
        )->count();

        // ── Undangan Sidang ─────────────────────────────────────────────────
        $totalUndangan = Undangan::whereHas('judul.mahasiswa', fn(Builder $q) =>
            $q->where('prodi_id', $prodiId)
        )->count();

        return [
            Stat::make('Total Mahasiswa', $totalMahasiswa)
                ->description('Mahasiswa terdaftar di prodi ini')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->chart([
                    max(0, $totalMahasiswa - 5),
                    max(0, $totalMahasiswa - 3),
                    max(0, $totalMahasiswa - 1),
                    $totalMahasiswa,
                ]),

            Stat::make('Pengajuan Judul', $totalPengajuan)
                ->description("{$pengajuanMenunggu} Menunggu · {$pengajuanDisetujui} Disetujui · {$pengajuanDitolak} Ditolak")
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pengajuanMenunggu > 0 ? 'warning' : 'success')
                ->chart([
                    max(0, $totalPengajuan - 3),
                    max(0, $totalPengajuan - 2),
                    max(0, $totalPengajuan - 1),
                    $totalPengajuan,
                ]),

            Stat::make('Judul Disetujui', $totalJudul)
                ->description('Total judul TA yang aktif di prodi')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('success')
                ->chart([
                    max(0, $totalJudul - 4),
                    max(0, $totalJudul - 2),
                    max(0, $totalJudul - 1),
                    $totalJudul,
                ]),

            Stat::make('Undangan Sidang', $totalUndangan)
                ->description('Total undangan sidang yang telah dibuat')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary')
                ->chart([
                    max(0, $totalUndangan - 3),
                    max(0, $totalUndangan - 1),
                    $totalUndangan,
                    $totalUndangan,
                ]),
        ];
    }
}
