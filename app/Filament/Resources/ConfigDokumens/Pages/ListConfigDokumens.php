<?php

namespace App\Filament\Resources\ConfigDokumens\Pages;

use App\Filament\Resources\ConfigDokumens\ConfigDokumenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConfigDokumens extends ListRecords
{
    protected static string $resource = ConfigDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Data'),
        ];
    }
}
