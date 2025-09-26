<?php

namespace App\Filament\Resources\Undangans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class UndanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_judul')
                    ->required()
                    ->numeric(),
                TextInput::make('nomor')
                    ->required(),
                TextInput::make('perihal')
                    ->required(),
                DatePicker::make('tanggal_hari')
                    ->required(),
                TimePicker::make('waktu')
                    ->required(),
                TextInput::make('tempat')
                    ->required(),
            ]);
    }
}
