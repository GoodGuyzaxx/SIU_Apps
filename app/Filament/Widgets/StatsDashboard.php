<?php

namespace App\Filament\Widgets;

use App\Models\Judul;
use App\Models\UsulanJudul;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $countPengajuan = UsulanJudul::Where('status','Pengajuan')->get()->count();
        $countJudulProposal = Judul::where('jenis', 'proposal')->get()->count();
        $countJudulSkripsi = Judul::where('jenis', 'skripsi')->get()->count();
        return [
            Stat::make('Pengajuan Judul', $countPengajuan)
            ->icon('heroicon-o-document-text'),
            Stat::make('Proposal',$countJudulProposal ),
            Stat::make('Skripsi', $countJudulSkripsi),
        ];
    }
}
