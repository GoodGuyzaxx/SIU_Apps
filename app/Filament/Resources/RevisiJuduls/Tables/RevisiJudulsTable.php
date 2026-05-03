<?php

namespace App\Filament\Resources\RevisiJuduls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RevisiJudulsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->rowIndex()
                    ->label('No.'),
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mahasiswa.npm')
                    ->label('NPM')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul')
                    ->label('Judul')
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable()
                    ->placeholder('Tidak Ada Revisi'),
                TextColumn::make('rev_judul')
                    ->label('Revisi Judul')
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable()
                    ->placeholder('Tidak Ada Revisi'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                ->label('Revisi Judul')
                ->modalHeading('Revisi Judul')
                ->slideOver(),
            ]);
    }
}
