<?php

namespace App\Filament\Resources\Juduls\Schemas;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Kanuni\FilamentCards\CardItem;

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

                Select::make('jenis')
                    ->label('Jenis')
                    ->required()
                    ->options([
                        'proposal' => 'Proposal',
                        'skripsi' => 'Skripsi',
                    ]),

                TextInput::make('judul')
                    ->required(),

                Select::make('pembimbing_satu')
                    ->label('Pembimbing Pertama')
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),

                Select::make('pembimbing_dua')
                    ->label('Pembimbing Kedua')
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),

                Select::make('penguji_satu')
                    ->label('Penguji Pertama')
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),

                Select::make('penguji_dua')
                    ->label('Pembimbing Kedua')
                    ->options(Dosen::query()->pluck('nama', 'nama'))
                    ->searchable(),


            ]);
    }
}
