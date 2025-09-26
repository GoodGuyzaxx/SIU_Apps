<?php

namespace App\Filament\Resources\Dosens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class DosenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('nama')
                    ->label("Nama Dosen")
                    ->required(),

                TextInput::make('nidn')
                    ->label("NIDN")
                    ->required()
                    ->numeric(),

                TextInput::make('nrp')
                    ->label("NRP")
                    ->required()
                    ->numeric(),
            ]);
    }
}
