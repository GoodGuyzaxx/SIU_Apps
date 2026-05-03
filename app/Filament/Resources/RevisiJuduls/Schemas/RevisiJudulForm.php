<?php

namespace App\Filament\Resources\RevisiJuduls\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

class RevisiJudulForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('judul')
                    ->label('Judul Sekarang')
                    ->autosize()
                    ->readOnly()
                    ->columnSpanFull(),
                Textarea::make('rev_judul')
                    ->label('Masukan Revisi Judul')
                    ->rows(5)
                ->columnSpanFull()

            ]);
    }
}
