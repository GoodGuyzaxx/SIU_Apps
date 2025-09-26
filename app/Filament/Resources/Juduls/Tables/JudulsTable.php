<?php

namespace App\Filament\Resources\Juduls\Tables;

use App\Models\Mahasiswa;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JudulsTable
{
    public static function configure(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('mahasiswa.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('judul')
                    ->searchable(),
                TextColumn::make('pembimbing_satu')
                    ->searchable(),
                TextColumn::make('pembimbing_dua')
                    ->searchable(),
                TextColumn::make('penguji_satu')
                    ->searchable(),
                TextColumn::make('penguji_dua')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
