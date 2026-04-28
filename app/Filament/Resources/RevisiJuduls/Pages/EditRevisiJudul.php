<?php

namespace App\Filament\Resources\RevisiJuduls\Pages;

use App\Filament\Resources\RevisiJuduls\RevisiJudulResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRevisiJudul extends EditRecord
{
    protected static string $resource = RevisiJudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
