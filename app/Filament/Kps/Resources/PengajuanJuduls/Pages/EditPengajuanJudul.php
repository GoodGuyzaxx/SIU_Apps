<?php

namespace App\Filament\Kps\Resources\PengajuanJuduls\Pages;

use App\Filament\Kps\Resources\PengajuanJuduls\PengajuanJudulResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanJudul extends EditRecord
{
    protected static string $resource = PengajuanJudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
