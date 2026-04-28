<?php

namespace App\Filament\Resources\TahunAkademiks\Pages;

use App\Filament\Resources\TahunAkademiks\TahunAkademikResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTahunAkademiks extends ListRecords
{
    protected static string $resource = TahunAkademikResource::class;

    protected ?string $heading = 'Tahun Akademik';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tamabah Data'),
        ];
    }
}
