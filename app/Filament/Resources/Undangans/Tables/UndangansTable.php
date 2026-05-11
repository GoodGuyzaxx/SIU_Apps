<?php

namespace App\Filament\Resources\Undangans\Tables;

use App\Models\AccKesiapanUjian;
use App\Models\Prodi;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('judul.mahasiswa.nama')
            ->label('Nama Mahasiswa')
            ->searchable(),

            TextColumn::make('judul.mahasiswa.npm')
            ->label('NPM')
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
                    'menunggu_acc' => 'Menunggu ACC Dosen',
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
            SelectFilter::make('prodi_id')
                ->label('Program Studi')
                ->native(false)
                ->options(Prodi::query()->pluck('nama_prodi', 'id'))
                ->query(function (Builder $query, array $data): Builder {
                    if (empty($data['value'])) {
                        return $query;
                    }
                    return $query->whereHas('judul.mahasiswa', function (Builder $q) use ($data) {
                        $q->where('prodi_id', $data['value']);
                    });
                }),
        ])
            ->defaultSort('created_at', 'desc')
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
            ->modalHeading('Preview Undangan')
            ->modalContent(fn (Undangan $record) => view('filament.modals.pdf-preview', [
                'url' => route('undangan.pdf', $record->id),
            ]))
            ->modalWidth('7xl')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup'),
            Action::make('Print Dengan Tanda Tangan')
            ->icon('heroicon-o-printer')
            ->color('success')
            ->hidden(function (Undangan $record): bool {
            return $record->signed == '-';
        })
            ->modalHeading('Preview Undangan (Tanda Tangan)')
            ->modalContent(fn (Undangan $record) => view('filament.modals.pdf-preview', [
                'url' => route('undangan.ttd.pdf', $record->id),
            ]))
            ->modalWidth('7xl')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup'),


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
