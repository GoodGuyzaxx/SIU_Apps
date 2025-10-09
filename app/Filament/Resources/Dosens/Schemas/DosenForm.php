<?php

namespace App\Filament\Resources\Dosens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class DosenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Dosen')
                ->required()
                ->maxLength(255),

            TextInput::make('nidn')
                ->label('NIDN')
                ->required()
                ->maxLength(50)
                ->numeric(),

            TextInput::make('nrp_nip')
                ->label('NRP / NIP')
                ->required()
                ->maxLength(50)
                ->numeric(),

            TextInput::make('inisial_dosen')
                ->label('Inisial Dosen')
                ->maxLength(10)
                ->placeholder('Contoh: JDS'),

            TextInput::make('ttl')
                ->label('Tempat, Tanggal Lahir')
                ->placeholder('Contoh: Jayapura, 17 Agustus 1980')
                ->maxLength(255),

            TextInput::make('nomor_hp')
                ->label('Nomor HP')
                ->tel()
                ->maxLength(20)
                ->placeholder('Contoh: 08123456789'),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->maxLength(255)
                ->placeholder('contoh@email.com'),
        ]);
    }
}
