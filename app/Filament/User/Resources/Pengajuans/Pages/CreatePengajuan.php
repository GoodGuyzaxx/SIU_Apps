<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajuan extends CreateRecord
{
    protected static string $resource = PengajuanResource::class;

}
