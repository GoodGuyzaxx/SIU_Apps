<?php

namespace App\Filament\Resources\ConfigDokumens\Pages;

use App\Filament\Resources\ConfigDokumens\ConfigDokumenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConfigDokumen extends CreateRecord
{
    protected static string $resource = ConfigDokumenResource::class;

    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
