<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('alt')
                    ->label('Judul / Alt Text')
                    ->maxLength(255),
                FileUpload::make('url')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->moveFiles()
                    ->directory('galleries')
                    ->required(),
            ]);
    }
}
