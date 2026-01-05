<?php

namespace App\Filament\User\Resources\Pengajuans\Tables;

use App\Filament\User\Resources\Pengajuans\Pages\DetailPengajuan;
use App\Models\Mahasiswa;
use App\Models\UsulanJudul;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuansTable
{

    public static function configure(Table $table): Table
    {
        $mahasiswa = Mahasiswa::where('id_user', auth()->id())->first();

        return $table
            ->columns([
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
                    ->sortable(),
            ])
            ->filters([
                // Filters yang bisa diubah user (opsional)
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Pengajuan' => 'Pengajuan',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                    ]),
            ])
            // PERMANENT FILTER
            ->modifyQueryUsing(function ($query) use ($mahasiswa) {
                if ($mahasiswa) {
                    return $query->where('id_mahasiswa', $mahasiswa->id);
                }
                return $query->whereRaw('1 = 0');
            })
            // Header untuk menunjukkan filter aktif
            ->heading('Pengajuan Judul Saya')
            ->description($mahasiswa ?
                "Menampilkan pengajuan untuk: {$mahasiswa->nama} (NPM: {$mahasiswa->npm})" :
                "Tidak ada data mahasiswa"
            )
            ->defaultSort('created_at', 'desc')
            ->recordActions([
            Action::make('Detail')
                ->label('Detail')
                ->color('success')
                ->icon('heroicon-o-eye')
                ->url(fn (UsulanJudul $record) => DetailPengajuan::getUrl([$record->id])),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->emptyStateHeading('Belum Ada Pengajuan')
            ->emptyStateDescription('Anda belum membuat pengajuan judul skripsi.')
            ->emptyStateActions([

            ]);
    }
}
