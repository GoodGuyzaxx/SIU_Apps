<?php

namespace App\Filament\Dosen\Resources\Undangans\Tables;

use App\Filament\Dosen\Resources\Undangans\Pages\DetailUndangan;
use App\Models\Dosen;
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
            TextColumn::make('Status')
            ->label('Status Konfirmasi')
            ->default(function (Undangan $record): string {
            return $record->statusUndangan->where('id_dosen', auth()->user()->dosen->id)->first()->status_konfirmasi;
        })

        ])
            ->filters([
            //
        ])
            ->modifyQueryUsing(function ($query) {
            return $query->whereHas('statusUndangan', function ($query) {
                    $query->where('id_dosen', auth()->user()->dosen->id);
                }
                )->whereNotIn('status_ujian', ['dijadwalkan']);
            })
            ->heading('Daftar Undangan Saya')
            ->description('Mohon Segera Tindak Lanjut Status Undangan Yang Belum Dikonfirmasi')
            ->recordUrl(fn($record) => DetailUndangan::getUrl(['record' => $record]))
            ->recordActions([
            Action::make('Detail')
            ->label('Detail')
            ->icon('heroicon-o-eye')
            ->url(fn($record) => DetailUndangan::getUrl(['record' => $record])),
        ])
            ->emptyStateHeading('Belum Ada Undangan')
            ->emptyStateDescription('Belum Ada Pengajuan Undangan Untuk Anda.');

    }
}