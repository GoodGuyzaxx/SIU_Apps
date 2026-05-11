<?php

namespace App\Filament\Resources\Juduls\Pages;

use App\Filament\Resources\Juduls\JudulResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListJuduls extends ListRecords
{
    protected static string $resource = JudulResource::class;

    protected ?string $heading = 'Daftar Judul Skripsi';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Data Judul')
                ->icon('heroicon-s-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            null        => Tab::make('Semua'),
            'pengajuan' => Tab::make('Pengajuan')
                ->query(fn ($query) => $query->where('status', 'pengajuan')),
            'proposal'  => Tab::make('Proposal')
                ->query(fn ($query) => $query->where('status', 'proposal')),
            'hasil'     => Tab::make('Hasil')
                ->query(fn ($query) => $query->where('status', 'hasil')),
            'sidang'    => Tab::make('Sidang')
                ->query(fn ($query) => $query->where('status', 'sidang')),
        ];
    }
}
