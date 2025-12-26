<?php

namespace App\Filament\User\Resources\Undangans\Tables;

use App\Models\Judul;
use App\Models\Mahasiswa;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UndangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('judul.mahasiswa', fn ($q) => $q->where('id_user', auth()->id())))
            ->heading('Daftar Undangan Saya')
            ->description('Mohon Segera Tindak Lanjut Status Undangan Yang Belum Dikonfirmasi')
            ->emptyStateHeading('Belum Ada Undangan')
            ->emptyStateDescription('Belum Ada Pengajuan Undangan Untuk Anda.')
            ->columns([
                //
                TextColumn::make('judul.judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('perihal')
                    ->label('Perihal')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('statusUndangan.status_konfirmasi')
                    ->label('Status Konfirmasi'),
                TextColumn::make('status_ujian')
                ->label('Status Kesiapan Ujian')
                    ->formatStateUsing(function ($state):string {
                        if ($state == 'dijadwalkan'){
                            return 'Di Jadwalkan';
                        } elseif ($state == 'draft_uploaded') {
                            return 'Draft Diupload';
                        } elseif ($state == 'ready_to_exam'){
                            return 'Ujian Siap Dilaksanakan';
                        } elseif ($state == 'gagal_menjadwalkan_ujian')
                            return 'Gagal Menjadwalkan Ujian';
                        return $state;
                    }),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
             ]);
    }
}
