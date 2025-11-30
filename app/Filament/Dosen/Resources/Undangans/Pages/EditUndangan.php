<?php

namespace App\Filament\Dosen\Resources\Undangans\Pages;

use App\Filament\Dosen\Resources\Undangans\UndanganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUndangan extends EditRecord
{
    protected static string $resource = UndanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
