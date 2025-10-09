<?php

namespace App\Filament\User\Pages;

use App\Filament\Resources\Juduls\JudulResource;
use App\Models\Judul;
use App\Models\Mahasiswa;
use BackedEnum;
use Filament\Pages\Page;

class LaporanPersetujuanSkrispi extends Page
{
//    protected static string $resource = JudulResource::class;

    protected string $view = 'filament.user.pages.laporan-persetujuan-skrispi';

    protected static ?string $navigationLabel = 'Laporan Persetujuan Skrispi';

    protected static ?int $navigationSort = 4;

//    public ?Mahasiswa $mahasiswa = null;
    public ?Judul $record= null;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-check';

    public function mount(): void
    {
        $idMhs = Mahasiswa::where('id_user', auth()->user()->id)->first();
        $judul = Judul::where('id_mahasiswa', $idMhs->id)->first();
        $this->record = $judul;
//        dd($this->record);
    }

}
