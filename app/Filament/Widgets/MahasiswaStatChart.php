<?php

namespace App\Filament\Widgets;

use App\Models\Mahasiswa;
use Filament\Widgets\ChartWidget;

class MahasiswaStatChart extends ChartWidget
{
    protected ?string $heading = 'Sebaran Mahasiswa per Jenjang & Kelas';

    protected ?string $description = 'Distribusi mahasiswa aktif berdasarkan program studi';

    protected static ?int $sort = 2;

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $s1Pagi     = Mahasiswa::where('jenjang', 'sarjana')->where('kelas', 'pagi')->count();
        $s1Sore     = Mahasiswa::where('jenjang', 'sarjana')->where('kelas', 'sore')->count();
        $magister   = Mahasiswa::where('jenjang', 'magister')->count();
        $lainnya    = Mahasiswa::whereNotIn('jenjang', ['sarjana', 'magister'])->count();

        return [
            'labels'   => ['S1 Kelas Pagi', 'S1 Kelas Sore', 'Magister (S2)', 'Lainnya'],
            'datasets' => [[
                'label'           => 'Jumlah Mahasiswa',
                'data'            => [$s1Pagi, $s1Sore, $magister, $lainnya],
                'backgroundColor' => [
                    'rgba(99, 102, 241, 0.85)',   // indigo – S1 Pagi
                    'rgba(14, 165, 233, 0.85)',   // sky – S1 Sore
                    'rgba(234, 179, 8, 0.85)',    // yellow – Magister
                    'rgba(148, 163, 184, 0.85)',  // slate – Lainnya
                ],
                'borderColor'     => [
                    'rgba(99, 102, 241, 1)',
                    'rgba(14, 165, 233, 1)',
                    'rgba(234, 179, 8, 1)',
                    'rgba(148, 163, 184, 1)',
                ],
                'borderWidth'  => 2,
                'hoverOffset'  => 6,
            ]],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
