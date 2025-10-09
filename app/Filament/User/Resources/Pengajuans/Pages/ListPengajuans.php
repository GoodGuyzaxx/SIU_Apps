<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajuans extends ListRecords
{
    protected static string $resource = PengajuanResource::class;

    protected ?string $heading = "Pengajuan Judul";

    protected function getHeaderActions(): array
    {

        $dataId = Mahasiswa::where('id_user', auth()->id())->first();
        $countData  = UsulanJudul::where('id_mahasiswa', $dataId->id)->count();

        return [
            CreateAction::make()
            ->label('Ajukan Pengajuan Judul')
            ->hidden($countData == 1),
        ];
    }
}
