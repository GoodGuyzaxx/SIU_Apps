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
                Section::make('Informasi Pejabat')
                    ->description('Atur detail pejabat, jabatan, dan tanda tangan untuk dokumen.')
                    ->schema([
                        Grid::make(['default' => 1, 'lg' => 3]) // Responsive grid
                            ->schema([
                                // Left Column for textual data
                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('nama')
                                            ->label('Nama Lengkap')
                                            ->placeholder('Contoh: Dr. Fulan, S.H., M.H.')
                                            ->required(),

                                        Select::make('jabatan')
                                            ->label('Jabatan')
                                            ->required()
                                            ->native(false)
                                        ->options([
                                            'rektor' => 'Rektor',
                                            'dekan' => 'Dekan',
                                            'kaprodi' => 'Ketua Program Studi',
                                        ]),

                                        Select::make('prodi_id')
                                            ->label('Program Studi')
                                            ->options(Prodi::all()->pluck('nama_prodi', 'id'))
                                            ->searchable()
                                            ->placeholder('Pilih Program Studi (Opsional)')
                                            ->native(false)
                                            ->nullable(true),

                                        Section::make('Nomor Identitas Pegawai')
                                            ->schema([
                                                Grid::make(['default' => 1, 'sm' => 3])
                                                    ->schema([
                                                        TextInput::make('nidn')
                                                            ->label('NIDN')
                                                            ->placeholder('Nomor Induk Dosen Nasional')
                                                            ->numeric()
                                                            ->maxLength(20),
                                                        TextInput::make('nrp')
                                                            ->label('NRP')
                                                            ->placeholder('Nomor Register Pegawai')
                                                            ->numeric()
                                                            ->maxLength(20),
                                                        TextInput::make('nip')
                                                            ->label('NIP')
                                                            ->placeholder('Nomor Induk Pegawai')
                                                            ->numeric()
                                                            ->maxLength(25),
                                                    ]),
                                            ]),
                                    ])
                                    ->columnSpan(['default' => 1, 'lg' => 2]),

                                // Right Column for the file upload
                                Grid::make(1)
                                    ->schema([
                                        FileUpload::make('ttd')
                                            ->label('Tanda Tangan')
                                            ->helperText('Unggah gambar tanda tangan (Format PNG transparan disarankan). Maksimal 2MB.')
                                            ->visibility('public')
                                            ->directory('ttd')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->panelLayout('compact'),
                                    ])
                                    ->columnSpan(['default' => 1, 'lg' => 1]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
