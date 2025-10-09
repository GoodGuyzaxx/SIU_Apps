<?php

namespace App\Filament\Resources\Pengajuans\Pages;

use App\Filament\Resources\Pengajuans\PengajuanResource;
use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;

class CreatePengajuan extends CreateRecord
{
    protected static string $resource = PengajuanResource::class;

}
