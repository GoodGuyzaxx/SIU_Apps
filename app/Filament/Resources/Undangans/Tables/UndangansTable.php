<?php

namespace App\Filament\Resources\Undangans\Tables;

use App\Models\AccKesiapanUjian;
use App\Models\Undangan;
use App\Services\WhatsappService;
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
            ->toggleable()
            ->limit(20),
            TextColumn::make('tanggal_hari')
            ->date()
            ->sortable(),
            TextColumn::make('waktu')
            ->time()
            ->dateTime("H:II")
            ->sortable(),
            TextColumn::make('status_ujian')
            ->searchable()
            ->formatStateUsing(function ($state): string {
            return match ($state) {
                    'menunggu_acc' => 'Menunggu ACC Penguji 1',
                    'dijadwalkan' => 'Di Jadwalkan',
                    'draft_uploaded' => 'Draft Diupload',
                    'ready_to_exam' => 'Ujian Siap Dilaksanakan',
                    'selesai' => 'Ujian Selesai',
                    'gagal_menjadwalkan_ujian' => 'Gagal Menjadwalkan Ujian',
                    default => $state,
                };
        })
            ->badge()
            ->color(fn(string $state): string => match ($state) {
            'menunggu_acc' => 'warning',
            'dijadwalkan' => 'info',
            'draft_uploaded' => 'info',
            'ready_to_exam' => 'success',
            'selesai' => 'success',
            'gagal_menjadwalkan_ujian' => 'danger',
            default => 'gray',
        }),

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
            $dataRole = ['admin', 'kaprodi'];
            if (in_array(auth()->user()->role, $dataRole)) {
                return true;
            }
            return false;
        })
            ->hidden(function (Undangan $record): bool {
            return $record->signed !== "-";
        }),
            Action::make('Print')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->url(fn(Undangan $record) => route('undangan.pdf', $record->id))
            ->openUrlInNewTab(true),
            Action::make('Print Dengan Tanda Tangan')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->hidden(function (Undangan $record): bool {
            return $record->signed == '-';
        })
            ->url(fn(Undangan $record) => route('undangan.ttd.pdf', $record->id))
            ->openUrlInNewTab(),
            Action::make('Kirim Ulang ACC')
            ->icon('heroicon-o-paper-airplane')
            ->color('warning')
            ->requiresConfirmation()
            ->modalDescription('Kirim ulang permintaan ACC kesiapan ujian ke Penguji 1 via WhatsApp?')
            ->modalSubmitActionLabel('Ya, Kirim Ulang')
            ->visible(function (Undangan $record): bool {
            return $record->status_ujian === 'menunggu_acc';
        })
            ->action(function (Undangan $record): void {
            $acc = AccKesiapanUjian::where('id_undangan', $record->id)->first();
            if ($acc) {
                $waService = new WhatsappService();
                $sent = $waService->sendAccKesiapanRequest($acc);
                if ($sent) {
                    Notification::make()
                        ->title('ACC Berhasil Dikirim Ulang')
                        ->success()
                        ->send();
                }
                else {
                    Notification::make()
                        ->title('Gagal Mengirim ACC')
                        ->body('Periksa konfigurasi WhatsApp API.')
                        ->danger()
                        ->send();
                }
            }
        }),
            ActionGroup::make([
                ViewAction::make(),
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