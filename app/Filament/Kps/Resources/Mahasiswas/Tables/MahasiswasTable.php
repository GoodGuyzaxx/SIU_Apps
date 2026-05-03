<?php

namespace App\Filament\Kps\Resources\Mahasiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MahasiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('npm')
                    ->label('NPM')
                    ->searchable()
                    ->badge()
                    ->copyable(),

                TextColumn::make('nomor_hp')
                    ->label('No. HP')
                    ->copyable()
                    ->placeholder('-'),
                TextColumn::make('agama')
                    ->placeholder('-'),
                TextColumn::make('prodi.nama_prodi')
                    ->label('Program Studi')
                    ->sortable()
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
