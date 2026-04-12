<?php

namespace App\Filament\Resources\Prodis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProdiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_prodi')
                    ->label('Program Studi')
                    ->required(),
                Select::make('jenjang')
                    ->label('Jenjang')
                    ->options([
                        'S1' => 'S1/Sarjana',
                        'S2' => 'S2/Magister',
                        'S3' => 'S3/Doktor'
                    ])

            ]);
    }
}
