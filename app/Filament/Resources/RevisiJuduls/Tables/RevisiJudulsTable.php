<?php

namespace App\Filament\Resources\RevisiJuduls\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
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
                    ->tooltip(fn (?string $state): string => $state ?? '')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('rev_judul')
                    ->label('Revisi Judul')
                    ->limit(60)
                    ->tooltip(fn (?string $state): string => $state ?? '')
                    ->searchable()
                    ->placeholder('Belum ada revisi'),
                TextColumn::make('status_rev_judul')
                    ->label('Status Revisi')
                    ->badge()
                    ->placeholder('—')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'ya'            => 'Perlu Direvisi',
                        'sudah_revisi'  => 'Sudah Direvisi',
                        'tidak'         => 'Tidak Perlu Revisi',
                        default         => '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'ya'            => 'warning',
                        'sudah_revisi'  => 'success',
                        'tidak'         => 'gray',
                        default         => 'gray',
                    }),
            ])
            ->emptyStateHeading('Belum ada data judul')
            ->emptyStateDescription('Data judul mahasiswa akan muncul di sini ketika tersedia.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Input Revisi')
                    ->modalHeading('Input Revisi Judul')
                    ->slideOver()
                    ->visible(fn ($record) => in_array($record->status_rev_judul, ['ya', 'sudah_revisi'])),

                Action::make('tidak_perlu_revisi')
                    ->label('Tidak Perlu Revisi')
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai Tidak Perlu Revisi')
                    ->modalDescription('Apakah judul ini tidak memerlukan revisi? Status akan diubah menjadi "Tidak Perlu Revisi".')
                    ->modalSubmitActionLabel('Ya, Tandai')
                    ->visible(fn ($record) => $record->status_rev_judul === 'ya')
                    ->action(function ($record): void {
                        $record->update(['status_rev_judul' => 'tidak']);
                        Notification::make()
                            ->title('Status Diperbarui')
                            ->body("Judul \"{$record->judul}\" ditandai tidak perlu revisi.")
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
