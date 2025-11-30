<?php

namespace App\Filament\Dosen\Resources\Undangans\Pages;

use App\Filament\Dosen\Resources\Undangans\UndanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUndangans extends ListRecords
{
    protected static string $resource = UndanganResource::class;

    protected ?string $heading = "Undangan";


    protected function getHeaderActions(): array
    {
        return [
//            CreateAction::make(),
        ];
    }
}
