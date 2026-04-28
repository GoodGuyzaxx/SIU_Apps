<?php

namespace App\Filament\Resources\Laporans\Pages;

use App\Filament\Resources\Laporans\LaporanResource;
use App\Filament\Resources\Laporans\Widgets\RekapanStasWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;

    protected ?string $heading = 'Rekapan';

    protected static ?string $title = 'Rekapan';

    protected function getHeaderActions(): array
    {
        return [
//            CreateAction::make(),
        ];
    }

//    protected function getHeaderWidgets(): array
//    {
//        return LaporanResource::getWidgets();
//    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Semua Laporan'),
            'pengajuan' => Tab::make('Pengajuan')
            ->query(fn($query)=> $query->where('status', 'Pengajuan')),
            'proposal' => Tab::make('Proposal')
                ->query(fn($query)=> $query->where('status', 'proposal')),
            'hasil' => Tab::make('Hasil')
                ->query(fn($query)=> $query->where('status', 'Hasil')),
        ];
    }
}
