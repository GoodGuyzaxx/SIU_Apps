<?php

namespace App\Filament\Resources\SuratKeputusans\Tables;

use App\Models\SuratKeputusan;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SuratKeputusansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('judul.mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('judul.mahasiswa.npm')
                    ->label('NPM')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nomor_sk_penguji')
                    ->label('Nomor SK Penguji')
                    ->sortable(),
                TextColumn::make('nomor_sk_pembimbing')
                    ->label('Nomor SK Pembimbing')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([

                Action::make('Tanda Tangan')
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->modalIcon('heroicon-o-pencil')
                    ->modalDescription('Anda yakin ingin memberikan ijin tanda tangan digital pada dokumen ketika di cetak?')
                    ->modalCancelActionLabel('Batal')
                    ->modalSubmitActionLabel('Ya,Tanda Tangan Digital')
                    ->action(function (SuratKeputusan $record): void {
                        $record->signed = auth()->user()->role;
                        $record->save();
                        Notification::make()
                            ->title('Berhasil Ditandatangani')
                            ->success()
                            ->send();
                    })
                    ->visible(function () {
                        $dataRole = ['admin', 'dekan', 'kaprodi'];

                        if (in_array(auth()->user()->role, $dataRole)) {
                            return true;
                        }

                        return false;
                    })
                    ->hidden(function (SuratKeputusan $record): bool {
                        return $record->signed !== "-";
                    }),

                Action::make('Print')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn (SuratKeputusan $record) => route('skPDF', $record->id))
                    ->openUrlInNewTab(),
                Action::make('Print Dengan Tanda Tangan')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->hidden(function (SuratKeputusan $record): bool {
                        return $record->signed == '-';
                    })
                    ->url(fn (SuratKeputusan $record) => route('skttdPDF', $record->id))
                    ->openUrlInNewTab(),
                ActionGroup::make([
                    ViewAction::make(),
                    DeleteAction::make(),
                    EditAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
