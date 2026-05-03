<?php

namespace App\Filament\Resources\Nilais\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NilaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ujian Proposal')
                    ->schema([
                        DatePicker::make('tanggal_ujian_proposal')
                            ->label('Tanggal Ujian')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        Select::make('nilai_proposal')
                            ->label('Nilai Huruf')
                            ->options([
                                'A' => 'A',
                                'B+' => 'B+',
                                'B' => 'B',
                                'B-' => 'B-',
                                'C+' => 'C+',
                                'C' => 'C',
                                'D' => 'D',
                                'E' => 'E',
                            ])
                            ->native(false),
                        TextInput::make('nilai_proposal_angka')
                            ->label('Nilai Angka')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

                Section::make('Ujian Hasil')
                    ->schema([
                        DatePicker::make('tanggal_ujian_hasil')
                            ->label('Tanggal Ujian')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        Select::make('nilai_hasil')
                            ->label('Nilai Huruf')
                            ->options([
                                'A' => 'A',
                                'B+' => 'B+',
                                'B' => 'B',
                                'B-' => 'B-',
                                'C+' => 'C+',
                                'C' => 'C',
                                'D' => 'D',
                                'E' => 'E',
                            ])
                            ->native(false),
                        TextInput::make('nilai_hasil_angka')
                            ->label('Nilai Angka')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
