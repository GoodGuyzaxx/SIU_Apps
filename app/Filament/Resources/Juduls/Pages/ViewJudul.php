<?php

namespace App\Filament\Resources\Juduls\Pages;

use App\Filament\Resources\Juduls\JudulResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJudul extends ViewRecord
{
    protected static string $resource = JudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
