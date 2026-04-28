<?php

namespace App\Filament\Resources\Nilais\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NilaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul.id')
                    ->searchable(),
                TextColumn::make('nilai_proposal')
                    ->searchable(),
                TextColumn::make('tanggal_ujian_proposal')
                    ->searchable(),
                TextColumn::make('nilai_hasil')
                    ->searchable(),
                TextColumn::make('tanggal_ujian_hasil')
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
                EditAction::make()
                ->modalHeading('Edit Record')
                ->slideOver()
                ->label('Input Nilai'),
            ])
            ->toolbarActions([
            ]);
    }
}
