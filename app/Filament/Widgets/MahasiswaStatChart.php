<?php

namespace App\Filament\Widgets;

use App\Models\Mahasiswa;
use Filament\Widgets\ChartWidget;

class MahasiswaStatChart extends ChartWidget
{
    protected ?string $heading = 'Data Jenjang Mahasiswa';

    protected static ?int $sort = 4;

    protected ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $dataMhsPagi = Mahasiswa::where('jenjang', 'sarjana')->where('kelas', 'pagi')->count();
        $dataMhsSore = Mahasiswa::where('jenjang', 'sarjana')->where('kelas', 'sore')->count();
        $dataMhsMagister = Mahasiswa::where('jenjang', 'magister')->count();

        return [
            'labels' => ['S1 - Kelas Pagi', 'S1 - Kelas Sore', 'Magister'],
            'datasets' =>[[
                'label' => 'Banyak Mahasiswa',
                'data' => [$dataMhsPagi, $dataMhsSore, $dataMhsMagister],
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                'hoverOffset' => 4
            ],
            ],


        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
