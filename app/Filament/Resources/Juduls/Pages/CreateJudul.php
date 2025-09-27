<?php

namespace App\Filament\Resources\Juduls\Pages;

use App\Filament\Resources\Juduls\JudulResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJudul extends CreateRecord
{
    protected static string $resource = JudulResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
