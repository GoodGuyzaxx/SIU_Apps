<?php

namespace App\Filament\Resources\ConfigDokumens\Tables;


use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConfigDokumensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('ttd')
                    ->label('Tanda Tangan')
                    ->square()
                    ->placeholder('Belum ada Isi'),
                    
                TextColumn::make('nama')
                    ->label('Nama Pejabat & Jabatan')
                    ->description(fn ($record) => $record->jabatan ? ucfirst($record->jabatan) : '-')
                    ->searchable(['nama', 'jabatan'])
                    ->sortable(),
                    
                TextColumn::make('prodi.nama_prodi')
                    ->label('Program Studi')
                    ->badge()
                    ->color('info')
                    ->placeholder('Tingkat Universitas / Rektorat')
                    ->searchable()
                    ->sortable(),
                    
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
