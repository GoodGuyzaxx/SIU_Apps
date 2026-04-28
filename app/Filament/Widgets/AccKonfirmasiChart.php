<?php

namespace App\Filament\Widgets;

use App\Models\AccKesiapanUjian;
use Filament\Widgets\ChartWidget;

class AccKonfirmasiChart extends ChartWidget
{
    protected ?string $heading = 'Status ACC Kesiapan Ujian';

    protected ?string $description = 'Rekapan konfirmasi kesiapan ujian dari dosen';

    protected static ?int $sort = 5;

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $pending   = AccKesiapanUjian::where('status', 'pending')->count();
        $disetujui = AccKesiapanUjian::where('status', 'disetujui')->count();
        $ditolak   = AccKesiapanUjian::where('status', 'ditolak')->count();

        return [
            'labels'   => ['Menunggu', 'Disetujui', 'Ditolak'],
            'datasets' => [[
                'label'           => 'Jumlah ACC',
                'data'            => [$pending, $disetujui, $ditolak],
                'backgroundColor' => [
                    'rgba(251, 191, 36, 0.85)',  // amber  – pending
                    'rgba(34, 197, 94, 0.85)',   // green  – disetujui
                    'rgba(239, 68, 68, 0.85)',   // red    – ditolak
                ],
                'borderColor'     => [
                    'rgba(251, 191, 36, 1)',
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)',
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
