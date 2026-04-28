<?php

namespace App\Filament\Resources\TahunAkademiks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TahunAkademiksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('takad')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('priode')
                    ->searchable(),
                TextColumn::make('tahun')
                    ->width('100px')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                SelectColumn::make('status')
                    ->width('100px')
                    ->options([
                        'Y' => 'Aktif',
                        'N' => 'Tidak Aktif',
                    ]),
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
