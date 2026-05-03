<?php

namespace App\Filament\Kps\Resources\Juduls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JudulsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mahasiswa.nama')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mahasiswa.npm')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('judul')
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state)
                    ->searchable(),
                TextColumn::make('pembimbingSatu.nama')
                    ->searchable(),
                TextColumn::make('pembimbingDua.nama')
                    ->searchable(),
                SelectColumn::make('status')
                    ->native(false)
                    ->sortable()
                    ->options([
                        'pengajuan' => 'Pengajuan',
                        'proposal' => 'Proposal',
                        'hasil' => 'Hasil'
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
                SelectFilter::make('status')
                    ->label('Status Judul')
                    ->options([
                        'pengajuan' => 'Pengajuan',
                        'proposal' => 'Proposal',
                        'hasil' => 'Hasil'
                    ])
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
