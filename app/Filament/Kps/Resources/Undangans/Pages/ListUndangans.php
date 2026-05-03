<?php

namespace App\Filament\Kps\Resources\Undangans\Pages;

use App\Filament\Kps\Resources\Undangans\UndanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUndangans extends ListRecords
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
