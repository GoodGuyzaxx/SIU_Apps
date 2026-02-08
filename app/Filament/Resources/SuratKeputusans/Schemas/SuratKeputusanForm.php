<?php

namespace App\Filament\Resources\SuratKeputusans\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SuratKeputusanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Nomor Surat Keputusan')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('nomor_sk_penguji')
                            ->label('Nomor Surat Keputusan Penguji'),
                        TextInput::make('nomor_sk_pembimbing')
                            ->label('Nomor Surat Keputusan Pembimbing')
                    ]),
                Section::make('Konsideran')
                    ->columnSpanFull()
                    ->schema([
                        RichEditor::make('menimbang')
                            ->label('Menimbang')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'codeBlock',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'undo',
                            ]),
                        RichEditor::make('mengingat')
                            ->label('Mengingat')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'codeBlock',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'undo',
                            ]),
                        Textarea::make('memperhatikan')
                            ->label('Memperhatikan')
                            ->columnSpanFull()
                    ])
            ]);
    }
}
