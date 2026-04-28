<?php

namespace App\Filament\Widgets;

use App\Models\Judul;
use App\Models\UsulanJudul;
use Filament\Widgets\ChartWidget;

class JudulProgressChart extends ChartWidget
{
    protected ?string $heading = 'Progres Judul Mahasiswa';

    protected ?string $description = 'Alur status dari pengajuan hingga skripsi selesai';

    protected static ?int $sort = 3;

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $pengajuan  = UsulanJudul::where('status', 'Pengajuan')->count();
        $diproses   = UsulanJudul::where('status', 'Diproses')->count();
        $ditolak    = UsulanJudul::where('status', 'Ditolak')->count();
        $proposal   = Judul::where('status', 'proposal')->count();
        $skripsi    = Judul::where('status', 'hasil')->count();
        $selesai    = Judul::where('status', 'selesai')->count();

        return [
            'labels'   => [
                'Menunggu Seleksi',
                'Sedang Diproses',
                'Ditolak',
                'Tahap Proposal',
                'Tahap Skripsi',
                'Selesai / Lulus',
            ],
            'datasets' => [[
                'label'           => 'Jumlah',
                'data'            => [$pengajuan, $diproses, $ditolak, $proposal, $skripsi, $selesai],
                'backgroundColor' => [
                    'rgba(251, 191, 36, 0.8)',   // amber  – menunggu
                    'rgba(14, 165, 233, 0.8)',   // sky    – diproses
                    'rgba(239, 68, 68, 0.8)',    // red    – ditolak
                    'rgba(99, 102, 241, 0.8)',   // indigo – proposal
                    'rgba(168, 85, 247, 0.8)',   // purple – skripsi
                    'rgba(34, 197, 94, 0.8)',    // green  – selesai
                ],
                'borderColor'     => [
                    'rgba(251, 191, 36, 1)',
                    'rgba(14, 165, 233, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(99, 102, 241, 1)',
                    'rgba(168, 85, 247, 1)',
                    'rgba(34, 197, 94, 1)',
                ],
                'borderWidth'     => 2,
                'borderRadius'    => 6,
            ]],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
