<?php

namespace App\Filament\Resources\Juduls\Schemas;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JudulForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_mahasiswa')
                ->label('Mahasiswa')
                ->options(Mahasiswa::query()->pluck('nama', 'id'))
                ->required()
                ->searchable(),
                TextInput::make('judul')
                    ->required(),
                Select::make('pembimbing_satu')
                    ->label('Pembimbing Pertama')
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),
                TextInput::make('pembimbing_dua'),
                TextInput::make('penguji_satu'),
                TextInput::make('penguji_dua'),
            ]);
    }
}
