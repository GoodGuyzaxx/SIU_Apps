<?php

namespace App\Filament\User\Resources\Undangans\Pages;

use App\Filament\User\Resources\Undangans\UndanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUndangans extends ListRecords
{
    protected static string $resource = UndanganResource::class;

    protected static ?string $title = "Daftar Undangan";
}
