<?php

namespace App\Filament\Resources\Dosens\Pages;

use App\Filament\Resources\Dosens\DosenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDosens extends ListRecords
{
    protected static string $resource = DosenResource::class;

    protected ?string $heading = "Data Dosen";

//    protected function getHeaderActions(): array
//    {
//        return [
//            CreateAction::make()
//            ->label("Tambah Data Dosen"),
//        ];
//    }


}
