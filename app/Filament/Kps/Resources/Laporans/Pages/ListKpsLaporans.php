<?php

namespace App\Filament\Kps\Resources\Laporans\Pages;

use App\Filament\Kps\Resources\Laporans\KpsLaporanResource;
use Filament\Resources\Pages\ListRecords;

class ListKpsLaporans extends ListRecords
{
    protected static string $resource = KpsLaporanResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
