<?php

namespace App\Filament\Resources\Prodis\Pages;

use App\Filament\Resources\Prodis\ProdiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProdis extends ListRecords
{
    protected static string $resource = ProdiResource::class;

    protected ?string $heading= 'Data Program Studi';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Data'),
        ];
    }
}
