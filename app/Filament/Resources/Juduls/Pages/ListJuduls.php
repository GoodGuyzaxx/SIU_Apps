<?php

namespace App\Filament\Resources\Juduls\Pages;

use App\Filament\Resources\Juduls\JudulResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJuduls extends ListRecords
{
    protected static string $resource = JudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
