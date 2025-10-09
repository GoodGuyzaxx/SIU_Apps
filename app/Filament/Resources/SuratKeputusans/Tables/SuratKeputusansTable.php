<?php

namespace App\Filament\Resources\SuratKeputusans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SuratKeputusansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('judul.mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul.mahasiswa.npm')
                    ->label('NPM')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_sk_penguji')
                    ->label('Nomor SK Penguji')
                    ->sortable(),
                TextColumn::make('nomor_sk_pembimbing')
                    ->label('Nomor SK Pembimbing')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
