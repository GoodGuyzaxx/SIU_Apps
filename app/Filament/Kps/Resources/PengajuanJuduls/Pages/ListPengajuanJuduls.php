<?php

namespace App\Filament\Kps\Resources\PengajuanJuduls\Pages;

use App\Filament\Kps\Resources\PengajuanJuduls\PengajuanJudulResource;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanJuduls extends ListRecords
{
    protected static string $resource = PengajuanJudulResource::class;

    /**
     * KPS hanya bisa melihat data, tidak membuat pengajuan.
     * Tombol "Create" sengaja dihilangkan.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
