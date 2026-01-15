<?php

namespace App\Filament\Resources\Pengajuans\Pages;

use App\Filament\Resources\Pengajuans\PengajuanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

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

}
