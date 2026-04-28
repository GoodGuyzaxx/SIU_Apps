<?php

namespace App\Filament\Widgets;

use App\Models\Undangan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class UndanganPerBulanChart extends ChartWidget
{
    protected ?string $heading = 'Tren Undangan Ujian (6 Bulan Terakhir)';

    protected ?string $description = 'Jumlah undangan ujian yang dibuat per bulan';

    protected static ?int $sort = 4;

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $labels   = [];
        $proposal = [];
        $skripsi  = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->locale('id')->isoFormat('MMM YY');

            $proposal[] = Undangan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('perihal', 'like', '%Proposal%')
                ->count();

            $skripsi[] = Undangan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('perihal', 'like', '%Skripsi%')
                ->count();
        }

        return [
            'labels'   => $labels,
            'datasets' => [
                [
                    'label'           => 'Ujian Proposal',
                    'data'            => $proposal,
                    'borderColor'     => 'rgba(99, 102, 241, 1)',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.15)',
                    'pointBackgroundColor' => 'rgba(99, 102, 241, 1)',
                    'pointRadius'     => 5,
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
                [
                    'label'           => 'Ujian Skripsi',
                    'data'            => $skripsi,
                    'borderColor'     => 'rgba(168, 85, 247, 1)',
                    'backgroundColor' => 'rgba(168, 85, 247, 0.15)',
                    'pointBackgroundColor' => 'rgba(168, 85, 247, 1)',
                    'pointRadius'     => 5,
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
