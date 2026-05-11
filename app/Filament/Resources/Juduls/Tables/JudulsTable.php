<?php

namespace App\Filament\Resources\Juduls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JudulsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No')
                    ->rowIndex()
                    ->alignCenter()
                    ->width('60px'),

                TextColumn::make('mahasiswa.nama')
                    ->label('Mahasiswa')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->icon('heroicon-o-user-circle')
                    ->description(fn ($record) => $record->mahasiswa?->npm ?? '-'),

                TextColumn::make('mahasiswa.prodi.nama_prodi')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-academic-cap')
                    ->toggleable(),

                TextColumn::make('minat')
                    ->label('Minat')
                    ->badge()
                    ->color('warning')
                    ->searchable(),

                TextColumn::make('judul')
                    ->label('Judul Skripsi')
                    ->searchable()
                    ->limit(55)
                    ->tooltip(fn ($record) => $record->judul)
                    ->wrap(),

                TextColumn::make('pembimbingSatu.nama')
                    ->label('Pembimbing')
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->description(fn ($record) => $record->pembimbingDua?->nama ?? '-')
                    ->toggleable(),

                TextColumn::make('pengujiSatu.nama')
                    ->label('Penguji')
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->description(fn ($record) => $record->pengujiDua?->nama ?? '-')
                    ->toggleable(),

                TextColumn::make('tahunAkademik.tahun')
                    ->label('T.A')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->alignCenter()
                    ->color(fn (string $state): string => match ($state) {
                        'proposal' => 'info',
                        'hasil'    => 'success',
                        'sidang'   => 'warning',
                        default    => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'proposal' => 'heroicon-o-document-text',
                        'hasil'    => 'heroicon-o-check-circle',
                        'sidang'   => 'heroicon-o-academic-cap',
                        default    => 'heroicon-o-clock',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pengajuan' => 'Pengajuan',
                        'proposal'  => 'Proposal',
                        'hasil'     => 'Hasil',
                        'sidang'    => 'Sidang',
                        default     => ucfirst($state),
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->created_at?->format('d M Y, H:i'))
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateHeading('Belum Ada Data Judul')
            ->emptyStateDescription('Belum ada judul skripsi yang terdaftar.')
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
