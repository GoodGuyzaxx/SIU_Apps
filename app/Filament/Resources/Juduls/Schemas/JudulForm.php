<?php

namespace App\Filament\Resources\Juduls\Schemas;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

                Select::make('jenis')
                    ->label('Jenis')
                    ->required()
                    ->options([
                        'proposal' => 'Proposal',
                        'skripsi' => 'Skripsi',
                    ]),

                Textarea::make('judul')
                    ->required(),

                Select::make('minat')
                    ->label('Minat Kekuhusan')
                    ->required()
                    ->options([
                        "HTN" => "🏛️ Hukum Tata Negara (HTN)",
                        "Hukum Pidana" => "⚖️ Hukum Pidana",
                        "Hukum Perdata" => "📄 Hukum Perdata",
                    ]),

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
