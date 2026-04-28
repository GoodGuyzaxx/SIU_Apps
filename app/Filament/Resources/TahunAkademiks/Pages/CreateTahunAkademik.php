<?php

namespace App\Filament\Resources\TahunAkademiks\Pages;

use App\Filament\Resources\TahunAkademiks\TahunAkademikResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunAkademik extends CreateRecord
{
    protected static string $resource = TahunAkademikResource::class;

    protected ?string $heading = 'Tambah Data Tahun Akademik';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
