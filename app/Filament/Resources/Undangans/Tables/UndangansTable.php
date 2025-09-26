<?php

namespace App\Filament\Resources\Undangans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul.mahasiswa.nama')
                    ->label('Nama Mahasiswa'),

                TextColumn::make('judul.judul')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('perihal')
                    ->searchable(),
                TextColumn::make('tanggal_hari')
                    ->date()
                    ->sortable(),
                TextColumn::make('waktu')
                    ->time()
                    ->sortable(),
                TextColumn::make('tempat')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
