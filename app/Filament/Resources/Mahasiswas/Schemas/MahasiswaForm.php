<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama')
                ->label('Nama Lengkap')
                ->placeholder('Ahmad Budiman')
                ->required()
                ->maxLength(255)
                ->prefixIcon('heroicon-m-user')
                ->columnSpan(2),

            TextInput::make('npm')
                ->label('NPM')
                ->placeholder('2023010001')
                ->required()
                ->unique(ignoreRecord: true)
                ->numeric()
                ->maxLength(255)
                ->prefixIcon('heroicon-m-identification')
                ->helperText('Nomor Pokok Mahasiswa')
                ->columnSpan(1),

            TextInput::make('nomor_hp')
                ->label('Nomor HP')
                ->placeholder('81234567890')
                ->required()
                ->tel()
                ->maxLength(15)
                ->prefix('+62')
                ->prefixIcon('heroicon-m-phone')
                ->helperText('Nomor HP Mahasiswa atau yang bisa dihubungi')
                ->columnSpan(1),

            Select::make('jenjang')
                ->label('Jenjang')
                ->placeholder('Pilih Jenjang')
                ->native(false)
                ->required()
                ->prefixIcon('heroicon-o-academic-cap')
                ->options([
                    'sarjana' => 'Sarjana / S1',
                    'magister' => 'Magister / S2',
                ])
                ->live(),

            Select::make('kelas')
                ->label('Kelas')
                ->placeholder('Pilih Kelas')
                ->required()
                ->native(false)
                ->prefixIcon('heroicon-o-clock')
                ->options([
                    'pagi' => 'Kelas Pagi',
                    'sore' => 'Kelas Sore',
                ])
                ->visible(fn ($get) => $get('jenjang') === 'sarjana'),

            Select::make('program_studi')
                ->label('Program Studi')
                ->placeholder('Pilih Program Studi')
                ->native(false)
                ->columnSpan(2)
                ->required()
                ->prefixIcon('heroicon-o-academic-cap')
                ->options(
                    function ($get) {
                        if ($get('jenjang') == 'magister') {
                            return [
                                'Magister Hukum' => 'Magister Hukum',
                                'Kenotariatan' => 'Kenotariatan',
                            ];
                        }
                        return [
                            'Ilmu Hukum' => 'Ilmu Hukum',
                        ];
                    }
                ),

            TextInput::make('angkatan')
                ->label('Angkatan')
                ->placeholder('Contoh 2021')
                ->columnSpan(2)
                ->prefixIcon('heroicon-o-academic-cap')
                ->required()
                ->type('number'),


            Select::make('agama')
                ->label('Agama')
                ->placeholder('Pilih agama')
                ->required()
                ->options([
                    'Islam' => 'Islam',
                    'Kristen' => 'Kristen',
                    'Katolik' => 'Katolik',
                    'Hindu' => 'Hindu',
                    'Buddha' => 'Buddha',
                    'Konghucu' => 'Konghucu',
                ])
                ->native(false)
                ->searchable()
                ->prefixIcon('heroicon-m-sparkles')
                ->columnSpan(2),

        ]);
    }
}
