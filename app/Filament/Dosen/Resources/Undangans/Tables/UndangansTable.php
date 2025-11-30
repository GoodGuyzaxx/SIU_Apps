<?php

namespace App\Filament\Dosen\Resources\Undangans\Tables;

use App\Filament\Dosen\Resources\Undangans\Pages\DetailUndangan;
use App\Models\Undangan;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('judul.mahasiswa.nama')
                ->label("Nama Mahasiswa"),
                TextColumn::make('judul.judul')
                ->label("Judul")
                ->limit(30),
                TextColumn::make('status_ujian')
                ->label("Status Kesiapan Ujian")
                    ->formatStateUsing(function ($state):string {
                        if ($state == 'dijadwalkan'){
                            return 'Di Jadwalkan';
                        } elseif ($state == 'draft_uploaded') {
                            return 'Draft Diupload';
                        } elseif ($state == 'ready_to_exam'){
                            return 'Ujian Siap Dilaksanakan';
                        }
                        return $state;
                    }),
                TextColumn::make('Status')
                    ->label('Status Konfirmasi')
                    ->default(function (Undangan $record): string {
                        return $record->statusUndangan->where('id_dosen', auth()->user()->id)->first()->status_konfirmasi;
                    })

            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function ($query) {
                return $query->whereHas('statusUndangan', function ($query) {
                    $query->where('id_dosen', auth()->user()->id);
                })->where('status_ujian', '!=', 'dijadwalkan');
            })
            ->heading('Daftar Undangan Saya')
            ->description('Mohon Segera Tindak Lanjut Status Undangan Yang Belum Dikonfirmasi')
            ->recordUrl(fn ($record) => DetailUndangan::getUrl(['record' => $record]))
            ->recordActions([
                Action::make('Detail')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => DetailUndangan::getUrl(['record' => $record])),
            ])
            ->emptyStateHeading('Belum Ada Undangan')
            ->emptyStateDescription('Belum Ada Pengajuan Undangan Untuk Anda.');

    }
}
