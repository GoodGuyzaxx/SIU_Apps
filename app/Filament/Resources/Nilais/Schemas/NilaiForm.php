<?php

namespace App\Filament\Resources\Nilais\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class NilaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nilai_proposal')
                    ->label('Nilai Proposal Huruf'),
                TextInput::make('nilai_proposal_angka')
                    ->label('Nilai Proposal Angka')
                    ->numeric()
                    ->minValue(0),
                DatePicker::make('tanggal_ujian_proposal')
                    ->label('Tanggal Ujian Proposal')
                    ->date()
                    ->native(false)
                    ->suffixAction(
                        Action::make('clear')
                            ->icon('heroicon-m-x-mark')
                            ->action(fn (Set $set) => $set('tanggal_ujian_proposal', null))
                    )
                    ->native(false),
                TextInput::make('nilai_hasil')
                    ->label('Nilai Hasil Huruf'),
                TextInput::make('nilai_hasil_angka')
                    ->label('Nilai Hasil Angka')
                    ->numeric()
                    ->minValue(0),
                DatePicker::make('tanggal_ujian_hasil')
                    ->label('Tanggal Ujian Hasil')
                    ->date()
                    ->suffixAction(
                        Action::make('clear')
                            ->icon('heroicon-m-x-mark')
                            ->action(fn (Set $set) => $set('tanggal_ujian_hasil', null))
                    )

                    ->native(false),
            ]);
    }
}
