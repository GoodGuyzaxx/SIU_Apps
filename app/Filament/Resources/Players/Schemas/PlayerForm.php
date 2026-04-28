<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('url')
                    ->label('URL Video')
                    ->required()
                    ->url()
                    ->maxLength(255),
            ]);
    }
}
