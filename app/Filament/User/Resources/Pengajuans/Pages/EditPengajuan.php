<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajuan extends EditRecord
{
    protected static string $resource = PengajuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
