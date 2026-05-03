<?php

namespace App\Filament\Kps\Resources\Mahasiswas\Pages;

use App\Filament\Kps\Resources\Mahasiswas\MahasiswaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswas extends ListRecords
{
    protected static string $resource = MahasiswaResource::class;

    protected ?string $heading = 'Daftar Mahasiswa';
}
