<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(
                Section::make('Form Data Mahasiswa')
                    ->schema([
                        TextInput::make('nama')
                            ->placeholder("Masukan nama Mahasiswa")
                            ->required(),

                        TextInput::make('npm')
                            ->placeholder("Masukan npm Mahasiswa")
                            ->numeric()
                            ->required(),

                        TextInput::make('fakultas')
                            ->placeholder("Masukan Fakultas Mahasiswa")
                            ->required(),

                        TextInput::make('program_studi')
                            ->placeholder("Masukan Prodi Mahasiswa")
                            ->required(),
                    ])
                //
            );
    }
}
