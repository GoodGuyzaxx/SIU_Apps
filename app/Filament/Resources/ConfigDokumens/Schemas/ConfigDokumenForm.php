<?php

namespace App\Filament\Resources\ConfigDokumens\Schemas;

use App\Models\Prodi;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigDokumenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Dokumen')
                    ->description('Atur detail pejabat dan tanda tangan untuk dokumen.')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2]) // Responsive grid for medium screens and up
                            ->schema([
                                // Left Column for textual data
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('nama')
                                            ->label('Nama Pejabat')
                                            ->placeholder('Nama lengkap beserta gelar')
                                            ->required(),
                                        Select::make('jenjang')
                                            ->label('Jenjang')
                                            ->options([
                                                'S1' => 'S1/Sarjana',
                                                'S2' => 'S2/Magister',
                                                'S3' => 'S3/Doktor'
                                            ])
                                            ->native(false)
                                            ->required(),
                                        Select::make('prodi_id')
                                            ->label('Program Studi')
                                            ->options(Prodi::all()->pluck('nama_prodi', 'id'))
                                            ->default('-')
                                            ->nullable(true)
                                            ->native(false)
                                            ->required(),
                                    ]),

                                // Right Column for the file upload
                                Grid::make(1)
                                    ->schema([
                                        FileUpload::make('ttd')
                                            ->label('Tanda Tangan')
                                            ->helperText('Unggah gambar tanda tangan (format PNG transparan disarankan).')
                                            ->visibility('public')
                                            ->directory('ttd')
                                            ->image()
                                            ->imageEditor()
                                            ->panelLayout('compact'),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
