<?php

namespace App\Filament\Kps\Resources\PengajuanJuduls\Pages;

use App\Filament\Kps\Resources\PengajuanJuduls\PengajuanJudulResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListPengajuanJuduls extends ListRecords
{
    protected static string $resource = PengajuanJudulResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            null        => Tab::make('Semua'),
            'pengajuan' => Tab::make('Pengajuan')
                ->query(fn ($query) => $query->where('status', 'Pengajuan')),
            'disetujui' => Tab::make('Disetujui')
                ->query(fn ($query) => $query->where('status', 'Disetujui')),
            'ditolak'   => Tab::make('Ditolak')
                ->query(fn ($query) => $query->where('status', 'Ditolak')),
        ];
    }
}
