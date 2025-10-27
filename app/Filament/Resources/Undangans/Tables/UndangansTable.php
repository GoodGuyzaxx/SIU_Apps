<?php

namespace App\Filament\Resources\Undangans\Tables;

use App\Models\Undangan;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul.mahasiswa.nama')
                    ->label('Nama Mahasiswa')
                    ->searchable(),

                TextColumn::make('judul.judul')
                    ->label('Judul')
                    ->limit(20)
                    ->toggleable(true)
                    ->sortable(),

                TextColumn::make('perihal')
                    ->searchable()
                    ->limit(20),
                TextColumn::make('tanggal_hari')
                    ->date()
                    ->sortable(),
                TextColumn::make('waktu')
                    ->time()
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
                    ->action(function (Undangan $record): void {
                        $record->signed = auth()->user()->role;
                        $record->save();
                        Notification::make()
                            ->title('Berhasil Ditandatangani')
                            ->success()
                            ->send();
                    })
                    ->visible(function () {
                        $dataRole = ['admin','kaprodi'];
                        if (in_array(auth()->user()->role, $dataRole)) {
                            return true;
                        }
                        return false;
                    })
                    ->hidden(function (Undangan $record): bool {
                        return $record->signed !== "-";
                    }),
                EditAction::make(),
                ActionGroup::make([
                    ViewAction::make(),
                    Action::make('Print Dengan Tanda Tangan')
                        ->icon('heroicon-o-printer')
                        ->color('success')
                        ->hidden(function (Undangan $record): bool {
                            return $record->signed == '-';
                        })
                        ->url(fn (Undangan $record) => route('undangan.ttd.pdf', $record->id)),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
