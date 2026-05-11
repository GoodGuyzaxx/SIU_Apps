<?php

namespace App\Filament\Resources\Pengajuans\Pages;

use App\Filament\Resources\Pengajuans\PengajuanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListPengajuans extends ListRecords
{
    protected static string $resource = PengajuanResource::class;

    protected ?string $heading = 'Daftar Pengajuan Judul';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->icon('heroicon-s-plus')
            ->label('Tambah Pengajuan Judul')
        ];
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
