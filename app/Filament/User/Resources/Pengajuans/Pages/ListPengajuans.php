<?php

namespace App\Filament\User\Resources\Pengajuans\Pages;

use App\Filament\User\Resources\Pengajuans\PengajuanResource;
use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListPengajuans extends ListRecords
{
    protected static string $resource = PengajuanResource::class;

    protected ?string $heading = "Pengajuan Judul";

    protected function getHeaderActions(): array
    {
        $dataId    = Mahasiswa::where('id_user', auth()->id())->first();
        $countData = UsulanJudul::where('id_mahasiswa', $dataId->id)->count();

        return [
            CreateAction::make()
                ->label('Ajukan Pengajuan Judul')
                ->hidden($countData == 1),
        ];
    }

    public function getTabs(): array
    {
        return [
            null        => Tab::make('Semua'),
            'pengajuan' => Tab::make('Pengajuan')
                ->query(fn ($query) => $query->where('status', 'Pengajuan')),
            'disetujui' => Tab::make('Disetujui')
                ->query(fn ($query) => $query->where('status', 'Disetujui')),
            'ditolak'   => Tab::make('Ditolak')
                ->query(fn ($query) => $query->where('status', 'Ditolak')),
        ];
    }
}
