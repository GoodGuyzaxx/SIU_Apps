<?php

namespace App\Filament\Resources\Pengajuans\Tables;

use App\Filament\Resources\Pengajuans\Pages\DetailPengajuan;
use App\Models\UsulanJudul;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                //
                TextColumn::make('mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make("mahasiswa.npm")
                    ->label('NPM')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('status')
                    ->label('Status Pengajuan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pengajuan' => 'warning',
                        'Diterima' => 'success',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable()
            ])
            ->emptyStateHeading('Data Tidak Ditemukan')
            ->defaultSort('created_at', 'desc')

            ->filters([
                //
                SelectFilter::make('status')
                ->label('Status Pengajuan')
                ->default('Pengajuan')
                ->options([
                    'Pengajuan' => 'Pengajuan',
                    'Disetujui' => 'Disetujui',
                    'Ditolak' => 'Ditolak',
                ])
            ])
            ->recordActions([
                Action::make("Detail")
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn(UsulanJudul $record) => DetailPengajuan::getUrl([$record->id]))


            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
}
