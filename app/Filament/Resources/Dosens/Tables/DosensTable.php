<?php

namespace App\Filament\Resources\Dosens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DosensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('nama')
                    ->label('Nama Dosen')
                    ->searchable(),

                TextColumn::make('nidn')
                    ->label('NIDN')
                    ->default('-')
                    ->searchable(),

                TextColumn::make('nrp_nip')
                    ->label('NRP/NIP')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('inisial_dosen')
                    ->label('Inisial Dosen')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('nomor_hp')
                    ->label('Nomor')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->default('-'),

                TextColumn::make('ttl')
                    ->label('Tempat Tanggl Lahir')
                    ->default('-'),


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
