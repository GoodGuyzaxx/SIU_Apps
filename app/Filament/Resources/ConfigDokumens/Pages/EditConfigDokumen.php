<?php

namespace App\Filament\Resources\ConfigDokumens\Pages;

use App\Filament\Resources\ConfigDokumens\ConfigDokumenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConfigDokumen extends EditRecord
{
    protected static string $resource = ConfigDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
