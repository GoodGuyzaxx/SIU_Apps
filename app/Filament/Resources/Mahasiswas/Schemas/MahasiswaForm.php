<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
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



            ]);
    }
}
