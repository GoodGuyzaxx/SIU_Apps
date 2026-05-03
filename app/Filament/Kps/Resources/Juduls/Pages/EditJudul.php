<?php

namespace App\Filament\Kps\Resources\Juduls\Pages;

use App\Filament\Kps\Resources\Juduls\JudulResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJudul extends EditRecord
{
    protected static string $resource = JudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
