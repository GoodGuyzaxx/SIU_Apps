<?php

namespace App\Filament\Kps\Widgets;

use App\Models\TahunAkademik;
use Filament\Widgets\Widget;

class KpsDashboardWidget extends Widget
{
    protected string $view = 'filament.kps.widgets.kps-dashboard-widget';

    protected static ?int $sort = -3;

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user    = auth()->user();
        $prodi   = $user?->prodi;
        $tahunAkademik = TahunAkademik::where('status', 'Y')->first();

        $greeting = $this->getGreeting();

        return [
            'user'          => $user,
            'prodi'         => $prodi,
            'tahunAkademik' => $tahunAkademik,
            'greeting'      => $greeting,
        ];
    }

    private function getGreeting(): string
    {
        $hour = now('Asia/Jayapura')->hour;

        return match (true) {
            $hour >= 5  && $hour < 12 => 'Selamat Pagi',
            $hour >= 12 && $hour < 15 => 'Selamat Siang',
            $hour >= 15 && $hour < 18 => 'Selamat Sore',
            default                   => 'Selamat Malam',
        };
    }
}
