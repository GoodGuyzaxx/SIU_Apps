<?php

namespace App\Filament\Resources\SuratKeputusans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SuratKeputusanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_sk_penguji')
                    ->label('Nomor Surat Keputusan Penguji'),
                TextInput::make('nomor_sk_pembimbing')
                    ->label('Nomor Surat Keputusan Pembimbing'),
            ]);
    }
}
