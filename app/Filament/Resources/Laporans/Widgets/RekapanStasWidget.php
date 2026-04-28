<?php

namespace App\Filament\Resources\Laporans\Widgets;

use App\Models\TahunAkademik;
use App\Filament\Resources\Laporans\Pages\ListLaporans;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RekapanStasWidget extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListLaporans::class;
    }
    protected function getStats(): array
    {
        $query = $this->getPageTableQuery();

        // Mengambil tahun akademik aktif secara langsung dari modelnya.
        // Ini tidak bergantung pada filter tabel saat ini.
        $activeTakadModel = TahunAkademik::where('status', 'Y')->first();

        // Format string untuk ditampilkan di widget.
        $takadAktifDisplay = $activeTakadModel
            ? $activeTakadModel->takad . ' - ' . strtoupper($activeTakadModel->priode)
            : 'Tidak Ada';

        $rekapanPengajuan = (clone $query)->where('status', 'pengajuan')->count();
        $rekapanProposal = (clone $query)->where('status','proposal')->count();
        $rekapanHasil = (clone $query)->where('status','hasil')->count();

        return [
            Stat::make('Tahun Akademik Aktif', $takadAktifDisplay),
            Stat::make('Judul Masih Dalam Pengajuan',$rekapanPengajuan),
            Stat::make('Judul Masih Dalam Proposal', $rekapanProposal),
            Stat::make('judul Sudah Ujian Hasil ', $rekapanHasil)
            ->color('success')
        ];
    }
}
