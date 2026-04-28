<?php

namespace App\Filament\Resources\TahunAkademiks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TahunAkademikForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tahun Akademik')
                    ->description('Masukkan detail tahun akademik.')
                    ->schema([
                        TextInput::make('takad')
                            ->label('Tahun Akademik')
                            ->maxLength(5)
                            ->required(),
                        Select::make('priode')
                            ->label('Priode Berjalan')
                            ->options([
                                'ganjil' => 'Ganjil',
                                'genap' => 'Genap'
                            ])
                            ->required(),
                        TextInput::make('tahun')
                            ->label('Tahun')
                            ->maxLength(4)
                            ->required(),
                        Select::make('status')
                            ->options(['Y' => 'Y', 'N' => 'N'])
                            ->default('N')
                            ->required(),
                    ])
            ]);
    }
}
