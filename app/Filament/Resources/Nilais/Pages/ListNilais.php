<?php

namespace App\Filament\Resources\Nilais\Pages;

use App\Filament\Resources\Nilais\NilaiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNilais extends ListRecords
{
    protected static string $resource = NilaiResource::class;

    protected ?string $heading = "Input Nilai Mahasiswa";
}
