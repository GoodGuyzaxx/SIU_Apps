<?php

namespace App\Filament\Resources\Mahasiswas\Pages;

use App\Filament\Resources\Mahasiswas\MahasiswaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;


class ListMahasiswas extends ListRecords
{
    protected static string $resource = MahasiswaResource::class;

    protected ?string $heading = 'Mahasiswa';
//    protected function getHeaderActions(): array
//    {
//        return [
//            CreateAction::make()
//                ->label('Tambah Mahasiswa')
//            ,
//        ];
//    }




}
